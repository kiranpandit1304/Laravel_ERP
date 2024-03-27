<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\BaseUnit;
use App\Models\ProductServiceUnit;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UnitRepository;
use Mail;
use Response;

class UnitAPIController extends AppBaseController
{
   
    use ApiResponser;

    private $unitRepository;

    public function __construct(UnitRepository $unitRepository)
    {
        $this->unitRepository = $unitRepository;
    }

    /*Unit list api*/
    public function UnitList()
    {
        $requestData = $this->unitRepository->unit_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Unit retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Unit show id wise*/
    public function UnitShow($id)
    {
        $requestData = $this->unitRepository->unit_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Unit retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Unit add api*/
    public function UnitAdd(Request $request)
    {   
       
        $input = $request->all();
        $validatorArray = [
                'name' => 'required',              
                
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->unitRepository->unit_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Unit added successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Unit update api*/
    public function UnitEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->unitRepository->unit_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Unit updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($unit_id)
    {

        $unit = ProductServiceUnit::find($unit_id);
        if (empty($unit)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $unit->delete();      
        if(!empty($unit)){
                return response(['status'=>true,'message'=>'Unit Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function UnitMultipleDelete(Request $request)
    {
        $unit = BaseUnit::whereIn('id',$request->id)->delete();   
    
        if(!empty($unit)){
                return response(['status'=>true,'message'=>'Unit Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}