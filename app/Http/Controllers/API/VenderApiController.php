<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\State;
use App\Models\Vender;
use App\Models\VenderBankDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\VenderRepository;
use Mail;
use App\Exports\VendorExport;
use App\Imports\VendorImport;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


class VenderApiController extends AppBaseController
{
   
    use ApiResponser;

    private $venderRepository;

    public function __construct(VenderRepository $venderRepository)
    {
        $this->venderRepository = $venderRepository;
    }

    /*vender list api*/
    public function VenderList()
    {
        $requestData = $this->venderRepository->vender_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vender retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }
    /*vender show api*/
    public function VenderShow($id)
    {
        $requestData = $this->venderRepository->vender_show($id);
        $mediaGet_data = \App\Models\VenderFiles::where('vendor_id',$id)->select('venders_files.id','venders_files.vendor_id as client_id','venders_files.vendor_doc as customer_doc')->get();;
        $count =0;
        foreach ($mediaGet_data as $value) {
            if(!is_null($value->customer_doc)){
                    $profile_image = CommonHelper::getS3FileUrl($value->customer_doc);
                    if($profile_image->status == "success"){
                        $value->customer_doc = $profile_image->fileUrl;
                    }
                }
         $mediaGet[$count] = $value; 
         $count++;
        }
        
        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vender retrieved successfully..','data' => $requestData,'media'=>$mediaGet]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*vender add api*/
    public function VenderAdd(Request $request)
    {   
       
        $input = $request->all();
        if(!empty($request->guard) && $request->guard == 'APP')
        {
            $validatorArray = [
                    'name' => 'required',              
                    'billing_phone' => 'required|unique:venders',
                    
            ];
        }else{
            $validatorArray = [
                    'name' => 'required',              
                    
            ];
        }
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        $requestData = $this->venderRepository->vender_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vender added successfully..','client_id' => $requestData->id]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*venderAddmMedia*/
    public function VenderAddMedia(Request $request)
    {
        $input = $request->all();
        $requestData = $this->venderRepository->vender_add_media($input);       

        if(!empty($requestData)){
                return response(['status'=>true, "success" => true,'message'=>'Vender add media successfully..']);
        }else{

            return response()->json(['status'=>false, "success" => false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*delete api*/
    public function VenderMediadelete($mediad_id)
    {

        $vender_media = \App\Models\VenderFiles::find($mediad_id);       
        if (empty($vender_media)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 delete code*/
        if(!empty($vender_media))
        {
            if(!empty($vender_media->vendor_doc) && $vender_media->vendor_doc != '')
            {
                $delete_media = explode('/',$vender_media->vendor_doc);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        /*end s3 deletc code*/
        $vender_media->delete();   
    
        if(!empty($vender_media)){
                return response(['status'=>true,'message'=>'Vender media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Vender update api*/
    public function VenderUpdate(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->venderRepository->vender_update($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vender add details successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

     /*Vender update api*/
    public function VenderEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->venderRepository->vender_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vender updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($vendor_id)
    {

        $vender = Vender::find($vendor_id);
        if (empty($vender)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        $vender->delete();   
        /*vendor doc img delete*/
        /*s3 delete code*/ 
        $vendor_image = \App\Models\VenderFiles::where('vendor_id',$vendor_id)->get(); 
        if(!empty($vendor_image))
        {
            foreach ($vendor_image as $value) {
                if(!empty($value->vendor_doc) && $value->vendor_doc != '')
                {
                    $delete_media = explode('/',$value->vendor_doc);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }        
        /*vendor img delete*/ 
        $CustomerFiles = \App\Models\VenderFiles::where('vendor_id',$vendor_id)->delete();      
        $VenderBankDetails = \App\Models\VenderBankDetails::where('vendor_id',$vendor_id)->delete();      
    
        if(!empty($vender)){
                return response(['status'=>true,'message'=>'Vender Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function VenderMuilipleDelete(Request $request)
    {
        $vender = Vender::whereIn('id',$request->id)->delete(); 
        /*vendor doc img delete*/
        /*s3 delete code*/ 
        $vendor_image = \App\Models\VenderFiles::whereIn('vendor_id',$request->id)->get(); 
        if(!empty($vendor_image))
        {
            foreach ($vendor_image as $value) {
                if(!empty($value->vendor_doc) && $value->vendor_doc != '')
                {
                    $delete_media = explode('/',$value->vendor_doc);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }        
        /*vendor img delete*/   
        $VenderFiles = \App\Models\VenderFiles::whereIn('vendor_id',$request->id)->delete();      
        $VenderBankDetails = \App\Models\VenderBankDetails::whereIn('vendor_id',$request->id)->delete();      
    
        if(!empty($vender)){
                return response(['status'=>true,'message'=>'Vender Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*VendorExport*/
    public function VenderExport(Request $request ,$id='')
    {
        $name = 'vender_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $request['user_id']   = Crypt::decrypt($id);
        $getBusinessId = \App\Models\User::where('id',$request['user_id'])->first();
        $request['business_id'] = $getBusinessId['active_business_id'];
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new VendorExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new VendorExport($request), $name . '.xlsx'); ob_end_clean();

        }

        return $data;
    }

    /*venderExport xml*/
    public function VenderExportToXml()
    {
        $venders = Vender::leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
        $venders->select('venders.id','venders.name','venders.tax_number','venders.email','venders.nature_of_business','venders.contact_person','venders.billing_phone as contact','venders_bank_details.upi','venders_bank_details.payment_terms_days');
        $venders = $venders->get();

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('vender');
        foreach($venders as $vender) {
            $xml->startElement('data');
            $xml->writeAttribute('id', $vender->id);
            $xml->writeAttribute('name', $vender->name);
            $xml->writeAttribute('gst_no', $vender->tax_number);
            $xml->writeAttribute('email', $vender->email);
            $xml->writeAttribute('nature_of_business', $vender->nature_of_business);
            $xml->writeAttribute('contact_person', $vender->contact_person);
            $xml->writeAttribute('contact', $vender->contact);
            $xml->writeAttribute('upi', $vender->upi);
            $xml->writeAttribute('payment_terms_days', $vender->payment_terms_days);
            $xml->endElement();
        }
        $xml->endElement();
        $xml->endDocument();

        $content = $xml->outputMemory();
        $xml = null;

        return response($content)->header('Content-Type', 'text/xml');
    }


    /*VenderPdf*/
     public function VenderPdf(Request $request,$id='') {
      // retreive all records from db
        $user_id   = Crypt::decrypt($id);
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$user_id)->first();
        if(!empty($request) && $request['id'] != '')
        {
            $data = Vender::whereIn('venders.id',$request['id']);
            $data->where('venders.business_id',$getBusinessId['active_business_id']);
           // $data->where('venders.platform',$request['platform']);
            //$data->where('venders.guard',$request['guard']);
            $data->leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
            $data->select('venders.name','venders.tax_number','venders.email','venders.nature_of_business','venders.contact_person','venders.billing_phone as contact','venders_bank_details.upi','venders_bank_details.payment_terms_days');
            $data = $data->get();

        }else{
            $data = Vender::leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
            $data->where('venders.created_by',$user_id);
            $data->where('venders.business_id',$getBusinessId['active_business_id']);
            //$data->where('venders.platform',$request['platform']);
            //$data->where('venders.guard',$request['guard']);
            $data->select('venders.name','venders.tax_number','venders.email','venders.nature_of_business','venders.contact_person','venders.billing_phone as contact','venders_bank_details.upi','venders_bank_details.payment_terms_days');
            $data = $data->get();
        }

      $pdf = PDF::loadView('pdfFormat.vender', compact('data'));
      $name = 'vender_' . date('Y-m-d i:h:s');
      return $pdf->download($name.'.pdf');
    }

    public function VenderImport(Request $request)
    {
        $validatorArray = [
                'customer_file' => 'required|mimes:csv,txt'     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $result = Excel::toArray(new VendorImport, $request->file('customer_file'));
            $finalArray = array_filter($result[0], 'array_filter');
            $count = count($finalArray[0]);
            $countData = count($finalArray);
            $error_array = [];
            for ($j = 1; $j < $countData; $j++) {
                for ($i = 0; $i < $count; $i++) {
                if($finalArray[0][$i] == 'gst_number')
                {
                    $array['tax_number']= $finalArray[$j][$i];
                }
                if($finalArray[0][$i] == 'billing_country')
                {
                    $country = \App\Models\Country::where('name',$finalArray[$j][$i])->first(); 
                    $billing_country= @$country['id'];
                    $array['billing_country_name']= @$country['name'];
                   
                }
                if($finalArray[0][$i] == 'billing_state')
                {
                    $state =  \App\Models\State::where('name',$finalArray[$j][$i])->first();
                    $billing_state= @$state['id'];
                    $array['billing_state_name']= @$state['name']; 
                    
                }
                if($finalArray[0][$i] == 'shipping_country')
                {
                    $country = \App\Models\Country::where('name',$finalArray[$j][$i])->first(); 
                    $shipping_country= @$country['id'];
                    $array['shipping_country_name']= @$country['name'];
                }
                if($finalArray[0][$i] == 'shipping_state')
                {
                    $state =  \App\Models\State::where('name',$finalArray[$j][$i])->first();
                    $shipping_state= @$state['id'];
                    $array['shipping_state_name']= @$state['name'];
                }
                if($finalArray[0][$i] == 'country_id')
                {
                    $country = \App\Models\Country::where('name',$finalArray[$j][$i])->first(); 
                    $bank_array['country_id']= @$country['id'];
                    $bank_array['country_name']= @$country['name'];
                }
                if($finalArray[0][$i] == 'state_id')
                {
                    $state =  \App\Models\State::where('name',$finalArray[$j][$i])->first();
                    $bank_array['state_id']= @$state['id'];
                    $bank_array['state_name']= @$state['name'];
                }
                /*add bank details*/
                if($finalArray[0][$i] == 'bank_name' || $finalArray[0][$i] == 'ifsc_code' || $finalArray[0][$i] == 'account_no' || $finalArray[0][$i] == 'branch_address'  || $finalArray[0][$i] == 'zip_code' || $finalArray[0][$i] == 'upi' || $finalArray[0][$i] == 'payment_terms_days')
                {
                     /*add bank-details*/
                      if ($finalArray[0][$i] != '') {
                        $bank_array[$finalArray[0][$i]] = $finalArray[$j][$i];
                    }
                }
                
                /*main code*/
                if ($finalArray[0][$i] != '') {
                       $array['platform']= 'Unesync';
                       $array['guard']= 'WEB';
                       $array['is_active']= '1';
                       $array[$finalArray[0][$i]] = $finalArray[$j][$i];
                   } 
                }
                if($array['is_msme'] == 'Yes' || $array['is_msme'] == 'yes')
                {
                    $array['is_msme'] = '1';
                }
                else
                {
                    $array['is_msme'] = '0';

                }
                unset($array['gst_number']);
                $array['created_by'] = Auth::user()->id;
                $array['business_id']   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                $array['warehouse_id']   =    (!empty(\Auth::user()->warehouse_id) ? \Auth::user()->warehouse_id : '');
                $array['billing_country'] = $billing_country;
                $array['billing_state'] = $billing_state;
                $array['shipping_country'] = $shipping_country;
                $array['shipping_state'] = $shipping_state;
                /*add team id*/
                if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                {
                      $array['team_id'] = \Auth::user()->parent_id;
                }else{
                      $array['team_id'] = \Auth::user()->id;
                }
                /*end*/
                $requestData = Vender::create($array);
                $last_record = Vender::orderBy('id','DESC')->first();
                $bank_array['vendor_id'] = $last_record->id;
                 /*add bank details*/
                $bnakDetails = new VenderBankDetails;
                $bnakDetails->vendor_id  =    (!empty($bank_array['vendor_id']) ? $bank_array['vendor_id'] : '');
                $bnakDetails->bank_name  =    (!empty($bank_array['bank_name']) ? $bank_array['bank_name'] : '');
                $bnakDetails->ifsc_code  =    (!empty($bank_array['ifsc_code']) ? $bank_array['ifsc_code'] : '');
                $bnakDetails->account_no =    (!empty($bank_array['account_no']) ? $bank_array['account_no'] : '');
                $bnakDetails->branch_address =    (!empty($bank_array['branch_address']) ? $bank_array['branch_address'] : '');
                $bnakDetails->country_id =    (!empty($bank_array['country_id']) ? $bank_array['country_id'] : '');
                $bnakDetails->country_name =    (!empty($bank_array['country_name']) ? $bank_array['country_name'] : '');
                $bnakDetails->state_id =    (!empty($bank_array['state_id']) ? $bank_array['state_id'] : '');
                $bnakDetails->state_name =    (!empty($bank_array['state_name']) ? $bank_array['state_name'] : '');
                $bnakDetails->upi =    (!empty($bank_array['upi']) ? $bank_array['upi'] : '');
                $bnakDetails->payment_terms_days =    (!empty($bank_array['payment_terms_days']) ? $bank_array['payment_terms_days'] : '');
                $bnakDetails->zip_code =    (!empty($bank_array['zip_code']) ? $bank_array['zip_code'] : '');
                $bnakDetails->save();

                }

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Vendor import successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}