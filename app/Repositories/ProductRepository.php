<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\ProductService;
use App\Models\Utility;
use App\Models\ProductImage;
use App\Models\ProductVariationAssign;
use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use App\Models\ProductGroupItems;
use App\Models\AdjustmentItempractise;
use App\Models\StockHistory;
use App\Models\ProductVariation;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class ProductRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model(): string
    {
        return ProductService::class;
    }

    public function product_list()
    {
        $productList = ProductService::where('product_services.created_by',\Auth::user()->id);
        $productList->where('product_services.business_id',\Auth::user()->active_business_id);
        // $productList->where('product_services.platform',\Auth::user()->platform);
        // $productList->where('product_services.guard',\Auth::user()->guard);
        $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
        $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
        $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $productList->select('product_services.*','product_variation.id as variation_id','product_brands.name as brandName','product_service_categories.name as catName','product_variation.hsn','product_variation.sku as vsku','product_variation.purchase_price as vpurchase_price','product_variation.sale_price as vsale_price','product_variation.tax_rate','product_service_units.name as unitName','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $productList = $productList->get();

        $count =0;
        foreach ($productList as $value) {
            if(!is_null($value->pro_image)){
                    $profile_image = CommonHelper::getS3FileUrl($value->pro_image);
                    if($profile_image->status == "success"){
                        $value->pro_image = $profile_image->fileUrl;
                    }
                }
         $productList_data[$count] = $value; 
         $count++;
        }

        return $productList_data;
    }
    /*cat_assign_product_list*/
    public function cat_assign_product_list()
    {
        $productList = ProductService::where('product_services.created_by',\Auth::user()->id);
        $productList->where('product_services.business_id',\Auth::user()->active_business_id);
        // $productList->where('product_services.platform',\Auth::user()->platform);
        // $productList->where('product_services.guard',\Auth::user()->guard);
        $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
        $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
        $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $productList->where('product_services.is_group','0');
        $productList->groupBy('product_services.id');
        $productList->select('product_services.*','product_variation.id as variation_id','product_brands.name as brandName','product_service_categories.name as catName','product_variation.hsn','product_variation.sku as vsku','product_variation.purchase_price as vpurchase_price','product_variation.sale_price as vsale_price','product_variation.tax_rate','product_service_units.name as unitName','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $productList = $productList->get();

        return $productList;
        
    }
    public function product_show($id)
    {
        $productList = ProductService::where('product_services.id',$id);
        $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
        $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
        $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $productList->select('product_services.*','product_variation.id as variation_id','product_brands.name as brandName','product_service_categories.name as catName','product_variation.hsn','product_variation.sku as vsku','product_variation.purchase_price as vpurchase_price','product_variation.sale_price as vsale_price','product_variation.tax_rate','product_service_units.name as unitName','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $productList = $productList->first();

        return $productList;
    }

    public function mobile_product_add($input)
    {

        try {           
            $requestData = new ProductService;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->type  =    'product';
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            if (!empty($input['pro_image'])) {
                $errorMessages = array();
            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['pro_image'], 'pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();

            /*singel ProductVariation add*/
            $productVariationData = new ProductVariation;
            $productVariationData->variation_name  =    "Regular";
            $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $productVariationData->tax_included  =    (!empty($input['tax_included']) ? $input['tax_included'] : '');
            $productVariationData->asofDate  =    (!empty($input['asofDate']) ? $input['asofDate'] : '');           
            $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $productVariationData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $productVariationData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $productVariationData->created_by  =    \Auth::user()->id;
            $productVariationData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                 $productVariationData->team_id = \Auth::user()->parent_id;
            }else{
                 $productVariationData->team_id = \Auth::user()->id;
            }
            /*end*/           
            $productVariationData = $productVariationData->save();

            $ProductVariationId = ProductVariation::orderBy('id','DESC')->first();
            $adjustmentItem = new AdjustmentItem;
            /*add item adjustment_items*/
            $adjustmentItem->product_id = (!empty($requestData['id']) ? $requestData['id'] : '');
            $adjustmentItem->variation_id = (!empty($ProductVariationId['id']) ? $ProductVariationId['id'] : '');
            $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem->method_type = '1';
            $adjustmentItem->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $adjustmentItem->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $adjustmentItem->vendor_client_name = @$customer['name'];
            $adjustmentItem->created_by  =    \Auth::user()->id;
            $adjustmentItem = $adjustmentItem->save();

            /*Add stock data*/
            /*StockHistory*/
            $stockHistory = new StockHistory;
            $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $stockHistory->vendor_client_name = @$customer['name'];
            $stockHistory->product_id = (!empty($requestData['id']) ? $requestData['id'] : '');
            $stockHistory->variation_id = (!empty($ProductVariationId['id']) ? $ProductVariationId['id'] : '');
            $stockHistory->variation_name = "Regular";
            $stockHistory->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $stockHistory->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
            $stockHistory->created_by = \Auth::user()->id;
            $stockHistory->method_type = '1';
            $stock = $stockHistory->save();
            

           return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        
    }

    public function mobile_product_edit($input)
    {
        try {           
            $requestData = ProductService::find($input['id']);;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->type  =    'product';
            if (!empty($input['pro_image'])) {
                $errorMessages = array();
            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['pro_image'], 'pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();

            /*singel ProductVariation add*/
            $productVariationData = ProductVariation::find($input['variation_id']);
            $productVariationData->variation_name  =    "Regular";
            $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $productVariationData->tax_included  =    (!empty($input['tax_included']) ? $input['tax_included'] : '');
            $productVariationData->asofDate  =    (!empty($input['asofDate']) ? $input['asofDate'] : '');           
            $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $productVariationData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                 $productVariationData->team_id = \Auth::user()->parent_id;
            }else{
                 $productVariationData->team_id = \Auth::user()->id;
            }
            /*end*/           
            $productVariationData = $productVariationData->save();

            $ProductVariationId = ProductVariation::orderBy('id','DESC')->first();
            /*add item adjustment_items*/
            //$adjustmentItem = AdjustmentItem::find($input['variation_id']);
            $adjustmentItem['product_id'] = (!empty($input['id']) ? $input['id'] : '');
            $adjustmentItem['variation_id'] = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            $adjustmentItem['quantity'] = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem['stock_alert'] = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem['method_type'] = '1';
            $adjustmentItem['created_by']  =    \Auth::user()->id;
            $adjustmentItem = AdjustmentItem::where('variation_id',$input['variation_id'])->update($adjustmentItem);

            /*Add stock data*/
            /*StockHistory*/
            $stockHistory = new StockHistory;
            $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
            $stockHistory->product_id = (!empty($input['id']) ? $input['id'] : '');
            $stockHistory->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            $stockHistory->variation_name = "Regular";
            $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
            $stockHistory->created_by = \Auth::user()->id;
            $stockHistory->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $stockHistory->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $stockHistory->method_type = '1';
            $stock = $stockHistory->save(); 
            

           return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        
    }
    

    public function product_add($input)
    {
        try {
           /* echo "<pre>";
            print_r($input); exit;*/
            $requestData = new ProductService;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->warehouse_id   =    (!empty(\Auth::user()->warehouse_id) ? \Auth::user()->warehouse_id : '');
            $requestData->type  =    'product';
            if (!empty($input['pro_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['pro_image'], 'pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();
            /*duplicate ProductVariation add*/
            if(!empty($input['is_duplicate']) && $input['is_duplicate'] == 'true')
            {
                $variation_id = array_unique($input['variation_id']);
                for($i = 0; $i < count($variation_id); $i++)
                {
                    $getproductVariation = ProductVariation::where('id',$input['variation_id'][$i])->first();
                    $productVariationData = new ProductVariation;
                    $productVariationData->product_id  =    (!empty($requestData['id']) ? $requestData['id'] : '');
                    $productVariationData->variation_name  =    (!empty($getproductVariation['variation_name']) ? $getproductVariation['variation_name'] : '');
                    $productVariationData->sku  =    (!empty($getproductVariation['sku']) ? $getproductVariation['sku'] : '');
                    $productVariationData->purchase_price  =    (!empty($getproductVariation['purchase_price']) ? $getproductVariation['purchase_price'] : '');
                    $productVariationData->sale_price  =    (!empty($getproductVariation['sale_price']) ? $getproductVariation['sale_price'] : '');
                    $productVariationData->tax_rate  =    (!empty($getproductVariation['tax_rate']) ? $getproductVariation['tax_rate'] : '');
                    $productVariationData->hsn  =    (!empty($getproductVariation['hsn']) ? $getproductVariation['hsn'] : '');
                    $productVariationData->unit_id  =    (!empty($getproductVariation['unit_id']) ? $getproductVariation['unit_id'] : '');
                    $productVariationData->created_by  =    \Auth::user()->id;
                    $productVariationData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                    $productVariationData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
                    $productVariationData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                    /*add team id*/
                    if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                    {
                        $productVariationData->team_id = \Auth::user()->parent_id;
                    }else{
                        $productVariationData->team_id = \Auth::user()->id;
                    }
                    /*end*/          
                    $productVariationData = $productVariationData->save(); 
                }
            }
            else
            {
                if(empty($input['variation_id']))
                {

                /*singel ProductVariation add*/
                $productVariationData = new ProductVariation;
                $productVariationData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
                $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
                $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
                $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
                $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
                $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
                $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
                $productVariationData->created_by  =    \Auth::user()->id;
                $productVariationData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                $productVariationData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
                $productVariationData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                /*add team id*/
                 if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                 {
                      $productVariationData->team_id = \Auth::user()->parent_id;
                 }else{
                      $productVariationData->team_id = \Auth::user()->id;
                 }
                 /*end*/          
                 $productVariationData = $productVariationData->save(); 
                 /*adjustment_id update to Variation id*/
                 if(!empty($input['adjustment_id']))
                 {
                    $variation_id_get = ProductVariation::orderBy('id','DESC')->first();
                    $variation_id_update = AdjustmentItem::where('id',$input['adjustment_id'])
                                           ->update(['variation_id' => $variation_id_get['id'],
                                                     'product_id' => $requestData['id']
                                                    ]);
                 }  
                } 
            }
            /*adjustment_items*/
            $product_id = ProductService::orderBy('id','DESC')->first();
            if(empty($input['variation_id']))
            {
                $ProductVariationId = ProductVariation::orderBy('id','DESC')->first();
                if(empty($input['adjustment_id']))
                {
                    $adjustmentItem = new AdjustmentItem;
                   // $adjustmentItem->adjustment_id = (!empty($adjustmentData['id']) ? $adjustmentData['id'] : '');
                    $adjustmentItem->product_id = (!empty($product_id['id']) ? $product_id['id'] : '');
                    $adjustmentItem->variation_id = (!empty($ProductVariationId['id']) ? $ProductVariationId['id'] : '');
                    $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
                    $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
                    $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
                    $adjustmentItem->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
                    $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                    if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                    {
                        $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                    }
                    else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                    {
                        $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                    }
                    $adjustmentItem->vendor_client_name = @$customer['name'];
                    $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
                    if(!empty($input['custome_key']))
                    {
                        $custome_data = [];
                        for($i = 0; $i < count($input['custome_key']); $i++)
                        {
                            if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                            $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                            }
                        }                
                        $adjustmentItem->custome_field  =    json_encode($custome_data);
                    }
                    $adjustmentItem->created_by  =    \Auth::user()->id;
                    $adjustmentItem->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                    $adjustmentItem->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
                    $adjustmentItem = $adjustmentItem->save(); 
                    /*update product id*/             
                    $stockHistory = StockHistory::where('variation_id',$ProductVariationId['id'])->update(['product_id' => $requestData['id'],'method_type' => '1']); 
              
                }
            }
            else
            {  
                if(!empty($input['is_duplicate']) && $input['is_duplicate'] == 'true')
                { 
                    $ProductVariationData = ProductVariation::where('product_id',$product_id['id'])->get();
                    $variation_id = [];
                    foreach ($ProductVariationData as $value) {                        
                        array_push($variation_id, $value['id']);
                    }
                }
                else
                {             
                    $variation_id = array_unique($input['variation_id']);
                }
                
                for($i = 0; $i < count($variation_id); $i++)
                {       
                        if(!empty($input['is_duplicate']) && $input['is_duplicate'] == 'true')
                        { 
                            $check_db = AdjustmentItem::where('variation_id',$variation_id[$i])->first();                    
                        }
                        else
                        {
                            $check_db = AdjustmentItem::where('variation_id',$input['variation_id'][$i])->first();
                        }
                            
                        if(empty(!$check_db))
                        {
                           
                            $adjustmentItem = AdjustmentItem::where('variation_id',$input['variation_id'][$i])->update(['product_id' => $requestData['id']]);
                            /*update product id*/
                            $stockHistory = StockHistory::where('variation_id',$input['variation_id'][$i])->update(['product_id' => $requestData['id'],'method_type' => '1']);
                            
                        }
                        else
                        {
                            if(empty($input['adjustment_id']))
                            {
                                $adjustmentItem = new AdjustmentItem;
                                $adjustmentItem->product_id = (!empty($product_id['id']) ? $product_id['id'] : '');
                                if(!empty($input['is_duplicate']) && $input['is_duplicate'] == 'true')
                                {
                                    $adjustmentItem->variation_id = (!empty($variation_id[$i]) ? $variation_id[$i] : '');
                                }
                                else
                                {
                                    $adjustmentItem->variation_id = (!empty($input['variation_id'][$i]) ? $input['variation_id'][$i] : '');  
                                }
                                $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
                                $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
                                $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
                                $adjustmentItem->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
                                $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                                $adjustmentItem->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                                $adjustmentItem->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
                                if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                                {
                                    $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                                }
                                else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                                {
                                    $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                                }
                                $adjustmentItem->vendor_client_name = @$customer['name'];
                                $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
                                if(!empty($input['custome_key']))
                                {
                                    $custome_data = [];
                                    for($i = 0; $i < count($input['custome_key']); $i++)
                                    {
                                        if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                                        $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                                        }
                                    }                
                                    $adjustmentItem->custome_field  =    json_encode($custome_data);
                                }
                                $adjustmentItem->created_by  =    \Auth::user()->id;
                                $adjustmentItem = $adjustmentItem->save();
                            }                        
                    }

            }
        }

             # save media
                $product_id = ProductService::orderBy('id','DESC')->first();
                $image = @$input['product_image'];
                if (!empty($image)) {
                    for ($i = 0; $i < count($image); $i++) {
                        if ($image[$i] != '') {
                            if (isset($image[$i]) && $image[$i] != '') {
                                $errorMessages = array();                                    
                                $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'product_image', PRODUCT);
                                if($imgResponse->status == "success"){
                                    $input['product_image'] = $imgResponse->fileUrl;
                                }else{
                                    $errorMessages[]= $imgResponse->message;
                                }
                                $product_image['product_id'] = (!empty($product_id['id']) ? $product_id['id'] : '');
                                $product_image['product_image'] = $input['product_image'];
                                $product_image['product_image_name'] =  @$image[$i]->getClientOriginalName();
                                $requestData1 = ProductImage::create($product_image);
                            }
                        }
                    }
                }
                # end media Code ...
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function product_edit($input)
    {
        try {
            /*echo "<pre>";
            print_r($input); exit;*/
            $requestData =  ProductService::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->type  =    'product';
            if (!empty($input['edit_pro_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['edit_pro_image'], 'edit_pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['edit_pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            $requestData->save();

             # save media
                $image = @$input['product_image'];
                if (!empty($image)) {
                    for ($i = 0; $i < count($image); $i++) {
                        if ($image[$i] != '') {
                            if (isset($image[$i]) && $image[$i] != '') {
                                $errorMessages = array();                                    
                                $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'product_image', PRODUCT);
                                if($imgResponse->status == "success"){
                                    $input['product_image'] = $imgResponse->fileUrl;
                                }else{
                                    $errorMessages[]= $imgResponse->message;
                                }
                                $product_image['product_id'] = (!empty($input['id']) ? $input['id'] : '');
                                $product_image['product_image'] =  $input['product_image'];
                                $product_image['product_image_name'] =  @$image[$i]->getClientOriginalName();
                                $requestData1 = ProductImage::create($product_image);
                            }
                        }
                    }
                }
                # end media Code ...
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
/* add product_variation_add*/
    public function product_variation_add($input)
    {
        try {
            $requestData = new ProductVariation;
            $requestData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
            $requestData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $requestData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $requestData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $requestData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $requestData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $requestData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;   
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');          
            $requestData->save();   
                     
            $ProductVariationId = ProductVariation::orderBy('id','DESC')->first();
            $adjustmentItem = new AdjustmentItem;
            //$adjustmentItem->adjustment_id = (!empty($adjustmentData['id']) ? $adjustmentData['id'] : '');
            $adjustmentItem->product_id = (!empty($requestData['id']) ? $requestData['id'] : '');
            $adjustmentItem->variation_id = (!empty($ProductVariationId['id']) ? $ProductVariationId['id'] : '');
            $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
            $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            $adjustmentItem->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $adjustmentItem->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $adjustmentItem->vendor_client_name = @$customer['name'];
            $adjustmentItem->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
            $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                      $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $adjustmentItem->custome_field  =    json_encode($custome_data);
            }
            $adjustmentItem->created_by  =    \Auth::user()->id;
            $adjustmentItem = $adjustmentItem->save();
                # end media Code ...
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    /*variation_product_list*/
    public function variation_product_list()
    {
        $variationProductList = ProductVariation::leftjoin('base_unit','product_variation.unit_id','base_unit.id');
        $variationProductList->select('product_variation.*','base_unit.name as unitName');
        $variationProductList = $variationProductList->get();

        return $variationProductList;
    }

    /*variation_product_edit*/
    public function variation_product_edit($input)
    {
       try {
            $requestData = ProductVariation::find($input['id']);
            $requestData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
            $requestData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $requestData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $requestData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $requestData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $requestData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $requestData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;           
            $requestData->save();            
                # end media Code ...
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    /*variation_product_add_assign*/
    public function variation_product_add_assign($input)
    {
      try {
            $requestData = new ProductVariation;
            $requestData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
            $requestData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $requestData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $requestData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $requestData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $requestData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $requestData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $requestData->created_by  =    \Auth::user()->id; 
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/           
            $requestData->save();            
            /*assign product*/
                              
            $ProductVariationId = ProductVariation::orderBy('id','DESC')->first();
            $adjustmentItem = new AdjustmentItem;
            $adjustmentItem->adjustment_id = (!empty($adjustmentData['id']) ? $adjustmentData['id'] : '');
            $adjustmentItem->variation_id = (!empty($requestData['id']) ? $requestData['id'] : '');
            $adjustmentItem->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
            $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
            $adjustmentItem->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            $adjustmentItem->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $adjustmentItem->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $adjustmentItem->vendor_client_name = @$customer['name'];
            $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                      $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $adjustmentItem->custome_field  =    json_encode($custome_data);
            }
            $adjustmentItem->created_by  =    \Auth::user()->id;
             /*add team id*/
             if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
             {
                  $adjustmentItem->team_id = \Auth::user()->parent_id;
             }else{
                  $adjustmentItem->team_id = \Auth::user()->id;
             }
             /*end*/ 
            $adjustmentItem = $adjustmentItem->save();
            
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /*variation_product_show*/
    public function variation_product_show($id)
    {
        $variationProductList = ProductVariation::where('product_variation.id',$id);
        $variationProductList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
         $variationProductList->leftjoin('adjustment_items','product_variation.id','adjustment_items.variation_id');
        $variationProductList->select('product_variation.*','product_service_units.name as unitName','adjustment_items.quantity');
        $variationProductList = $variationProductList->get();

        return $variationProductList;
    }

    /*product_manage_stock_update*/
    public function product_manage_stock_update($input)
    {
        $requestData =  ProductService::find($input['id']);
        $requestData->is_manage_stock  =    (!empty($input['is_manage_stock']) ? $input['is_manage_stock'] : '');
        $requestData->save();

        return $requestData;

    }
    /*product_manage_stock_update*/
    public function product_low_stock_update($input)
    {
        $requestData['stock_alert']  =    (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
        $requestData =  AdjustmentItem::where('variation_id',$input['variation_id'])->update($requestData);

        return $requestData;
    }
    /*mobile_stock_update*/
    public function mobile_stock_update($input)
    {
        
        $get_stock = AdjustmentItem::where('variation_id',$input['variation_id'])->first();

        if(!empty($input['stock_in']) && $input['stock_in'] == 1)
        {
            $requestData['quantity']  =    (!empty($input['quantity']) ? $input['quantity'] + $get_stock['quantity'] : '');
            
        }else{
            $requestData['quantity']  =    (!empty($input['quantity']) ? $get_stock['quantity'] - $input['quantity'] : '');

        }
        $requestData['adjust_reason'] = (!empty($input['adjust_reason']) ? $get_stock['adjust_reason']: '');
        $requestData =  AdjustmentItem::where('variation_id',$input['variation_id'])->update($requestData);
        /*update purchase price and sale price*/
        $price['purchase_price']  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
        $price['sale_price']  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
        $price = ProductVariation::where('id',$input['variation_id'])->update($price);

        /*add stock history data*/
        $stockHistory = new StockHistory;
        if(!empty($input['variation_id']))
        {
            $variation_name = \App\Models\ProductVariation::where('id',$input['variation_id'])->first();
        }
        $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
        $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
        $stockHistory->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
        $stockHistory->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
        $stockHistory->variation_name = @$variation_name['variation_name'];
        $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
        if(!empty($input['user_type']) && $input['user_type'] == 'customer')
        {
            $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
        }
        else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
        {
            $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
        }
        $stockHistory->vendor_client_name = @$customer['name'];
        $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
        $stockHistory->created_by = \Auth::user()->id;
        $stockHistory->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
        $stockHistory->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
        if(!empty($input['custome_key']))
        {
            $custome_data = [];
            for($i = 0; $i < count($input['custome_key']); $i++)
            {
                if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                    $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                }
            }                
            $stockHistory->custome_field  =    json_encode($custome_data);
        }
        $stockHistory->stock_date = (!empty($input['stock_date']) ? $input['stock_date'] : '');
        $stockHistory->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
        $stockHistory->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
        $requestData = $stockHistory->save();

        return $requestData;
    }
    /*category_assign_item*/
    public function category_assign_item($input)
    {
        
        $categoryAssignItemList = ProductService::where('product_services.category_id',$input['id']);
        $categoryAssignItemList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $categoryAssignItemList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $categoryAssignItemList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
        $categoryAssignItemList->select('product_services.id as product_id','product_services.name as productName','product_variation.variation_name','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $categoryAssignItemList->groupby('adjustment_items.product_id');
        $categoryAssignItemList = $categoryAssignItemList->get();

        return $categoryAssignItemList;
    }
    /*category_remove_item*/
    public function category_remove_item($input)
    {
        $requestData['category_id']  =    '';
        $requestData =  ProductService::where('id',$input['product_id'])->update($requestData);

        return $requestData;
    }
    /*add_new_item*/
    public function add_new_item($input)
    {
        $requestData['category_id']  =  (!empty($input['category_id']) ? $input['category_id'] : '');
        $requestData =  ProductService::where('id',$input['product_id'])->update($requestData);

        return $requestData;
    }

    /*product_group_add*/
    public function product_group_add($input)
    {
        try
        {
            $requestData = new ProductService;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->warehouse_id   =    (!empty(\Auth::user()->warehouse_id) ? \Auth::user()->warehouse_id : '');
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->group_stock  =    (!empty($input['group_stock']) ? $input['group_stock'] : '');
            $requestData->is_group  =   '1';
            $requestData->type  =    'group product';
            if (!empty($input['pro_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['pro_image'], 'pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();   

            # save media
            $product_id_data = ProductService::orderBy('id','DESC')->first();
            $image = @$input['product_image'];
            if (!empty($image)) {
                for ($i = 0; $i < count($image); $i++) {
                    if ($image[$i] != '') {
                        if (isset($image[$i]) && $image[$i] != '') {
                            $errorMessages = array();                                    
                            $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'product_image', PRODUCT);
                            if($imgResponse->status == "success"){
                                $input['product_image'] = $imgResponse->fileUrl;
                            }else{
                                $errorMessages[]= $imgResponse->message;
                            }
                            $product_image['product_id'] = (!empty($product_id_data['id']) ? $product_id_data['id'] : '');
                            $product_image['product_image'] = $input['product_image'];
                            $product_image['product_image_name'] =  @$image[$i]->getClientOriginalName();
                            $requestData1 = ProductImage::create($product_image);
                        }
                    }
                }
            }
            # end media Code ...
            
            $productVariationData = new ProductVariation;
            $productVariationData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
            $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
            $productVariationData->created_by  =    \Auth::user()->id;
            $productVariationData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $productVariationData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
            $productVariationData->product_id  =    (!empty($product_id_data['id']) ? $product_id_data['id'] : '');  
            /*add team id*/
             if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
             {
                  $productVariationData->team_id = \Auth::user()->parent_id;
             }else{
                  $productVariationData->team_id = \Auth::user()->id;
             }
             /*end*/          
             $productVariationData = $productVariationData->save(); 


             /*Add adjustment*/
            if(!empty($input['product_id']))
            {
            $ProductVariation = ProductVariation::orderBy('id','DESC')->first();
            for($i = 0; $i < count($input['product_id']); $i++)
            {
                 if ($input['product_id'][$i] != '') {
                    if (isset($input['product_id'][$i]) && $input['product_id'][$i] != '') {
                        $productGroupItems = new ProductGroupItems;
                        $productGroupItems->group_id  =   (!empty($product_id_data['id']) ? $product_id_data['id'] : '');
                        $productGroupItems->product_id = (!empty($product_id_data['id']) ? $product_id_data['id'] : '');
                        $productGroupItems->bundle_quantity = (!empty($input['bundle_quantity'][$i]) ? $input['bundle_quantity'][$i] : '');
                        $productGroupItems->variation_id  =    (!empty($input['product_id'][$i]) ? $input['product_id'][$i] : '');
                        $productGroupItems->total_cost_price = (!empty($input['total_cost_price'][$i]) ? $input['total_cost_price'][$i] : '');
                        $productGroupItems->total_selling_price = (!empty($input['total_selling_price'][$i]) ? $input['total_selling_price'][$i] : '');
                        $productGroupItems->created_by  =    \Auth::user()->id;
                        /*add team id*/
                        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                        {
                            $productGroupItems->team_id = \Auth::user()->parent_id;
                        }else{
                            $productGroupItems->team_id = \Auth::user()->id;
                        }
                        /*end*/
                        $productGroupItems = $productGroupItems->save();
                    }

                }
            }           
  
            }

             
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        
    }

     /*product_group_edit*/
    public function product_group_edit($input)
    {
        try
        {
            /*echo "<pre>";
            print_r($input); exit;*/
            $requestData = ProductService::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->description  =    (!empty($input['description']) ? $input['description'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->brand_id  =    (!empty($input['brand_id']) ? $input['brand_id'] : '');
            $requestData->category_id  =    (!empty($input['category_id']) ? $input['category_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->group_stock  =    (!empty($input['group_stock']) ? $input['group_stock'] : '');
            $requestData->is_group  =   '1';
            $requestData->type  =    'group product';
            if (!empty($input['pro_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['pro_image'], 'pro_image', PRODUCT);
                if($imgResponse->status == "success"){
                     $requestData->pro_image = $imgResponse->fileUrl;
                     $requestData->pro_image_name =  @$input['pro_image']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();   

            # save media
           // $product_id_data = ProductService::where('id',$input['id'])->first();
            $image = @$input['product_image'];
            if (!empty($image)) {
                for ($i = 0; $i < count($image); $i++) {
                    if ($image[$i] != '') {
                        if (isset($image[$i]) && $image[$i] != '') {
                            $errorMessages = array();                                    
                            $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'product_image', PRODUCT);
                            if($imgResponse->status == "success"){
                                $input['product_image'] = $imgResponse->fileUrl;
                            }else{
                                $errorMessages[]= $imgResponse->message;
                            }
                            $product_image['product_id'] = (!empty($input['id']) ? $input['id'] : '');
                            $product_image['product_image'] = $input['product_image'];
                            $product_image['product_image_name'] =  @$image[$i]->getClientOriginalName();
                            $requestData1 = ProductImage::create($product_image);
                        }
                    }
                }
            }
            # end media Code ...
            
            $productVariationData = ProductVariation::find($input['variation_id']);
            $productVariationData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
            $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
            $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
            $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
            $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
            $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
           
            /*add team id*/
             if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
             {
                  $productVariationData->team_id = \Auth::user()->parent_id;
             }else{
                  $productVariationData->team_id = \Auth::user()->id;
             }
             /*end*/   
             $productVariationData = $productVariationData->save(); 


             /*Add adjustment*/
            if(!empty($input['product_id']))
            {
                $oldItemDelete = ProductGroupItems::where('product_id',$input['id'])->delete();
                for($i = 0; $i < count($input['product_id']); $i++)
                {
                     if ($input['product_id'][$i] != '') {
                        if (isset($input['product_id'][$i]) && $input['product_id'][$i] != '') {
                            $productGroupItems = new ProductGroupItems;
                            $productGroupItems->group_id  =   (!empty($input['id']) ? $input['id'] : '');
                            $productGroupItems->product_id = (!empty($input['id']) ? $input['id'] : '');
                            $productGroupItems->bundle_quantity = (!empty($input['bundle_quantity'][$i]) ? $input['bundle_quantity'][$i] : '');
                            $productGroupItems->variation_id  =    (!empty($input['product_id'][$i]) ? $input['product_id'][$i] : '');
                            $productGroupItems->total_cost_price = (!empty($input['total_cost_price'][$i]) ? $input['total_cost_price'][$i] : '');
                            $productGroupItems->total_selling_price = (!empty($input['total_selling_price'][$i]) ? $input['total_selling_price'][$i] : '');
                            $productGroupItems->created_by  =    \Auth::user()->id;
                        /*add team id*/
                        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                        {
                            $productGroupItems->team_id = \Auth::user()->parent_id;
                        }else{
                            $productGroupItems->team_id = \Auth::user()->id;
                        }
                        /*end*/
                        $productGroupItems = $productGroupItems->save();
                        }

                    }
                }           
  
            }

             
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        
    }
    public function group_product_show($id)
    {
        $productList = ProductService::where('product_services.id',$id);
        $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
        $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $productList->leftjoin('product_variation','product_services.id','product_variation.product_id');
        $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $productList->select('product_services.*','product_variation.id as variation_id','product_brands.name as brandName','product_service_categories.name as catName','product_variation.hsn','product_variation.sku as vsku','product_variation.purchase_price as vpurchase_price','product_variation.sale_price as vsale_price','product_variation.tax_rate','product_service_units.name as unitName','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $productList = $productList->first();

        return $productList;
    }
    
}
