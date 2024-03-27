<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\SaleBusinessDetailsDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleBusinessDetailsRepository;
use Mail;
use Response;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class SaleBusinessDetailsApiController extends AppBaseController
{
   
    use ApiResponser;

    private $saleBusinessDetailsRepository;

    public function __construct(SaleBusinessDetailsRepository $saleBusinessDetailsRepository)
    {
        $this->saleBusinessDetailsRepository = $saleBusinessDetailsRepository;
    }

    /*SaleBusinessDetailsRepository list api*/
    public function SaleBusinessDetailsList($invoice_id)
    {
        $requestData = $this->saleBusinessDetailsRepository->sale_business_details_list($invoice_id);

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Business Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*SaleBusinessDetailsRepositoryShow show id wise*/
    public function SaleBusinessDetailsShow($id)
    {
        $requestData = $this->saleBusinessDetailsRepository->sale_business_details_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Business Details retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Data not found!"]);
        } 
    }

   /*SaleBusinessDetailsRepositoryAdd add api*/
    public function SaleBusinessDetailsAdd(Request $request)
    {   
        $validatorArray = [
          'business_name' => 'required',
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $input = $request->all();
        $requestData = $this->saleBusinessDetailsRepository->sale_business_details_add($input);       
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Business Details added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*SaleBusinessDetailsRepositoryEdit update api*/
    public function SaleBusinessDetailsEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->saleBusinessDetailsRepository->sale_business_details_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Sale Invoice Business Details updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($invoice_id)
    {

        $SaleBusinessDetailsRepository = SaleBusinessDetailsRepository::find($invoice_id);
        if (empty($SaleBusinessDetailsRepository)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $SaleBusinessDetailsRepository->delete();      
        if(!empty($SaleBusinessDetailsRepository)){
                return response(['status'=>true,'message'=>'Sale Invoice Business Details Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}