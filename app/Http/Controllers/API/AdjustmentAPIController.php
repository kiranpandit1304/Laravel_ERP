<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\AdjustmentRepository;
use Mail;
use Response;



class AdjustmentAPIController extends AppBaseController
{
   
    use ApiResponser;

    private $adjustmentRepository;

    public function __construct(AdjustmentRepository $adjustmentRepository)
    {
        $this->adjustmentRepository = $adjustmentRepository;
    }

    /*Adjustment add api*/
    public function AdjustmentAdd(Request $request)
    {   
        $input = $request->all();
        /* $validatorArray = [
          'vendor_id' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        } */
        $requestData = $this->adjustmentRepository->adjustment_add($input);       
        $adjustmentItem = AdjustmentItem::orderBy('id','DESC')->first();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Adjustment added successfully..','data'=>$adjustmentItem]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }


     /*Adjustment Update api*/
     public function AdjustmentUpdate(Request $request)
     {   
         $input = $request->all();
         /* $validatorArray = [
           'vendor_id' => 'required',
             ];
         $validator      = \Validator::make($request->all(), $validatorArray);
         if($validator->fails())
         {
             return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
         } */
         $requestData = $this->adjustmentRepository->adjustment_update($input);       
         $adjustmentItemData = AdjustmentItem::orderBy('id','DESC')->first();

         if(!empty($input['variation_name']) && !empty($input['purchase_price']))
         {
             $productVariation = \App\Models\ProductVariation::orderBy('product_variation.id','DESC')
                                    ->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id')
                                    ->select('product_variation.*','product_service_units.name as unitName')
                                    ->first(); 
         }else{
            $productVariation = [];
         }    
         if(!empty($requestData)){
                 return response(['status'=>true,'message'=>'Adjustment updated successfully..','data' => $adjustmentItemData,'productVariation' => $productVariation]);
         }else{
 
             return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
         }
     }
     /*AdjustmentProductWiseShow*/
     public function AdjustmentProductWiseShow($product_id)
     {
        $requestData = $this->adjustmentRepository->adjustment_product_list($product_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Adjustment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
     }
     /*AdjustmentVariationWiseShow*/
     public function AdjustmentVariationWiseShow($variation_id)
     {
        $requestData = $this->adjustmentRepository->adjustment_variation_list($variation_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Adjustment retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
     }
     /*StockHistory*/
     public function StockHistory()
     {
        $requestData = $this->adjustmentRepository->stock_history();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Stock history retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
     }
  
}