<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\ProductBrand;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use App\Repositories\BrandRepository;
use Mail;
use Response;
use App\Exports\BrandExport;
use App\Imports\BrandImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;


class BrandAPIController extends AppBaseController
{
   
    use ApiResponser;

    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /*Brand list api*/
    public function BrandList()
    {
        $requestData = $this->brandRepository->brand_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Brand retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Brnad show id wise*/
    public function BrandShow($id)
    {
        $requestData = $this->brandRepository->brand_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Brand retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Brand add api*/
    public function BrandAdd(Request $request)
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
          'name' => ['required', Rule::unique('product_brands')
                    ->where('team_id',$team_id)],
            ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->brandRepository->brand_add($input);       
        $brandrList = ProductBrand::orderBy('id','DESC')->first();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Brand added successfully..','data' => $brandrList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Brand update api*/
    public function BrandEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->brandRepository->brand_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Brand updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($brand_id)
    {

        $brand = ProductBrand::find($brand_id);
        if (empty($brand)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $brand->delete();      
        if(!empty($brand)){
                return response(['status'=>true,'message'=>'Brand Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function BrandMultipleDelete(Request $request)
    {
        $brand = ProductBrand::whereIn('id',$request->id)->delete();   
    
        if(!empty($brand)){
                return response(['status'=>true,'message'=>'Brand Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

     /*BrandExport*/
    public function BrandExport(Request $request ,$id = '')
    {
        $user_id   = Crypt::decrypt($id);
        $name = 'brand_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $request['user_id']   = Crypt::decrypt($id);
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new BrandExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new BrandExport($request), $name . '.xlsx'); ob_end_clean();

        }
       //$data = Excel::download(new BrandExport(), $name . '.xlsx'); ob_end_clean();

        return $data;
    }

    /*BrandPdf*/
    public function BrandPdf(Request $request,$id='') {
      // retreive all records from db
        $user_id   = Crypt::decrypt($id);
        $request = $request->all();
        if(!empty($request) && $request['id'] != '')
        {
            $data = ProductBrand::where('id',$request['id'])
                    ->where('platform', $request['platform'])
                    ->where('guard', $request['guard'])
                    ->get();

        }else{
          
            $data = ProductBrand::where('created_by',$user_id)
                    ->where('platform', $request['platform'])
                    ->where('guard', $request['guard'])
                    ->get();
        }
           
      $pdf = PDF::loadView('pdfFormat.brand', compact('data'));
      $name = 'product_' . date('Y-m-d i:h:s');
      return $pdf->download($name.'.pdf');
    }

    /*BrandImport*/
    public function BrandImport(Request $request)
    {
        $validatorArray = [
                'brand_file' => 'required|mimes:csv,txt'     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $result = Excel::toArray(new BrandImport, $request->file('brand_file'));
            $finalArray = array_filter($result[0], 'array_filter');
            $count = count($finalArray[0]);
            $countData = count($finalArray);
            $error_array = [];
            for ($j = 1; $j < $countData; $j++) {
                for ($i = 0; $i < $count; $i++) {             
                    if ($finalArray[0][$i] != '') {
                           $array[$finalArray[0][$i]] = $finalArray[$j][$i];
                       } 
                    }
                    $array['created_by'] = Auth::user()->id;
                    $array['platform']= 'Unesync';
                    $array['guard']= 'WEB';
                    /*add team id*/
                    if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                    {
                        $array['team_id'] = \Auth::user()->parent_id;
                    }else{
                        $array['team_id'] = \Auth::user()->id;
                    }
                    /*end*/
                    $requestData = ProductBrand::create($array);
                
                }

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Brand import successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
}