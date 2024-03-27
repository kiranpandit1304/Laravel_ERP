<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\ProductServiceCategory;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CategoryRepository;
use Mail;
use Response;
use App\Exports\CategoryExport;
use App\Imports\CategoryImport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;

class CategoryAPIController extends AppBaseController
{
   
    use ApiResponser;

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /*Category list api*/
    public function CategoryList()
    {
        $requestData = $this->categoryRepository->category_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Category retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*Category show id wise*/
    public function CategoryShow($id)
    {
        $requestData = $this->categoryRepository->category_show($id);
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Category retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Category add api*/
    public function CategoryAdd(Request $request)
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
               'name' => ['required', Rule::unique('product_service_categories')->where('team_id',$team_id)],        
                            
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->categoryRepository->category_add($input);       
        $categoryList = ProductServiceCategory::orderBy('id','DESC')->first();
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Category added successfully..','data' => $categoryList]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Category update api*/
    public function CategoryEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->categoryRepository->category_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Category updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($cat_id)
    {

        $category = ProductServiceCategory::find($cat_id);
        if (empty($category)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $category->delete();      
        if(!empty($category)){
                return response(['status'=>true,'message'=>'Category Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function CategoryMultipleDelete(Request $request)
    {
        $category = ProductServiceCategory::whereIn('id',$request->id)->delete();   
    
        if(!empty($category)){
                return response(['status'=>true,'message'=>'Category Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*CategoryExport*/
    public function CategoryExport(Request $request ,$id = '')
    {
        $name = 'Category_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $request['user_id']   = Crypt::decrypt($id);
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new CategoryExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new CategoryExport($request), $name . '.xlsx'); ob_end_clean();

        }
        return $data;
    }

    /*CategoryPdf*/
    public function CategoryPdf(Request $request,$id='') {
      // retreive all records from db
        $user_id   = Crypt::decrypt($id);
        $request = $request->all();
       if(!empty($request) && $request['id'] != '')
        {
            $data = ProductServiceCategory::where('id',$request['id'])
                    ->where('platform', $request['platform'])
                    ->where('guard', $request['guard'])
                    ->get();

        }else{
          
            $data = ProductServiceCategory::where('created_by',$user_id)
                    ->where('platform', $request['platform'])
                    ->where('guard', $request['guard'])
                    ->get();
        }
           
      $pdf = PDF::loadView('pdfFormat.product_categories', compact('data'));
      $name = 'product_' . date('Y-m-d i:h:s');
      return $pdf->download($name.'.pdf');
    }

    /*CategoryImport*/
    public function CategoryImport(Request $request)
    {
        $validatorArray = [
                'category_file' => 'required|mimes:csv,txt'     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $result = Excel::toArray(new CategoryImport, $request->file('category_file'));
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
                    $requestData = ProductServiceCategory::create($array);
                
                }

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Category import successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
}