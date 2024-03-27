<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\CustomField;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\SaleReturn;
use App\Models\ManageStock;
use App\Models\SaleReturnProduct;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\SalePayment;
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

class SaleReturnController extends Controller
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
        $status = SaleReturn::$statues;
        $sales_return = SaleReturn::where('created_by', '=', \Auth::user()->creatorId())->get();
        

        return view('sales_return.index', compact('sales_return', 'status','vender'));


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

            $sale_number = \Auth::user()->saleReturnNumberFormat($this->saleNumber());
            $venders     = Customer::get()->pluck('name', 'id');
            $venders->prepend('Select Customer', '');

            $warehouse     = warehouse::get()->pluck('name', 'id');
            $warehouse->prepend('Select Warehouse', '');

            $product_services = ProductService::get()->pluck('name', 'id');
            $product_services->prepend('--', '');

            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();
           
            return view('sales_return.create', compact('venders', 'product_services', 'sale_number', 'sale_services', 'category', 'customFields','vendorId','warehouse', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes'));
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
            $saleReturnItemIds = SaleProduct::where('sale_id',$id)->pluck('id')->toArray();
            $saleReturnItemOldIds = [];
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
            $sale_return                 = new SaleReturn();
            $sale_return->sale_id    = $this->saleNumber();
            $sale_return->customer_id      = $request->customer_id;
            $sale_return->warehouse_id      = $request->warehouse_id;
            $sale_return->sale_date  = $request->sale_date;
            $sale_return->sale_number   = !empty($request->sale_number) ? $request->sale_number : 0;
            $sale_return->status = !empty($request->status) ? $request->status : 0;
            $sale_return->description = !empty($request->description) ? $request->description : '';
            $sale_return->discount_apply = !empty($request->discount) ? 1 : 0;
            $sale_return->discount = !empty($request->discount) ? (Double)$request->discount : 0;   
            $sale_return->created_by     = \Auth::user()->creatorId();
            $sale_return->save();

            $sale_returns = $request->items;
            for($i = 0; $i < count($sale_returns); $i++)
            {
                $saleReturnItemOldIds[$i] =  $sale_returns[$i]['item'];
                $saleReturnProduct              = new SaleReturnProduct();
                $saleReturnProduct->sale_id     = $sale_return->sale_id;
                $saleReturnProduct->product_id  = $sale_returns[$i]['item'];
                $saleReturnProduct->quantity    = $sale_returns[$i]['quantity'];
                $saleReturnProduct->tax         = $sale_returns[$i]['tax'];
                $saleReturnProduct->price       = $sale_returns[$i]['price'];
                
                $saleReturnProduct->save();

                //Warehouse Stock Report
                if(!empty($request->status) && $request->status == '2')
                {
                    Utility::addWarehouseStock($sale_returns[$i]['item'],$sale_returns[$i]['quantity'],$request->warehouse_id);
                }

            }
             if(!empty($request->status) && $request->status == '2'){
                 foreach ($sale_returns as $purchaseItem) {
                    $product = ManageStock::whereWarehouseId($request['warehouse_id'])
                        ->whereProductId($purchaseItem['item'])
                        ->first();
                    $saleExist = SaleProduct::where('product_id', $purchaseItem['item'])->exists();

                    if ($saleExist && $request['status'] == 2) {
                        if ($product) {
                            if ($product->quantity >= $purchaseItem['quantity']) {
                                $product->update([
                                    'quantity' => $product->quantity + $purchaseItem['quantity'],
                                ]);
                            }
                        } else {
                            ManageStock::create([
                                'warehouse_id' => $request['warehouse_id'],
                                'product_id'   => $purchaseItem['product_id'],
                                'quantity'     => $purchaseItem['quantity'],
                            ]);
                        }
                    } else {
                        return redirect()->back()->with('error', __('Sale Does Not exist.'));
                    }
                }
            }

            $removeItemIds = array_diff($saleReturnItemIds, $saleReturnItemOldIds);
            //delete remove product
            //echo $request['status']; exit;
            if (!empty(array_values($removeItemIds))) {
                foreach ($removeItemIds as $removeItemId) {
                    // remove quantity manage storage
                    $oldProduct = SaleProduct::whereId($removeItemId)->first();
                    $productQuantity = ManageStock::whereWarehouseId($request['warehouse_id'])->whereProductId($oldProduct->product_id)->first();
                    if ($productQuantity && $oldProduct && $request['status'] == 2) {
                        if ($oldProduct->quantity <= $productQuantity->quantity) {
                            $stockQuantity = $productQuantity->quantity - $oldProduct->quantity;
                            if ($stockQuantity < 0) {
                                $stockQuantity = 0;
                            }
                            $productQuantity->update([
                                'quantity' => $stockQuantity,
                            ]);
                        }
                    } else {
                        return redirect()->back()->with('error', __('Quantity must be less than Available quantity..'));
                    }
                }
                SaleProduct::whereIn('id', array_values($removeItemIds))->delete();
            }
            #save tax charges
             $this->save_tax_charges($request, $sale_return);

            return redirect()->route('sale_return.index', $sale_return->id)->with('success', __('Sale Return successfully created.'));
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
            $sales_return = SaleReturn::find($id);

            if($sales_return->created_by == \Auth::user()->creatorId())
            {
                $purchasePayment = SalePayment::where('sale_id', $sales_return->id)->first();
                $customer      =$sales_return->customer;
                $iteams      = $sales_return->items;
                $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales_return->sale_id)->where('slug', 'tax')->where('module', 'sale_return')->get();
                $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales_return->sale_id)->where('slug', 'shipping')->where('module', 'sale_return')->get();
                $status = StatusType::find($sales_return->status);

                return view('sales_return.view', compact('sales_return', 'customer', 'iteams', 'status', 'purchasePayment', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
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
            $sales_return     = SaleReturn::find($idwww);

            $category = ProductServiceCategory::where('type', 2)->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $warehouse     = warehouse::get()->pluck('name', 'id');
            $TaxChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales_return->sale_id)->where('slug', 'tax')->where('module', 'sale_return')->get();
            $ShippigChargesDBValues =   TaxChargesHasValues::where('purchase_sale_id', @$sales_return->sale_id)->where('slug', 'shipping')->where('module', 'sale_return')->get();
            $sales_number      = \Auth::user()->saleReturnNumberFormat($sales_return->sale_id);
            $venders          = Customer::get()->pluck('name', 'id');
            // $product_services = ProductService::get()->pluck('name', 'id');
            $product_services = $this->getPurchasedProduct($sales_return->warehouse_id);
            $product_services->prepend('Select Item', '');
            $StatusTypes = StatusType::get()->pluck('name', 'id');
            $taxChargesTypes = TaxChargesType::where('slug', 'tax')->get();
            $shippingChargesTypes = TaxChargesType::where('slug', 'shipping')->get();

           
            return view('sales_return.edit', compact('venders', 'product_services', 'sales_return', 'warehouse','sales_number', 'category', 'StatusTypes', 'taxChargesTypes', 'shippingChargesTypes', 'TaxChargesDBValues', 'ShippigChargesDBValues'));
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
    public function update(Request $request, SaleReturn $sale_return)
    {
        /*if(\Auth::user()->can('edit purchase'))
        {*/
            if($sale_return)
            {
                $saleReturnItemIds = SaleProduct::where('sale_id',$id)->pluck('id')->toArray();
                $saleReturnItemOldIds = [];
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

                    return redirect()->route('sale_return.index')->with('error', $messages->first());
                }
                $sale_return->customer_id      = @$request->customer_id;
                $sale_return->sale_date      = @$request->sale_date;
                $sale_return->description = !empty($request->description) ? $request->description : '';
                $sale_return->discount_apply = !empty($request->discount) ? 1 : 0;
                $sale_return->discount = $request->discount;
                $sale_return->status = !empty($request->status) ? $request->status : 0;

                $sale_return->save();
                $saved_sale_return = $sale_return;
                $sale_return = @$request->items;
        
                for($i = 0; $i < count($sale_return); $i++)
                {
                    $saleReturnProduct = SaleReturnProduct::find($sale_return[$i]['id']);

                    if($saleReturnProduct == null)
                    {
                        $saleReturnProduct             = new SaleReturnProduct();
                        $saleReturnProduct->sale_id    = $saved_sale_return->id;
                    }

                    if(isset($sale_return[$i]['item']))
                    {
                        $saleReturnProduct->product_id = $sale_return[$i]['item'];
                    }

                    $saleReturnProduct->quantity    = $sale_return[$i]['quantity'];
                    $saleReturnProduct->tax         = $sale_return[$i]['tax'];
                    $saleReturnProduct->price       = $sale_return[$i]['price'];
                    $saleReturnProduct->save();

                    if(isset($sale_return[$i]['item'])){
                        if(!empty($request->status) && $request->status == '2')
                        {
                            Utility::addWarehouseStock( $sale_return[$i]['item'],$sale_return[$i]['quantity'],$request->warehouse_id);
                        }

                    }

                }

                if(!empty($request->status) && $request['status'] == 2){
                        foreach ($sale_return as $purchaseItem) {
                           // echo "<pre>"; print_r($purchaseItem); exit;
                        $product = ManageStock::whereWarehouseId($request['warehouse_id'])
                            ->whereProductId($purchaseItem['item'])
                            ->first();
                        $saleExist = SaleProduct::where('product_id', $purchaseItem['item'])->exists();
                        if ($saleExist && $request['status'] == 2) {
                            if ($product) {
                                
                                //if ($product->quantity >= $purchaseItem['quantity']) {
                                    $product->update([
                                        'quantity' => $product->quantity + $purchaseItem['quantity'],
                                    ]);
                                //}
                            } else {
                                ManageStock::create([
                                    'warehouse_id' => $request['warehouse_id'],
                                    'product_id'   => $purchaseItem['item'],
                                    'quantity'     => $purchaseItem['quantity'],
                                ]);
                            }
                        } else {
                            return redirect()->back()->with('error', __('Sale Does Not exist.'));
                        }
                    }

                }
                $removeItemIds = array_diff($saleReturnItemIds, $saleReturnItemOldIds);
                //delete remove product
                //echo $request['status']; exit;
                if (!empty(array_values($removeItemIds))) {
                    foreach ($removeItemIds as $removeItemId) {
                        // remove quantity manage storage
                        $oldProduct = SaleProduct::whereId($removeItemId)->first();
                        $productQuantity = ManageStock::whereWarehouseId($request['warehouse_id'])->whereProductId($oldProduct->product_id)->first();
                        if ($productQuantity && $oldProduct && $request['status'] == 2) {
                            if ($oldProduct->quantity <= $productQuantity->quantity) {
                                $stockQuantity = $productQuantity->quantity - $oldProduct->quantity;
                                if ($stockQuantity < 0) {
                                    $stockQuantity = 0;
                                }
                                $productQuantity->update([
                                    'quantity' => $stockQuantity,
                                ]);
                            }
                        } else {
                            return redirect()->back()->with('error', __('Quantity must be less than Available quantity..'));
                        }
                    }
                    SaleProduct::whereIn('id', array_values($removeItemIds))->delete();
                }
               #save tax charges
                $this->save_tax_charges($request, $saved_sale_return);
                return redirect()->route('sale_return.index')->with('success', __('Sale Return successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        /*}
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }*/
    }

    function save_tax_charges($request, $sale_return){
         #Tax charges 
        TaxChargesHasValues::where('purchase_sale_id', $sale_return->id)->where('module', 'sale_return')->delete();
         if(!empty($request->tax_type) && count($request->tax_type)>0){
            for($j=0; $j<count($request->tax_type); $j++){
                if($request->tax_type[$j] && !empty($sale_return->id)){
                        $taxChargesTypes = TaxChargesType::find($request->tax_type[$j]);
                    TaxChargesHasValues::create(
                        [
                            'charges_type_id' =>  (!empty($taxChargesTypes->id) ? $taxChargesTypes->id : ''),
                            'charges_type_name' => (!empty($taxChargesTypes->name) ? $taxChargesTypes->name : ''),
                            'purchase_sale_id' =>   (!empty($sale_return->id) ? $sale_return->id : ''),
                            'slug' => 'tax',
                            'module' => 'sale_return',
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
                                'purchase_sale_id' =>   (!empty($sale_return->id) ? $sale_return->id : ''),
                                'slug' => 'shipping',
                                'module' => 'sale_return',
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
    public function destroy(SaleReturn $sale_return)
    {
        if(\Auth::user()->can('delete purchase'))
        {
            if($sale_return->created_by == \Auth::user()->creatorId())
            {
                $sale_return->delete();
                SaleReturnProduct::where('sale_id', '=', $sale_return->id)->delete();

                return redirect()->route('sale_return.index')->with('success', __('Sale Return successfully deleted.'));
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
        $latest = SaleReturn::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
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
            $sales            = SaleReturn::where('id', $id)->first();
            $sales->send_date = date('Y-m-d');
            $sales->status    = 1;
            $sales->save();

            $vender = Customer::where('id', $sales->customer_id)->first();

            $sales->name = !empty($vender) ? $vender->name : '';
            $sales->sale = \Auth::user()->saleReturnNumberFormat($sales->sales_id);

            $saleId    = Crypt::encrypt($sales->id);
            $sales->url = route('sale.pdf', $saleId);

            Utility::userBalance('vendor', $vender->id, $sales->getTotal(), 'credit');

            $vendorArr = [
                'vender_bill_name' => $sales->name,
                'vender_bill_number' =>$sales->sale,
                'vender_bill_url' => $sales->url,

            ];
            $resp = \App\Models\Utility::sendEmailTemplate('vender_bill_sent', [$vender->id => $vender->email], $vendorArr);


            return redirect()->back()->with('success', __('Sale Return successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
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
            $sales = SaleReturn::where('id', $id)->first();

            $vender = Customer::where('id', $sales->customer_id)->first();

            $sales->name = !empty($vender) ? $vender->name : '';
            $sales->sales = \Auth::user()->saleReturnNumberFormat($sales->purchase_id);

            $salesId    = Crypt::encrypt($sales->id);
            $sales->url = route('sale_return.pdf', $salesId);

       
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

        $sales  = Sale_return::where('id', $salesId)->first();
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
        $items = SaleReturnProduct::where('sale_id', $saleID)->where('product_id', $request->product_id)->first();
       
        return json_encode($items);
    }

    public function purchaseLink($purchaseId)
    {
        $id             = Crypt::decrypt($purchaseId);
        $sales       = SaleReturn::find($id);

        $user_id        = $sales->created_by;
        $user           = User::find($user_id);

        $salesPayment = SaleReturnPayment::where('sale_id', $sales->id)->first();
        $vendor = $sales->vender;
        $iteams   = $sales->items;

        return view('sales_return.customer_bill', compact('sales', 'vendor', 'iteams','salesPayment','user'));
    }

    public function payment($sales_id)
    {
        if(\Auth::user()->can('create payment purchase'))
        {
            $sales    = SaleReturn::where('id', $sales_id)->first();
            
            $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts   = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->get()->pluck('name', 'id');

            return view('sales_return.payment', compact('venders', 'categories', 'accounts', 'sales'));
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

            $sales  = SaleReturn::where('id', $sales_id)->first();
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
            $payment->bill   = 'bill ' . \Auth::user()->saleReturnNumberFormat($salesPayment->sales_id);

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

            $sales = SaleReturn::where('id', $sales_id)->first();

            $due   = $sales->getDue();
            $total = $sales->getTotal();

            if($due > 0 && $total != $due)
            {
                $sales->status =  $sales->status;

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

        return view('sales_return.vender_detail', compact('vender'));
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
            SaleReturnProduct::where('id', '=', $request->id)->delete();

            return redirect()->back()->with('success', __('Sale Return product successfully deleted.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }








}
