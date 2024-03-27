<?php
namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\CustomField;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\Transfers;
use App\Models\TransferProduct;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\PurchasePayment;
use App\Models\StockReport;
use App\Models\Transaction;
use App\Models\Vender;
use App\Models\User;
use App\Models\Utility;
use App\Models\TaxChargesType;
use App\Models\StatusType;
use App\Models\TaxChargesHasValues;
use App\Models\ManageStock;
use Illuminate\Support\Facades\Crypt;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Double;

class TransfersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $vender->prepend('Select Vendor', '');
        $status = Purchase::$statues;
        $transfer = Transfers::where('created_by', '=', \Auth::user()->creatorId())->get();
       /* echo "<pre>";
        print_r($transfers); exit;*/
        

        return view('transfers.index', compact('transfer', 'status','vender'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendorId)
    {
        if(\Auth::user()->can('create purchase'))
        {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'purchase')->get();
            $category     = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            $transfer_number = \Auth::user()->transferNumberFormat($this->transfersNumber());
            $venders     = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $venders->prepend('Select Vender', '');

            $warehouse     = warehouse::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $warehouse->prepend('Select Warehouse', '');

            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services->prepend('--', '');

            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();
           
            return view('transfers.create', compact('venders', 'transfer_number', 'product_services', 'category', 'customFields','vendorId','warehouse', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(\Auth::user()->can('create purchase'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'from_warehouse_id' => 'required',
                    'to_warehouse_id' => 'required',
                    'transfer_date' => 'required',
                    'items' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $transfers                 = new Transfers();
            $transfers->transfer_id    = $this->transfersNumber();
            $transfers->from_warehouse_id      = $request->from_warehouse_id;
            $transfers->to_warehouse_id      = $request->to_warehouse_id;
            $transfers->transfer_date       = $request->transfer_date;
            $transfers->transfer_number   = !empty($request->transfer_number) ? $request->transfer_number : 0;
            $transfers->status = !empty($request->status) ? $request->status : 0;
            $transfers->description = !empty($request->description) ? $request->description : '';
            $transfers->discount_apply = !empty($request->discount) ? 1 : 0;
            $transfers->discount = !empty($request->discount) ? (Double)$request->discount : 0;   
            $transfers->created_by     = \Auth::user()->creatorId();

            $transfers->save();

            $products = $request->items;

            for($i = 0; $i < count($products); $i++)
            {
                $transferProduct              = new TransferProduct();
                $transferProduct->transfer_id     = $transfers->id;
                $transferProduct->product_id  = $products[$i]['item'];
                $transferProduct->quantity    = $products[$i]['quantity'];
                $transferProduct->tax         = $products[$i]['tax'];
                $transferProduct->price       = $products[$i]['price'];
                $transferProduct->save();                               
            }
            if(!empty($request['status']) && $request['status'] == '1'){
               foreach ($products as  $value) {
                   $product = ManageStock::whereWarehouseId($request['from_warehouse_id'])->whereProductId($value['item'])->first();

                    if ($product) {
                        if ($value['quantity'] > $product->quantity) {
                            return redirect()->back()->with('error', __('Quantity should not be greater than available quantity.'));
                        } 
                        else 
                        {                               
                            $exceptQuantity = $product->quantity - $value['quantity'];
                            $product->update(['quantity' => $exceptQuantity]);                      
                        }     
                    } 
                    else 
                    {
                       return redirect()->back()->with('error', __('Product stock is not available in selected warehouse.'));
                    }  
                } 
            }

            

          
            #save tax charges
             $this->save_tax_charges($request, $transfers);

            return redirect()->route('transfer.index', $purchase->id)->with('success', __('Transfer successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($ids)
    {

        if(\Auth::user()->can('show purchase'))
        {
            $id   = Crypt::decrypt($ids);
            $transfer = Transfers::find($id);

            if($transfer->created_by == \Auth::user()->creatorId())
            {

                $purchasePayment = PurchasePayment::where('purchase_id', $transfer->id)->first();
                $vendor      = $transfer->vender;
                $iteams      = $transfer->items;
                $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$transfer->transfer_id)->where('slug', 'tax')->where('module', 'transfer')->get();
                $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$transfer->transfer_id)->where('slug', 'shipping')->where('module', 'transfer')->get();
                $status = StatusType::find($transfer->status);
                  

                return view('transfers.view', compact('transfer', 'vendor', 'iteams', 'status', 'purchasePayment', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($idsd)
    {
        if(\Auth::user()->can('edit purchase'))
        {

            $idwww   = Crypt::decrypt($idsd);
            $transfer     = Transfers::find($idwww);
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $warehouse     = warehouse::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$transfer->transfer_id)->where('slug', 'tax')->where('module', 'transfer')->get();
            $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$transfer->transfer_id)->where('slug', 'shipping')->where('module', 'transfer')->get();

            $purchase_number      = \Auth::user()->transferNumberFormat($transfer->transfer_id);
            $venders          = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();

           
            return view('transfers.edit', compact('venders', 'product_services', 'transfer', 'warehouse','purchase_number', 'category', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transfers $transfers)
    {
        if(\Auth::user()->can('edit purchase'))
        {
            if($transfers)
            {
                $transferItemOldIds = TransferProduct::whereTransferId($id)->pluck('id')->toArray();
                $transferItemNewIds = [];
                $validator = \Validator::make(
                    $request->all(), [
                        'transfer_date' => 'required',
                        'items' => 'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('transfer.index')->with('error', $messages->first());
                }
                $transfers->transfer_date      = @$request->transfer_date;
                $transfers->description = !empty($request->description) ? $request->description : '';
                $transfers->discount_apply = !empty($request->discount) ? 1 : 0;
                $transfers->discount = $request->discount;
                $transfers->status = !empty($request->status) ? $request->status : 0;

                $transfers->save();
                $products = @$request->items;
                $purchaseItemIds = TransferProduct::where('transfer_id',$id)->pluck('id')->toArray();
                $purchaseItmOldIds = [];
                for($i = 0; $i < count($products); $i++)
                {
                    $purchaseItmOldIds[$i] = $products[$i]['item'];
                    $transferProduct = TransferProduct::find($products[$i]['id']);
                    if($transferProduct == null)
                    {
                        $transferProduct             = new TransferProduct();
                        $transferProduct->transfer_id    = $transfers->id;
                    }

                    if(isset($products[$i]['item']))
                    {
                        $transferProduct->product_id = $products[$i]['item'];
                    }

                    $transferProduct->quantity    = $products[$i]['quantity'];
                    $transferProduct->tax         = $products[$i]['tax'];
                    $transferProduct->price       = $products[$i]['price'];
                    $transferProduct->save();
                    $transferItemNewIds[$i] = $products[$i]['item'];
                                         
                    }
                   if(!empty($request['status']) && $request['status'] == '2'){
                        foreach ($products as  $value) {
                       $product = ManageStock::whereWarehouseId($request['from_warehouse_id'])->whereProductId($value['item'])->first();

                        if ($product) {
                                if(!empty($request['status']) && $request['status'] == '2')
                                    {
                                        Utility::manageStock($request['to_warehouse_id'], $value['item'], $value['quantity']);
                                    }
                            
                            } else {
                               return redirect()->back()->with('error', __('Product stock is not available in selected warehouse.'));
                            }  
                        }
                    }

                    $removeItemIds = array_diff($transferItemOldIds, $transferItemNewIds);

                        if (!empty(array_values($removeItemIds))) {
                        foreach ($removeItemIds as $removeItemId) {
                            $oldTransferItem = TransferProduct::whereId($removeItemId)->first();
                            $oldTransfer = Transfer::whereId($oldTransferItem->transfer_id)->first();
                            $fromManageStock = ManageStock::whereWarehouseId($oldTransfer->from_warehouse_id)->whereProductId($oldTransferItem->product_id)->first();
                            $toManageStock = ManageStock::whereWarehouseId($oldTransfer->to_warehouse_id)->whereProductId($oldTransferItem->product_id)->first();

                            $toquantity = 0;

                            if ($toManageStock) {
                                $toquantity = $toquantity - $oldTransferItem->quantity;
                                 Utility::manageStock($toManageStock->warehouse_id, $oldTransferItem->product_id, $toquantity);
                            }

                            $fromQuantity = 0;

                            $fromQuantity = $fromQuantity + $oldTransferItem->quantity;

                             Utility::manageStock($oldTransfer->from_warehouse_id, $oldTransferItem->product_id, $fromQuantity);
                        }

                        TransferProduct::whereIn('id', array_values($removeItemIds))->delete();
                    }

                
                
               #save tax charges
                $this->save_tax_charges($request, $transfers);
                return redirect()->route('transfer.index')->with('success', __('Transfer successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function save_tax_charges($request, $transfers){
         #Tax charges
        TaxChargesHasValues::where('purchase_sale_id', $transfers->id)->where('module', 'transfer')->delete();
         if(!empty($request->tax_type) && count($request->tax_type)>0){
            for($j=0; $j<count($request->tax_type); $j++){
                if($request->tax_type[$j]){
                        $taxChargesTypes = TaxChargesType::find($request->tax_type[$j]);
                    TaxChargesHasValues::create(
                        [
                            'charges_type_id' =>  (!empty($taxChargesTypes->id) ? $taxChargesTypes->id : ''),
                            'charges_type_name' => (!empty($taxChargesTypes->name) ? $taxChargesTypes->name : ''),
                            'purchase_sale_id' =>   (!empty($transfers->id) ? $transfers->id : ''),
                            'slug' => 'tax',
                            'module' => 'transfer',
                            'tax_rate' => (!empty($request->tax_charges[$j]) ? $request->tax_charges[$j] : 0),
                        ]
                    ); 
            }
          }
        }

            #Shipping charges
            if(!empty($request->shipping_type) && count($request->shipping_type)>0){
                for($j=0; $j<count($request->shipping_type); $j++){
                    if($request->shipping_type[$j]){
                            $shippingChargesTypes = TaxChargesType::find($request->shipping_type[$j]);
                        TaxChargesHasValues::create(
                            [
                                'charges_type_id' =>  (!empty($shippingChargesTypes->id) ? $shippingChargesTypes->id : ''),
                                'charges_type_name' => (!empty($shippingChargesTypes->name) ? $shippingChargesTypes->name : ''),
                                'purchase_sale_id' =>   (!empty($transfers->id) ? $transfers->id : ''),
                                'slug' => 'shipping',
                                'module' => 'transfer',
                                'tax_rate' => (!empty($request->shipping_charges[$j]) ? $request->shipping_charges[$j] : 0),
                            ]
                        ); 
                }
              }
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfers $transfers)
    {
        if(\Auth::user()->can('delete purchase'))
        {
            if($transfers->created_by == \Auth::user()->creatorId())
            {
//                $purchasepayments = $purchase->payments;
//                foreach($purchasepayments as $key => $value)
//                {
//                    $transaction= Transaction::where('payment_id',$value->id)->first();
//                    $transaction->delete();
//
//                    $purchasepayment = PurchasePayment::find($value->id)->first();
//                    $purchasepayment->delete();
//
//                }
                $transfers->delete();
//                if($purchase->vender_id != 0)
//                {
//                    Utility::userBalance('vendor', $purchase->vender_id, $purchase->getTotal(), 'debit');
//                }
                TransferProduct::where('transfer_id', '=', $transfers->id)->delete();

                return redirect()->route('transfers.index')->with('success', __('Transfers successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    function transfersNumber()
    {
        $latest = Transfers::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->transfer_id + 1;
    }
    public function sent($id)
    {
        if(\Auth::user()->can('send purchase'))
        {
            $transfers            = Transfers::where('id', $id)->first();
            $transfers->send_date = date('Y-m-d');
            $transfers->status    = 1;
            $transfers->save();

            $vender = Vender::where('id', $transfers->vender_id)->first();

            $transfers->name = !empty($vender) ? $vender->name : '';
            $transfers->purchase = \Auth::user()->transferNumberFormat($transfers->purchase_id);

            $purchaseId    = Crypt::encrypt($transfers->id);
            $transfers->url = route('transfer.pdf', $purchaseId);

            Utility::userBalance('vendor', $vender->id, $transfers->getTotal(), 'credit');

            $vendorArr = [
                'vender_bill_name' => $transfers->name,
                'vender_bill_number' =>$transfers->transfers,
                'vender_bill_url' => $transfers->url,

            ];
            $resp = \App\Models\Utility::sendEmailTemplate('vender_bill_sent', [$vender->id => $vender->email], $vendorArr);


            return redirect()->back()->with('success', __('Purchase successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function resent($id)
    {

        if(\Auth::user()->can('send purchase'))
        {
            $transfers = Transfers::where('id', $id)->first();

            $vender = Vender::where('id', $transfers->vender_id)->first();

            $transfers->name = !empty($vender) ? $vender->name : '';
            $transfers->transfers = \Auth::user()->transferNumberFormat($transfers->purchase_id);

            $purchaseId    = Crypt::encrypt($transfers->id);
            $transfers->url = route('transfer.pdf', $purchaseId);
//

        // Send Email
//        $setings = Utility::settings();
//
//        if($setings['bill_resend'] == 1)
//        {
//            $bill = Bill::where('id', $id)->first();
//            $vender = Vender::where('id', $bill->vender_id)->first();
//            $bill->name = !empty($vender) ? $vender->name : '';
//            $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);
//            $billId    = Crypt::encrypt($bill->id);
//            $bill->url = route('bill.pdf', $billId);
//            $billResendArr = [
//                'vender_name'   => $vender->name,
//                'vender_email'  => $vender->email,
//                'bill_name'  => $bill->name,
//                'bill_number'   => $bill->bill,
//                'bill_url' =>$bill->url,
//            ];
//
//            $resp = Utility::sendEmailTemplate('bill_resend', [$vender->id => $vender->email], $billResendArr);
//
//
//        }
//
//        return redirect()->back()->with('success', __('Bill successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
//
        return redirect()->back()->with('success', __('Bill successfully sent.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function purchase($transfer_id)
    {


        $settings = Utility::settings();
        $purchaseId   = Crypt::decrypt($transfer_id);

        $purchase  = Purchase::where('id', $purchaseId)->first();
        $data  = DB::table('settings');
        $data  = $data->where('created_by', '=', $purchase->created_by);
        $data1 = $data->get();

        foreach($data1 as $row)
        {
            $settings[$row->name] = $row->value;
        }

        $vendor = $purchase->vender;

        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];
        $items         = [];

        foreach($purchase->items as $product)
        {

            $item              = new \stdClass();
            $item->name        = !empty($product->product()) ? $product->product()->name : '';
            $item->quantity    = $product->quantity;
            $item->tax         = $product->tax;
            $item->discount    = $product->discount;
            $item->price       = $product->price;
            $item->description = $product->description;

            $totalQuantity += $item->quantity;
            $totalRate     += $item->price;
            $totalDiscount += $item->discount;

            $taxes     = Utility::tax($product->tax);
            $itemTaxes = [];
            if(!empty($item->tax))
            {
                foreach($taxes as $tax)
                {
                    $taxPrice      = Utility::taxRate($tax->rate, $item->price, $item->quantity);
                    $totalTaxPrice += $taxPrice;

                    $itemTax['name']  = $tax->name;
                    $itemTax['rate']  = $tax->rate . '%';
                    $itemTax['price'] = Utility::priceFormat($settings, $taxPrice);
                    $itemTaxes[]      = $itemTax;


                    if(array_key_exists($tax->name, $taxesData))
                    {
                        $taxesData[$tax->name] = $taxesData[$tax->name] + $taxPrice;
                    }
                    else
                    {
                        $taxesData[$tax->name] = $taxPrice;
                    }

                }

                $item->itemTax = $itemTaxes;
            }
            else
            {
                $item->itemTax = [];
            }
            $items[] = $item;
        }

        $purchase->itemData      = $items;
        $purchase->totalTaxPrice = $totalTaxPrice;
        $purchase->totalQuantity = $totalQuantity;
        $purchase->totalRate     = $totalRate;
        $purchase->totalDiscount = $totalDiscount;
        $purchase->taxesData     = $taxesData;


        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));


        if($purchase)
        {
            $color      = '#' . $settings['purchase_color'];
            $font_color = Utility::getFontColor($color);

            return view('transfers.templates.' . $settings['purchase_template'], compact('purchase', 'color', 'settings', 'vendor', 'img', 'font_color'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function previewPurchase($template, $color)
    {
        $objUser  = \Auth::user();
        $settings = Utility::settings();
        $purchase     = new Purchase();

        $vendor                   = new \stdClass();
        $vendor->email            = '<Email>';
        $vendor->shipping_name    = '<Vendor Name>';
        $vendor->shipping_country = '<Country>';
        $vendor->shipping_state   = '<State>';
        $vendor->shipping_city    = '<City>';
        $vendor->shipping_phone   = '<Vendor Phone Number>';
        $vendor->shipping_zip     = '<Zip>';
        $vendor->shipping_address = '<Address>';
        $vendor->billing_name     = '<Vendor Name>';
        $vendor->billing_country  = '<Country>';
        $vendor->billing_state    = '<State>';
        $vendor->billing_city     = '<City>';
        $vendor->billing_phone    = '<Vendor Phone Number>';
        $vendor->billing_zip      = '<Zip>';
        $vendor->billing_address  = '<Address>';

        $totalTaxPrice = 0;
        $taxesData     = [];
        $items         = [];
        for($i = 1; $i <= 3; $i++)
        {
            $item           = new \stdClass();
            $item->name     = 'Item ' . $i;
            $item->quantity = 1;
            $item->tax      = 5;
            $item->discount = 50;
            $item->price    = 100;

            $taxes = [
                'Tax 1',
                'Tax 2',
            ];

            $itemTaxes = [];
            foreach($taxes as $k => $tax)
            {
                $taxPrice         = 10;
                $totalTaxPrice    += $taxPrice;
                $itemTax['name']  = 'Tax ' . $k;
                $itemTax['rate']  = '10 %';
                $itemTax['price'] = '$10';
                $itemTaxes[]      = $itemTax;
                if(array_key_exists('Tax ' . $k, $taxesData))
                {
                    $taxesData['Tax ' . $k] = $taxesData['Tax 1'] + $taxPrice;
                }
                else
                {
                    $taxesData['Tax ' . $k] = $taxPrice;
                }
            }
            $item->itemTax = $itemTaxes;
            $items[]       = $item;
        }

        $purchase->purchase_id    = 1;
        $purchase->issue_date = date('Y-m-d H:i:s');
//        $purchase->due_date   = date('Y-m-d H:i:s');
        $purchase->itemData   = $items;

        $purchase->totalTaxPrice = 60;
        $purchase->totalQuantity = 3;
        $purchase->totalRate     = 300;
        $purchase->totalDiscount = 10;
        $purchase->taxesData     = $taxesData;
        $purchase->created_by     = $objUser->creatorId();

        $preview      = 1;
        $color        = '#' . $color;
        $font_color   = Utility::getFontColor($color);

        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $settings_data = \App\Models\Utility::settingsById($purchase->created_by);
        $purchase_logo = $settings_data['purchase_logo'];

        if(isset($purchase_logo) && !empty($purchase_logo))
        {
            $img = Utility::get_file('purchase_logo/') . $purchase_logo;
        }
        else{
            $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        return view('purchase.templates.' . $template, compact('purchase', 'preview', 'color', 'img', 'settings', 'vendor', 'font_color'));
    }

    public function savePurchaseTemplateSettings(Request $request)
    {
        $post = $request->all();
        unset($post['_token']);

        if(isset($post['purchase_template']) && (!isset($post['purchase_color']) || empty($post['purchase_color'])))
        {
            $post['purchase_color'] = "ffffff";
        }


        if($request->purchase_logo)
        {
            $dir = 'purchase_logo/';
            $purchase_logo = \Auth::user()->id . '_purchase_logo.png';
            $validation =[
                'mimes:'.'png',
                'max:'.'20480',
            ];
            $path = Utility::upload_file($request,'purchase_logo',$purchase_logo,$dir,$validation);
            if($path['flag']==0)
            {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $post['purchase_logo'] = $purchase_logo;
        }

        foreach($post as $key => $data)
        {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ', [
                    $data,
                    $key,
                    \Auth::user()->creatorId(),
                ]
            );
        }

        return redirect()->back()->with('success', __('Purchase Setting updated successfully'));
    }

    public function items(Request $request)
    {

        $items = TransferProduct::where('transfer_id', $request->purchase_id)->where('product_id', $request->product_id)->first();
        
        return json_encode($items);
    }

    public function purchaseLink($purchaseId)
    {
        $id             = Crypt::decrypt($purchaseId);
        $purchase       = Transfers::find($id);

        $user_id        = $purchase->created_by;
        $user           = User::find($user_id);

        $purchasePayment = PurchasePayment::where('purchase_id', $purchase->id)->first();
        $vendor = $purchase->vender;
        $iteams   = $purchase->items;

        return view('transfer.customer_bill', compact('purchase', 'vendor', 'iteams','purchasePayment','user'));
    }

    public function payment($purchase_id)
    {
        if(\Auth::user()->can('create payment purchase'))
        {
            $purchase    = Transfers::where('id', $purchase_id)->first();
            $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('transfer.payment', compact('venders', 'categories', 'accounts', 'purchase'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    public function createPayment(Request $request, $purchase_id)
    {
        if(\Auth::user()->can('create payment purchase'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'date' => 'required',
                    'amount' => 'required',
                    'account_id' => 'required',

                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $purchasePayment                 = new PurchasePayment();
            $purchasePayment->purchase_id        = $purchase_id;
            $purchasePayment->date           = $request->date;
            $purchasePayment->amount         = $request->amount;
            $purchasePayment->account_id     = $request->account_id;
            $purchasePayment->payment_method = 0;
            $purchasePayment->reference      = $request->reference;
            $purchasePayment->description    = $request->description;
            if(!empty($request->add_receipt))
            {
                $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                $request->add_receipt->storeAs('uploads/payment', $fileName);
                $purchasePayment->add_receipt = $fileName;
            }
            $purchasePayment->save();

            $purchase  = Transfers::where('id', $purchase_id)->first();
            $due   = $purchase->getDue();
            $total = $purchase->getTotal();

            if($purchase->status == 0)
            {
                $purchase->send_date = date('Y-m-d');
                $purchase->save();
            }

            if($due <= 0)
            {
                $purchase->status = 4;
                $purchase->save();
            }
            else
            {
                $purchase->status = 3;
                $purchase->save();
            }
            $purchasePayment->user_id    = $purchase->vender_id;
            $purchasePayment->user_type  = 'Vender';
            $purchasePayment->type       = 'Partial';
            $purchasePayment->created_by = \Auth::user()->id;
            $purchasePayment->payment_id = $purchasePayment->id;
            $purchasePayment->category   = 'Bill';
            $purchasePayment->account    = $request->account_id;
            Transaction::addTransaction($purchasePayment);

            $vender = Vender::where('id', $purchase->vender_id)->first();

            $payment         = new PurchasePayment();
            $payment->name   = $vender['name'];
            $payment->method = '-';
            $payment->date   = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->bill   = 'bill ' . \Auth::user()->transferNumberFormat($purchasePayment->purchase_id);

            Utility::userBalance('vendor', $purchase->vender_id, $request->amount, 'debit');

            Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');

            // Send Email
            $setings = Utility::settings();
            if($setings['new_bill_payment'] == 1)
            {

                $vender = Vender::where('id', $purchase->vender_id)->first();
                $billPaymentArr = [
                    'vender_name'   => $vender->name,
                    'vender_email'  => $vender->email,
                    'payment_name'  =>$payment->name,
                    'payment_amount'=>$payment->amount,
                    'payment_bill'  =>$payment->bill,
                    'payment_date'  =>$payment->date,
                    'payment_method'=>$payment->method,
                    'company_name'=>$payment->method,

                ];


                $resp = Utility::sendEmailTemplate('new_bill_payment', [$vender->id => $vender->email], $billPaymentArr);

                return redirect()->back()->with('success', __('Payment successfully added.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

            return redirect()->back()->with('success', __('Payment successfully added.'));
        }

    }

    public function paymentDestroy(Request $request, $purchase_id, $payment_id)
    {

        if(\Auth::user()->can('delete payment purchase'))
        {
            $payment = PurchasePayment::find($payment_id);
            PurchasePayment::where('id', '=', $payment_id)->delete();

            $purchase = Transfers::where('id', $purchase_id)->first();

            $due   = $purchase->getDue();
            $total = $purchase->getTotal();

            if($due > 0 && $total != $due)
            {
                $purchase->status = 3;

            }
            else
            {
                $purchase->status = 2;
            }

            Utility::userBalance('vendor', $purchase->vender_id, $payment->amount, 'credit');
            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

            $purchase->save();
            $type = 'Partial';
            $user = 'Vender';
            Transaction::destroyTransaction($payment_id, $type, $user);

            return redirect()->back()->with('success', __('Payment successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function vender(Request $request)
    {
        $vender = Vender::where('id', '=', $request->id)->first();

        return view('transfer.vender_detail', compact('vender'));
    }
    public function product(Request $request)
    {


        $data['product']     = $product = ProductService::find($request->product_id);
        $data['unit']        = !empty($product->unit()) ? $product->unit()->name : '';
        $data['taxRate']     = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes']       = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        $salePrice           = $product->purchase_price;
        $quantity            = 1;
        $taxPrice            = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);
        $totalstock = Utility::getWarehouseProductStock(@$request->product_id, @$request->warehouse_id);
        $data['totalstock'] = !empty($totalstock) ? $totalstock : 0;

        return json_encode($data);
    }

    public function productDestroy(Request $request)
    {
        if(\Auth::user()->can('delete purchase'))
        {
            PurchaseProduct::where('id', '=', $request->id)->delete();

            return redirect()->back()->with('success', __('Purchase product successfully deleted.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }








}
