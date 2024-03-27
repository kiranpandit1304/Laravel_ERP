<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\ProductService;
use App\Models\ProductImage;
use App\Models\ProductGroupItems;
use App\Models\User;
use App\Models\ProductVariation;
use App\Models\ProductVariationAssign;
use App\Models\StockHistory;
use App\Models\AdjustmentItem;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductRepository;
use Mail;
use Response;
use App\Exports\ProductExport;
use App\Imports\ProductServiceImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 

class ProductAPIController extends AppBaseController
{
   
    use ApiResponser;

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /*Product list api*/
    public function ProductList()
    {
        $requestData = $this->productRepository->product_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Product show id wise*/
    public function ProductShow($id)
    {
        $requestData = $this->productRepository->product_show($id);
        if(!is_null($requestData->pro_image)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->pro_image);
            if($profile_image->status == "success"){
                $requestData->pro_image = $profile_image->fileUrl;
            }
        }

        $mediaGet_data = \App\Models\ProductImage::where('product_id',$id)->get();
        $count =0;
        foreach ($mediaGet_data as $value) {
            if(!is_null($value->product_image)){
                    $profile_image = CommonHelper::getS3FileUrl($value->product_image);
                    if($profile_image->status == "success"){
                        $value->product_image = $profile_image->fileUrl;
                    }
                }
         $mediaGet[$count] = $value; 
         $count++;
        }
        
        if(!empty($requestData->is_group) && $requestData->is_group == 1)
        {
            $productVariation = ProductVariation::leftjoin('product_group_items','product_variation.id','product_group_items.variation_id');
            $productVariation->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productVariation->where('product_group_items.product_id',$id);
            //$productVariation->where('product_variation.platform',\Auth::user()->platform);
            //$productVariation->where('product_variation.guard',\Auth::user()->guard);
            $productVariation->select('product_variation.*','product_service_units.name as unitName','product_group_items.bundle_quantity as vquantity','product_group_items.total_cost_price','product_group_items.total_selling_price');
            $productVariation = $productVariation->get();
        }
        else
        {
            $productVariation = ProductVariation::leftjoin('adjustment_items','product_variation.id','adjustment_items.variation_id');
            $productVariation->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productVariation->where('adjustment_items.product_id',$id);
            //$productVariation->where('product_variation.platform',\Auth::user()->platform);
            //$productVariation->where('product_variation.guard',\Auth::user()->guard);
            $productVariation->select('product_variation.*','product_service_units.name as unitName','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
            $productVariation = $productVariation->get();
        }       

        $AdjustmentItem = ProductGroupItems::where('product_group_items.product_id',$id);
        $AdjustmentItem->select('product_group_items.*');
        $AdjustmentItem = $AdjustmentItem->get();


        $stockHistory = StockHistory::where('stock_history.product_id',$id);
        //$stockHistory->where('stock_history.platform',\Auth::user()->platform);
        //$stockHistory->where('stock_history.guard',\Auth::user()->guard);
        $stockHistory->leftjoin('venders','stock_history.vendor_id','venders.id');
        $stockHistory->select('stock_history.*','venders.name as vendorName');
        $stockHistory= $stockHistory->get();
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product retrieved successfully..','data' => $requestData,'productVariation' => $productVariation,'mediaGet' => $mediaGet,'stockHistory' => $stockHistory,'AdjustmentItem' => $AdjustmentItem]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Product add api*/
    public function ProductAdd(Request $request)
    {   
         /*add team id*/
         if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
         {
             $team_id = \Auth::user()->parent_id;
         }else{
             $team_id = \Auth::user()->id;
         }
         /*end*/
        $input = $request->all();
        $validatorArray = [
                'name' => ['required', Rule::unique('product_services')->where('team_id',$team_id)],              
                'description' => 'required',              
                'currency' => 'required',              
                /*'brand_id' => 'required',              
                'category_id' => 'required',*/              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->productRepository->product_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

     /*Product add api*/
    public function MobileProductAdd(Request $request)
    {   
       
        $input = $request->all();
        $validatorArray = [
                'name' => ['required', Rule::unique('product_services')->where('created_by',\Auth::user()->id)],     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->productRepository->mobile_product_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*MobileProductEdit */
    public function MobileProductEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->productRepository->mobile_product_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*Product update api*/
    public function ProductEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->productRepository->product_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($product_id)
    {

        $product = ProductService::find($product_id);
        if (empty($product)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 delete code*/
        if(!empty($product))
        {
            if(!empty($product->pro_image) && $product->pro_image != '')
            {
                $delete_media = explode('/',$product->pro_image);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        /*end s3 deletc code*/
        $product->delete();   
        /*product img delete*/
        /*s3 delete code*/ 
        $product_image = ProductImage::where('product_id',$product_id)->get(); 
        if(!empty($product_image))
        {
            foreach ($product_image as$value) {
                if(!empty($value->product_image) && $value->product_image != '')
                {
                    $delete_media = explode('/',$value->product_image);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        
        /*product img delete*/ 
        ProductImage::where('product_id',$product_id)->delete();    
        if(!empty($product)){
                return response(['status'=>true,'message'=>'Product Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function ProductMultipleDelete(Request $request)
    {
        /*S3 delete code*/
        $product_data = ProductService::whereIn('id',$request->id)->get(); 
        if(!empty($product_data))
        {
            foreach ($product_data as$value) {
                if(!empty($value->pro_image) && $value->pro_image != '')
                {
                    $delete_media = explode('/',$value->pro_image);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        /*end s3 deletc code*/
        $product = ProductService::whereIn('id',$request->id)->delete();   
        /*product img delete*/
        /*s3 delete code*/ 
        $product_image = ProductImage::whereIn('product_id',$request->id)->get(); 
        if(!empty($product_image))
        {
            foreach ($product_image as $value) {
                if(!empty($value->product_image) && $value->product_image != '')
                {
                    $delete_media = explode('/',$value->product_image);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }
        /*s3 delete end code*/
        ProductImage::whereIn('product_id',$request->id)->delete();
        if(!empty($product)){
                return response(['status'=>true,'message'=>'Product Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /* add ProductVariationAdd*/
    public function ProductVariationAdd(Request $request)
    {
        $input = $request->all();
        $validatorArray = [
                'variation_name' => 'required',              
                'sku' => 'required',              
                'purchase_price' => 'required',              
                'sale_price' => 'required',              
                'tax_rate' => 'required',              
                'hsn' => 'required',              
                'unit_id' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->productRepository->product_variation_add($input);
        $result = ProductVariation::orderBy('product_variation.id','DESC')
                                ->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id')
                                ->select('product_variation.*','product_service_units.name as unitName')
                                ->first();      

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Variation product added successfully..','data' => $result]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Variation Product list api*/
    public function VariationProductList()
    {
        $requestData = $this->productRepository->variation_product_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Variation product retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    
    /*ProductMediadelete api*/
    public function ProductMediadelete($mediad_id)
    {
        $product_media = \App\Models\ProductImage::find($mediad_id);       
        if (empty($product_media)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 Delete code added*/
        if(!empty($product_media->product_image) && $product_media->product_image != '')
        {
            $delete_media = explode('/',$product_media->product_image);
            $file = base64_decode($delete_media['2']);
            $media_delete = Storage::disk('s3')->delete($file);
        }
        /*End s3 delete code*/
        $product_media->delete();   
    
        if(!empty($product_media)){
                return response(['status'=>true,'message'=>'Product media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*ProductSingleMediadelete api*/
    public function ProductSingleMediadelete($product_id)
    {
        $product_media = \App\Models\ProductService::where('id',$product_id)->update(['pro_image' => NULL]); 
        /*S3 Delete code added*/
        $get_product_img =  \App\Models\ProductService::where('id',$product_id)->first();
        if(!empty($get_product_img->pro_image) && $get_product_img->pro_image != '')
        {
            $delete_media = explode('/',$get_product_img->pro_image);
            $file = base64_decode($delete_media['2']);
            $media_delete = Storage::disk('s3')->delete($file);
        }
        /*End s3 delete code*/

        if(!empty($product_media)){
                return response(['status'=>true,'message'=>'Product media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*VariationProductEdit*/
    public function VariationProductEdit(Request $request)
    {
        $input = $request->all();
        $requestData = $this->productRepository->variation_product_edit($input);  
        $variationProductList = ProductVariation::where('product_variation.id',$request->id);
        //$variationProductList->where('product_variation.platform',\Auth::user()->platform);
        //$variationProductList->where('product_variation.guard',\Auth::user()->guard);
        $variationProductList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $variationProductList->select('product_variation.*','product_service_units.name as unitName');
        $result = $variationProductList->get();       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Variation product updated successfully..','data' => $result]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
        
    }
    /*VariationProductdelete*/
    public function VariationProductdelete($id)
    {
        $variation_product_media = \App\Models\ProductVariation::find($id);       
        if (empty($variation_product_media)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $variation_product_media->delete();
        /*adjustment_items variation_id wise delete*/
        \App\Models\AdjustmentItem::where('variation_id',$id)->delete();
        /*end*/
        /**assign product delete*/ 
        \App\Models\ProductVariationAssign::where('variation_id',$id)->delete();
    
        if(!empty($variation_product_media)){
                return response(['status'=>true,'message'=>'Variation product media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*VariationProductShow*/
    public function VariationProductShow($id)
    {
        $requestData = $this->productRepository->variation_product_show($id);
            
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Variation product retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

     /*VariationProductAddAssign*/
    public function VariationProductAddAssign(Request $request)
    {
        $input = $request->all();
        $requestData = $this->productRepository->variation_product_add_assign($input);       
        $result = ProductVariation::orderBy('product_variation.id','DESC')
                ->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id')
                ->select('product_variation.*','product_service_units.name as unitName')
                ->first();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Variation product added successfully..','data' => $result]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
        
    }
    /*ProductExport*/
    public function ProductExport(Request $request ,$id = '')
    {
        $user_id   = Crypt::decrypt($id);
        $name = 'product_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $request['user_id']   = Crypt::decrypt($id);
        $getBusinessId = \App\Models\User::where('id',$request['user_id'])->first();
        $request['business_id'] = $getBusinessId['active_business_id'];
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new ProductExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new ProductExport($request), $name . '.xlsx'); ob_end_clean();

        }
       // $data = Excel::download(new ProductExport(), $name . '.xlsx'); ob_end_clean();

        return $data;
    }

    /*ProductPdf*/
    public function ProductPdf(Request $request,$id='') {
      // retreive all records from db
        $user_id   = Crypt::decrypt($id);
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$user_id)->first();
        if(!empty($request) && $request['id'] != '')
        {
            $productList = ProductService::where('product_services.created_by',$request['id']);
            //$productList->where('product_services.platform',$request['platform']);
            //$productList->where('product_services.guard',$request['guard']);
            $productList->where('product_services.business_id',$getBusinessId['active_business_id']);
            $productList->where('product_services.is_group',0);
            $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
            $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
            $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
            $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
            $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productList->select('product_services.name as productName','product_variation.*','product_service_units.name as unitName');
            $data = $productList->get();

        }else{
            $productList = ProductService::where('product_services.created_by',$user_id);
           // $productList->where('product_services.platform',$request['platform']);
            //$productList->where('product_services.guard',$request['guard']);
            $productList->where('product_services.business_id',$getBusinessId['active_business_id']);
            $productList->where('product_services.is_group',0);
            $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
            $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
            $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
            $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
            $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productList->select('product_services.name as productName','product_variation.*','product_service_units.name as unitName');
            $data = $productList->get();
        }

      $pdf = PDF::loadView('pdfFormat.product', compact('data'));
      $name = 'product_' . date('Y-m-d i:h:s');
      return $pdf->download($name.'.pdf');
    }

    /*ProductImport*/
    public function ProductImport(Request $request)
    {
        $validatorArray = [
                'product_file' => 'required|mimes:csv,txt'     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $result = Excel::toArray(new ProductServiceImport, $request->file('product_file'));
        $finalArray = array_filter($result[0], 'array_filter');
        $count = count($finalArray[0]);
        $countData = count($finalArray);
        $error_array = [];
        for ($j = 1; $j < $countData; $j++) {
            for ($i = 0; $i < $count; $i++) {   
                                 
                        if($finalArray[0][$i] == 'name' || $finalArray[0][$i] == 'description' || $finalArray[0][$i] == 'currency' || $finalArray[0][$i] == 'brand'  || $finalArray[0][$i] == 'category' || $finalArray[0][$i] =='variation_name')
                        {
                            if($finalArray[0][$i] == 'brand')
                            {
                                $brand =  \App\Models\ProductBrand::where('name',$finalArray[$j][$i])->first();
                                $array['brand_id']= @$brand['id'];
                            } 
                            if($finalArray[0][$i] == 'category')
                            {
                                $category =  \App\Models\ProductServiceCategory::where('name',$finalArray[$j][$i])->first();
                                $array['category_id']= @$category['id'];
                            }  
                            $array[$finalArray[0][$i]] = $finalArray[$j][$i];
                        } 
                    /*variation code*/                        
                    if($finalArray[0][$i] == 'variation_name' || $finalArray[0][$i] == 'sku' || $finalArray[0][$i] == 'purchase_price' || $finalArray[0][$i] == 'sale_price'  || $finalArray[0][$i] == 'tax_rate' || $finalArray[0][$i] == 'hsn' || $finalArray[0][$i] == 'unit')
                    {
                        if($finalArray[0][$i] == 'unit')
                        {
                            $unit =  \App\Models\BaseUnit::where('name',$finalArray[$j][$i])->first();
                            $variation['unit_id']= @$unit['id'];
                        } 
                        /*add variation*/
                        if ($finalArray[0][$i] != '') {
                            $variation[$finalArray[0][$i]] = $finalArray[$j][$i];
                        }
                    }                           
                }
                $array['created_by'] = Auth::user()->id;
                $array['business_id']   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                $array['warehouse_id']   =    (!empty(\Auth::user()->warehouse_id) ? \Auth::user()->warehouse_id : '');
                $array['type'] = 'product';
                $array['platform']= 'Unesync';
                $array['guard']= 'WEB';
                if(($array['variation_name'] == 'Regular' || $array['variation_name'] == 'regular'))
                {
                   unset($array['brand']);
                   unset($array['category']);
                   /*add team id*/
                   if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                   {
                        $array['team_id'] = \Auth::user()->parent_id;
                   }else{
                        $array['team_id'] = \Auth::user()->id;
                   }
                  /*end*/
                   $requestData = ProductService::create($array);
                }else{
                $last_record = ProductService::orderBy('id','DESC')->first();
                $requestData = new ProductVariation;
                $requestData->variation_name  =    (!empty($variation['variation_name']) ? $variation['variation_name'] : '');
                $requestData->sku  =    (!empty($variation['sku']) ? $variation['sku'] : '');
                $requestData->purchase_price  =    (!empty($variation['purchase_price']) ? $variation['purchase_price'] : '');
                $requestData->sale_price  =    (!empty($variation['sale_price']) ? $variation['sale_price'] : '');
                $requestData->tax_rate  =    (!empty($variation['tax_rate']) ? $variation['tax_rate'] : '');
                $requestData->hsn  =    (!empty($variation['hsn']) ? $variation['hsn'] : '');
                $requestData->unit_id  =    (!empty($variation['unit_id']) ? $variation['unit_id'] : '');
                $requestData->created_by  =    \Auth::user()->id;
                $requestData->platform  =    'Unesync';
                $requestData->guard  =    'WEB';
                $requestData->is_group  =    '0';
                /*add team id*/
                if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                {
                    $requestData->team_id = \Auth::user()->parent_id;
                }else{
                    $requestData->team_id = \Auth::user()->id;
                }
                /*end*/           
                $requestData->save();
                
                /*variation product assign*/
                $variation_last_record = ProductVariation::orderBy('id','DESC')->first();
                       
                $adjustmentItem = new AdjustmentItem;
                $adjustmentItem->product_id = (!empty($last_record['id']) ? $last_record['id'] : '');
                $adjustmentItem->variation_id = (!empty($variation_last_record['id']) ? $variation_last_record['id'] : '');
                $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
                $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
                $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
                $adjustmentItem->platform  =    'Unesync';
                $adjustmentItem->guard  =    'WEB';
                /*add team id*/
                if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                {
                     $adjustmentItem->team_id = \Auth::user()->parent_id;
                }else{
                     $adjustmentItem->team_id = \Auth::user()->id;
                }
               /*end*/
                $adjustmentItem = $adjustmentItem->save();
                
             }
            }
     
      if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product import successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*ProductManageStockUpdate */
    public function ProductManageStockUpdate(Request $request)
    {           
        $input = $request->all();
        $requestData = $this->productRepository->product_manage_stock_update($input);
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Product manage stock updated successfully..']);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*ProductlowStockUpdate */
    public function ProductlowStockUpdate(Request $request)
    {           
        $input = $request->all();
        $requestData = $this->productRepository->product_low_stock_update($input);
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Product low stock updated successfully..']);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*MobileStockUpdate */
    public function MobileStockUpdate(Request $request)
    {           
        $input = $request->all();
        $requestData = $this->productRepository->mobile_stock_update($input);
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Product stock updated successfully..']);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*CategoryAssignItem*/
    public function CategoryAssignItem(Request $request)
    {   
        $input = $request->all();   
        $requestData = $this->productRepository->category_assign_item($input);

        $categorySubAssignItemList = ProductService::where('product_services.category_id',$input['id']);
        $categorySubAssignItemList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
        $categorySubAssignItemList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
        $categorySubAssignItemList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
        $categorySubAssignItemList->select('product_services.id as product_id','product_services.name as productName','product_variation.variation_name','adjustment_items.quantity as vquantity','adjustment_items.stock_alert as vstock_alert');
        $categorySubAssignItemList->groupby('adjustment_items.product_id');
        $categorySubAssignItemList = $categorySubAssignItemList->get();
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Category assign item retrieved successfully..','data'=>$requestData,'categorySubAssignItemList' => $categorySubAssignItemList]);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*CategoryRemoveItem*/
    public function CategoryRemoveItem(Request $request)
    {   
        $input = $request->all();   
        $requestData = $this->productRepository->category_remove_item($input);
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Category remove item successfully..']);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*AddNewItem*/
    public function AddNewItem(Request $request)
    {   
        $input = $request->all();   
        $requestData = $this->productRepository->add_new_item($input);
        if(!empty($requestData)){
            return response(['status'=>true,'message'=>'Add new item successfully..']);
        }else{
            
            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*AddGroupProduct*/
    public function AddGroupProduct(Request $request)
    {
        /*add team id*/
         if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
         {
             $team_id = \Auth::user()->parent_id;
         }else{
             $team_id = \Auth::user()->id;
         }
         /*end*/
        $input = $request->all();
        $validatorArray = [
                'name' => ['required', Rule::unique('product_services')->where('team_id',$team_id)],              
                'description' => 'required',              
                'currency' => 'required',              
                              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->productRepository->product_group_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product group added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*EditGroupProduct*/
    public function EditGroupProduct(Request $request)
    {
        $input = $request->all();
        /*$validatorArray = [
                'name' => ['required'],              
                'description' => 'required',              
                'currency' => 'required',              
                              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }*/
        $requestData = $this->productRepository->product_group_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product group edit successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Product show id wise*/
    public function GroupProductShow($id)
    {
        $requestData = $this->productRepository->group_product_show($id);
        if(!is_null($requestData->pro_image)){
            $profile_image = CommonHelper::getS3FileUrl($requestData->pro_image);
            if($profile_image->status == "success"){
                $requestData->pro_image = $profile_image->fileUrl;
            }
        }

        $mediaGet_data = \App\Models\ProductImage::where('product_id',$id)->get();
        $count =0;
        foreach ($mediaGet_data as $value) {
            if(!is_null($value->product_image)){
                    $profile_image = CommonHelper::getS3FileUrl($value->product_image);
                    if($profile_image->status == "success"){
                        $value->product_image = $profile_image->fileUrl;
                    }
                }
         $mediaGet[$count] = $value; 
         $count++;
        }
        
        $productVariation = ProductVariation::leftjoin('product_group_items','product_variation.id','product_group_items.variation_id');
        $productVariation->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
        $productVariation->where('product_group_items.product_id',$id);
        //$productVariation->where('product_variation.platform',\Auth::user()->platform);
        //$productVariation->where('product_variation.guard',\Auth::user()->guard);
        $productVariation->select('product_variation.*','product_service_units.name as unitName','product_group_items.bundle_quantity as vquantity','product_group_items.total_cost_price','product_group_items.total_selling_price');
        $productVariation = $productVariation->get();
      
        $AdjustmentItem = ProductGroupItems::where('product_group_items.product_id',$id);
        $AdjustmentItem->leftjoin('product_services','product_group_items.product_id','product_services.id');
        $AdjustmentItem->leftjoin('product_variation','product_group_items.variation_id','product_variation.id');
        $AdjustmentItem->leftjoin('adjustment_items','product_variation.id','adjustment_items.variation_id');
        $AdjustmentItem->select('product_group_items.*', 'product_services.name as prod_name','product_variation.variation_name','product_variation.purchase_price','product_variation.sale_price','adjustment_items.quantity');
        $AdjustmentItem = $AdjustmentItem->get();

        $stockHistory = StockHistory::where('stock_history.product_id',$id);
        //$stockHistory->where('stock_history.platform',\Auth::user()->platform);
        //$stockHistory->where('stock_history.guard',\Auth::user()->guard);
        $stockHistory->leftjoin('venders','stock_history.vendor_id','venders.id');
        $stockHistory->select('stock_history.*','venders.name as vendorName');
        $stockHistory= $stockHistory->get();
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Group product retrieved successfully..','data' => $requestData,'productVariation' => $productVariation,'mediaGet' => $mediaGet,'stockHistory' => $stockHistory,'AdjustmentItem' => $AdjustmentItem]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*CatAssignProductList list api*/
    public function CatAssignProductList()
    {
        $requestData = $this->productRepository->cat_assign_product_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Product retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
}