<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\CustomField;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\SalePayment;
use App\Models\ManageStock;
use App\Models\StockReport;
use App\Models\Transaction;
use App\Models\Vender;
use App\Models\Customer;
use App\Models\User;
use App\Models\Utility;
use App\Models\TaxChargesType;
use App\Models\StatusType;
use App\Models\TaxChargesHasValues;
use Illuminate\Support\Facades\Crypt;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Double;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $vender = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
        $vender->prepend('Select Customer', '');
        $status = Sale::$statues;
        $sales = Sale::where('created_by', '=', \Auth::user()->creatorId())->get();
        

        return view('sales.index', compact('sales', 'status','vender'));


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
            $category     = ProductServiceCategory::where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            $sale_number = \Auth::user()->saleNumberFormat($this->saleNumber());
            $venders     = Customer::get()->pluck('name', 'id');
            $venders->prepend('Select Customer', '');

            $warehouse     = warehouse::get()->pluck('name', 'id');
            $warehouse->prepend('Select Warehouse', '');

            $product_services = ProductService::get()->pluck('name', 'id');
            $product_services->prepend('--', '');

            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();
           
            return view('sales.create', compact('venders', 'product_services', 'sale_number', 'sale_services', 'category', 'customFields','vendorId','warehouse', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes'));
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
                    'customer_id' => 'required',
                    'warehouse_id' => 'required',
                    'sale_date' => 'required',
                    'items' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $sale                 = new Sale();
            $sale->sale_id    = $this->saleNumber();
            $sale->customer_id      = $request->customer_id;
            $sale->warehouse_id      = $request->warehouse_id;
            $sale->sale_date  = $request->sale_date;
            $sale->sale_number   = !empty($request->sale_number) ? $request->sale_number : 0;
            $sale->status = !empty($request->status) ? $request->status : 0;
            $sale->description = !empty($request->description) ? $request->description : '';
            $sale->discount_apply = !empty($request->discount) ? 1 : 0;
            $sale->discount = !empty($request->discount) ? (Double)$request->discount : 0;   
            $sale->created_by     = \Auth::user()->creatorId();
            $sale->save();

            $sales = $request->items;

            for($i = 0; $i < count($sales); $i++)
            {
                $saleProduct              = new SaleProduct();
                $saleProduct->sale_id     = $sale->id;
                $saleProduct->product_id  = $sales[$i]['item'];
                $saleProduct->quantity    = $sales[$i]['quantity'];
                $saleProduct->tax         = $sales[$i]['tax'];
                $saleProduct->price       = $sales[$i]['price'];
                $saleProduct->save();


                //Warehouse Stock Report
                if(!empty($request->status) && $request->status == 1)
                {
                    Utility::updateWarehouseStock($sales[$i]['item'],$sales[$i]['quantity'],$request->warehouse_id);
               
                    foreach ($sales as $saleItem) {
                        $product = ManageStock::whereWarehouseId($request['warehouse_id'])->whereProductId($saleItem['item'])->first();
                        if ($product && $product->quantity >= $saleItem['quantity']) {
                            $totalQuantity = $product->quantity - $saleItem['quantity'];
                            $product->update([
                                'quantity' => $totalQuantity,
                            ]);
                        } else {
                            return redirect()->back()->with('error', __('Quantity must be less than Available quantity.'));
                        }
                    }
                }



            }
            #save tax charges
             $this->save_tax_charges($request, $sale);

            return redirect()->route('sale.index', $sale->id)->with('success', __('Sale successfully created.'));
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
            $sales = Sale::find($id);

            if($sales->created_by == \Auth::user()->creatorId())
            {
                $purchasePayment = SalePayment::where('sale_id', $sales->id)->first();
                $customer      =$sales->customer;
                $iteams      = $sales->items;
                $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales->sale_id)->where('slug', 'tax')->where('module', 'sale')->get();
                $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales->sale_id)->where('slug', 'shipping')->where('module', 'sale')->get();
                $status = StatusType::find($sales->status);

                return view('sales.view', compact('sales', 'customer', 'status', 'iteams', 'purchasePayment', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
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
            $sales     = Sale::find($idwww);
            $category = ProductServiceCategory::where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $warehouse     = warehouse::get()->pluck('name', 'id');
            $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales->sale_id)->where('slug', 'tax')->where('module', 'sale')->get();
            $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales->sale_id)->where('slug', 'shipping')->where('module', 'sale')->get();
            $sales_number      = \Auth::user()->saleNumberFormat($sales->sale_id);
            $venders          = Customer::get()->pluck('name', 'id');
            // $product_services = ProductService::get()->pluck('name', 'id');
            $product_services = $this->getPurchasedProduct($sales->warehouse_id);
            $product_services->prepend('Select Item', '');
            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();

           
            return view('sales.edit', compact('venders', 'product_services', 'sales', 'warehouse','sales_number', 'category', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    public function getPurchasedProduct($warehouse_id){
        $productList = \App\Models\Purchase::where('purchases.warehouse_id',$warehouse_id);
        $productList->leftjoin('purchase_products','purchases.id','purchase_products.purchase_id');
        $productList->leftjoin('product_services','purchase_products.product_id','product_services.id');
        $productList->select('product_services.*');
        $productList->groupBy('purchase_products.product_id');
        $productList =$productList->get()->pluck('name', 'id');;
        return $productList;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        if(\Auth::user()->can('edit purchase'))
        {
            $saleItemIds = SaleProduct::whereSaleId($id)->pluck('id')->toArray();
            $saleItmOldIds = [];
            if($sale)
            {
                $validator = \Validator::make(
                    $request->all(), [
                        'customer_id' => 'required',
                        'sale_date' => 'required',
                        'items' => 'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('sale.index')->with('error', $messages->first());
                }
                $sale->customer_id      = @$request->customer_id;
                $sale->sale_date      = @$request->sale_date;
                $sale->description = !empty($request->description) ? $request->description : '';
                $sale->discount_apply = !empty($request->discount) ? 1 : 0;
                $sale->discount = $request->discount;
                $sale->status = !empty($request->status) ? $request->status : 0;

                $sale->save();
                $sales = @$request->items;
                    
                for($i = 0; $i < count($sales); $i++)
                {
                    $saleItmOldIds[$i] = $saleItem['sale_id'];
                    $saleProduct = SaleProduct::find($sales[$i]['id']);

                    if($saleProduct == null)
                    {
                        $saleProduct             = new SaleProduct();
                        $saleProduct->sale_id    = $sale->id;
                    }

                    if(isset($sales[$i]['item']))
                    {
                        $saleProduct->product_id = $sales[$i]['item'];
                    }

                    $saleProduct->quantity    = $sales[$i]['quantity'];
                    $saleProduct->tax         = $sales[$i]['tax'];
                    $saleProduct->price       = $sales[$i]['price'];
                    $saleProduct->save();

                    if(isset($sales[$i]['item'])){
                        if(!empty($request->status) && $request->status == 1 )
                        {
                            Utility::updateWarehouseStock( $sales[$i]['item'],$sales[$i]['quantity'],$request->warehouse_id);
                        }

                    }

                }
                if(!empty($request->status) && $request->status == '1')
                    {
                      foreach ($sales as $key => $saleItem) {
                        $product = ManageStock::whereWarehouseId($request['warehouse_id'])->whereProductId($saleItem['item'])->first();
                        if ($product && $product->quantity != 0) {
                            if ($product->quantity >= $saleItem['quantity']) {
                                $product->update([
                                    'quantity' => $product->quantity - $saleItem['quantity'],
                                ]);
                            } /*else {
                                throw new UnprocessableEntityHttpException("Quantity must be less than Available quantity.");
                            }*/
                         }
                        }
                    }

                $removeItemIds = array_diff($saleItemIds, $saleItmOldIds);
            //delete remove product
            /*if($request['status'] == '1')
            {
                if (!empty(array_values($removeItemIds))) {
                    foreach ($removeItemIds as $removeItemId) {
                        // remove quantity manage storage
                        $oldProduct = SaleProduct::whereId($removeItemId)->first();
                        $productQuantity = ManageStock::whereWarehouseId($input['warehouse_id'])->whereProductId($oldProduct->product_id)->first();
                        if ($productQuantity) {
                            if ($oldProduct) {
                                $productQuantity->update([
                                    'quantity' => $productQuantity->quantity + $oldProduct->quantity,
                                ]);
                            }
                        } else {
                            ManageStock::create([
                                'warehouse_id' => $input['warehouse_id'],
                                'product_id'   => $oldProduct->product_id,
                                'quantity'     => $oldProduct->quantity,
                            ]);
                        }
                    }
                    SaleProduct::whereIn('id', array_values($removeItemIds))->delete();
                }
            }*/

               #save tax charges
                $this->save_tax_charges($request, $sale);
                return redirect()->route('sale.index')->with('success', __('Sale successfully updated.'));
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

    function save_tax_charges($request, $sale){
         #Tax charges
        TaxChargesHasValues::where('purchase_sale_id', $sale->id)->where('module', 'sale')->delete();
         if(!empty($request->tax_type) && count($request->tax_type)>0){
            for($j=0; $j<count($request->tax_type); $j++){
                if($request->tax_type[$j]){
                        $taxChargesTypes = TaxChargesType::find($request->tax_type[$j]);
                    TaxChargesHasValues::create(
                        [
                            'charges_type_id' =>  (!empty($taxChargesTypes->id) ? $taxChargesTypes->id : ''),
                            'charges_type_name' => (!empty($taxChargesTypes->name) ? $taxChargesTypes->name : ''),
                            'purchase_sale_id' =>   (!empty($sale->id) ? $sale->id : ''),
                            'slug' => 'tax',
                            'module' => 'sale',
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
                                'purchase_sale_id' =>   (!empty($sale->id) ? $sale->id : ''),
                                'slug' => 'shipping',
                                'module' => 'sale',
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
    public function destroy(Sale $sale)
    {
        if(\Auth::user()->can('delete purchase'))
        {
            if($sale->created_by == \Auth::user()->creatorId())
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
                $sale->delete();
//                if($purchase->customer_id != 0)
//                {
//                    Utility::userBalance('vendor', $purchase->customer_id, $purchase->getTotal(), 'debit');
//                }
                SaleProduct::where('sale_id', '=', $sale->id)->delete();

                return redirect()->route('sale.index')->with('success', __('Sale successfully deleted.'));
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

    function saleNumber()
    {
        $latest = Sale::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->sale_id + 1;
    }
    public function sent($id)
    {
        if(\Auth::user()->can('send purchase'))
        {
            $sales            = Sale::where('id', $id)->first();
            $sales->send_date = date('Y-m-d');
            $sales->status    = 1;
            $sales->save();

            $vender = Customer::where('id', $sales->customer_id)->first();

            $sales->name = !empty($vender) ? $vender->name : '';
            $sales->sale = \Auth::user()->saleNumberFormat($sales->sales_id);

            $saleId    = Crypt::encrypt($sales->id);
            $sales->url = route('sale.pdf', $saleId);

            Utility::userBalance('vendor', $vender->id, $sales->getTotal(), 'credit');

            $vendorArr = [
                'vender_bill_name' => $sales->name,
                'vender_bill_number' =>$sales->sale,
                'vender_bill_url' => $sales->url,

            ];
            $resp = \App\Models\Utility::sendEmailTemplate('vender_bill_sent', [$vender->id => $vender->email], $vendorArr);


            return redirect()->back()->with('success', __('Sale successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
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
            $sales = Sale::where('id', $id)->first();

            $vender = Vender::where('id', $sales->customer_id)->first();

            $sales->name = !empty($vender) ? $vender->name : '';
            $sales->sales = \Auth::user()->saleNumberFormat($sales->purchase_id);

            $salesId    = Crypt::encrypt($sales->id);
            $sales->url = route('sale.pdf', $salesId);
//

        // Send Email
//        $setings = Utility::settings();
//
//        if($setings['bill_resend'] == 1)
//        {
//            $bill = Bill::where('id', $id)->first();
//            $vender = Vender::where('id', $bill->customer_id)->first();
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

    public function sale($sales_id)
    {


        $settings = Utility::settings();
        $salesId   = Crypt::decrypt($sales_id);

        $sales  = Sale::where('id', $salesId)->first();
        $data  = DB::table('settings');
        $data  = $data->where('created_by', '=', $sales->created_by);
        $data1 = $data->get();

        foreach($data1 as $row)
        {
            $settings[$row->name] = $row->value;
        }

        $vendor = $sales->vender;

        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate     = 0;
        $totalDiscount = 0;
        $taxesData     = [];
        $items         = [];

        foreach($sales->items as $product)
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

        $sales->itemData      = $items;
        $sales->totalTaxPrice = $totalTaxPrice;
        $sales->totalQuantity = $totalQuantity;
        $sales->totalRate     = $totalRate;
        $sales->totalDiscount = $totalDiscount;
        $sales->taxesData     = $taxesData;


        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));


        if($sales)
        {
            $color      = '#' . $settings['purchase_color'];
            $font_color = Utility::getFontColor($color);

            return view('sales.templates.' . $settings['purchase_template'], compact('sales', 'color', 'settings', 'vendor', 'img', 'font_color'));
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
        $sales     = new Sale();

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

        $sales->sales_id    = 1;
        $sales->issue_date = date('Y-m-d H:i:s');
//        $sales->due_date   = date('Y-m-d H:i:s');
        $sales->itemData   = $items;

        $sales->totalTaxPrice = 60;
        $sales->totalQuantity = 3;
        $sales->totalRate     = 300;
        $sales->totalDiscount = 10;
        $sales->taxesData     = $taxesData;
        $sales->created_by     = $objUser->creatorId();

        $preview      = 1;
        $color        = '#' . $color;
        $font_color   = Utility::getFontColor($color);

        $logo         = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $settings_data = \App\Models\Utility::settingsById($sales->created_by);
        $sales_logo = $settings_data['purchase_logo'];

        if(isset($sales_logo) && !empty($sales_logo))
        {
            $img = Utility::get_file('purchase_logo/') . $sales_logo;
        }
        else{
            $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        return view('sales.templates.' . $template, compact('sales', 'preview', 'color', 'img', 'settings', 'vendor', 'font_color'));
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

        return redirect()->back()->with('success', __('Sale Setting updated successfully'));
    }

    public function items(Request $request)
    {
        $saleID = (!empty($request->sale_id) ? $request->sale_id : $request->purchase_id);
        $items = SaleProduct::where('sale_id', $saleID)->where('product_id', $request->product_id)->first();

        return json_encode($items);
    }

    public function purchaseLink($purchaseId)
    {
        $id             = Crypt::decrypt($purchaseId);
        $sales       = Sale::find($id);

        $user_id        = $sales->created_by;
        $user           = User::find($user_id);

        $salesPayment = SalePayment::where('sale_id', $sales->id)->first();
        $vendor = $sales->vender;
        $iteams   = $sales->items;

        return view('sales.customer_bill', compact('sales', 'vendor', 'iteams','salesPayment','user'));
    }

    public function payment($sales_id)
    {
        if(\Auth::user()->can('create payment purchase'))
        {
            $sales    = Sale::where('id', $sales_id)->first();
            
            $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->get()->pluck('name', 'id');

            return view('sales.payment', compact('venders', 'categories', 'accounts', 'sales'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    public function createPayment(Request $request, $sales_id)
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

            $salesPayment                 = new SalePayment();
            $salesPayment->sale_id        = $sales_id;
            $salesPayment->date           = $request->date;
            $salesPayment->amount         = $request->amount;
            $salesPayment->account_id     = $request->account_id;
            $salesPayment->payment_method = 0;
            $salesPayment->reference      = $request->reference;
            $salesPayment->description    = $request->description;
            if(!empty($request->add_receipt))
            {
                $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                $request->add_receipt->storeAs('uploads/payment', $fileName);
                $salesPayment->add_receipt = $fileName;
            }
            $salesPayment->save();

            $sales  = Sale::where('id', $sales_id)->first();
            $due   = $sales->getDue();
            $total = $sales->getTotal();

            if($sales->status == 0)
            {
                $sales->send_date = date('Y-m-d');
                $sales->save();
            }

            if($due <= 0)
            {
                $sales->status =  $sales->status;
                $sales->save();
            }
            else
            {
                $sales->status =  $sales->status;
                $sales->save();
            }
            $salesPayment->user_id    = $sales->customer_id;
            $salesPayment->user_type  = 'Vender';
            $salesPayment->type       = 'Partial';
            $salesPayment->created_by = \Auth::user()->id;
            $salesPayment->payment_id = $salesPayment->id;
            $salesPayment->category   = 'Bill';
            $salesPayment->account    = $request->account_id;
            Transaction::addTransaction($salesPayment);

            $vender = Customer::where('id', $psales->customer_id)->first();

            $payment         = new SalePayment();
            $payment->name   = $vender['name'];
            $payment->method = '-';
            $payment->date   = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->bill   = 'bill ' . \Auth::user()->saleNumberFormat($salesPayment->sales_id);

            Utility::userBalance('vendor', $sales->customer_id, $request->amount, 'debit');

            Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');

            // Send Email
            $setings = Utility::settings();
            if($setings['new_bill_payment'] == 1)
            {

                $vender = Customer::where('id', $sales->customer_id)->first();
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
            $payment = SalePayment::find($payment_id);
            SalePayment::where('id', '=', $payment_id)->delete();

            $sales = Sale::where('id', $sales_id)->first();

            $due   = $sales->getDue();
            $total = $sales->getTotal();

            if($due > 0 && $total != $due)
            {
                $sales->status = $sales->status;

            }
            else
            {
                $sales->status = $sales->status;
            }

            Utility::userBalance('vendor', $sales->customer_id, $payment->amount, 'credit');
            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

            $sales->save();
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

    public function customer(Request $request)
    {
        $vender = Customer::where('id', '=', $request->id)->first();

        return view('sales.vender_detail', compact('vender'));
    }
    public function product(Request $request)
    {
        $data['product']     = $product = ProductService::find($request->product_id);
        $data['unit']        = !empty($product->unit()) ? $product->unit()->name : '';
        $data['taxRate']     = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes']       = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        $data['price']       = !empty($product->sale_price) ? $product->sale_price : 0;
        $salePrice           = $product->sale_price;
        $quantity            = 1;
        $taxPrice            = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);
        $totalstock = Utility::getWarehouseProductStock(@$request->product_id, @$request->warehouse_id);
        // $data['totalstock'] = !empty($totalstock) ? $totalstock : 0;
        $data['totalstock'] = $product->WarehouseProductStock(@$request->product_id, @$request->warehouse_id);
        return json_encode($data);
    }

    public function productDestroy(Request $request)
    {
        if(\Auth::user()->can('delete purchase'))
        {
            SaleProduct::where('id', '=', $request->id)->delete();

            return redirect()->back()->with('success', __('Sale product successfully deleted.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }








}
