<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\AppBaseController;
use App\Models\State;
use App\Models\Customer;
use App\Models\CustomerBankDetails;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Models\Utility;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CustomerRepository;
use Mail;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Response;
use PDF;
use XML;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 


class CustomerApiController extends AppBaseController
{
   
    use ApiResponser;

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /*Customer list api*/
    public function CustomerList()
    {
        $requestData = $this->customerRepository->customer_list();

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer retrieved successfully..','data' => $requestData]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

    public function CustomerShow($id)
    {
        if(!empty($id) && $id == '0')
        {
            return response()->json(['status'=>false,'message'=>"Please select valid customer!"]);
        }
        $requestData = $this->customerRepository->customer_show($id);
        $mediaGet_data = \App\Models\CustomerFiles::where('client_id',$id)->get();
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
                return response(['status'=>true,'message'=>'Customer retrieved successfully..','data' => $requestData,'media'=>$mediaGet]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        } 
    }

   /*Customer add api*/
    public function CustomerAdd(Request $request)
    {   
       
        $input = $request->all();
        if(!empty($request->guard) && $request->guard == 'APP')
        {
            $validatorArray = [
                    'name' => 'required',              
                    'billing_phone' => 'required|unique:customers',
                    
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
        $requestData = $this->customerRepository->customer_add($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer added successfully..','client_id' => $requestData->id]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*AddCustomerInvoice add api*/
    public function AddCustomerInvoice(Request $request)
    {   
       
        $input = $request->all();
        if(!empty($request->guard) && $request->guard == 'APP')
        {
            $validatorArray = [
                    'name' => 'required',              
                    'billing_phone' => 'required|unique:customers',
                    
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
        $requestData = $this->customerRepository->customer_add_invoice($input); 
        $get_last_data = Customer::orderBy('id','DESC')->first();      

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer added successfully..','data' => $get_last_data]);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*CustomerAddmMedia*/
    public function CustomerAddMedia(Request $request)
    {
        $input = $request->all();
        $requestData = $this->customerRepository->customer_add_media($input);       

        if(!empty($requestData)){
                return response(['status'=>true, "success" => true,'message'=>'Customer add media successfully..']);
        }else{

            return response()->json(['status'=>false, "success" => false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*delete api*/
    public function CustomerMediadelete($mediad_id)
    {

        $customer_media = \App\Models\CustomerFiles::find($mediad_id);       
        if (empty($customer_media)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }
        /*S3 delete code*/
        if(!empty($customer_media))
        {
            if(!empty($customer_media->customer_doc) && $customer_media->customer_doc != '')
            {
                $delete_media = explode('/',$customer_media->customer_doc);
                $file = base64_decode($delete_media['2']);
                $media_delete = Storage::disk('s3')->delete($file);
            }
        }
        /*end s3 deletc code*/
        $customer_media->delete();   
    
        if(!empty($customer_media)){
                return response(['status'=>true,'message'=>'Customer media Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Customer update api*/
    public function CustomerUpdate(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->customerRepository->customer_update($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer add details successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

     /*Customer update api*/
    public function CustomerEdit(Request $request)
    {   
       
        $input = $request->all();
        $requestData = $this->customerRepository->customer_edit($input);       

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer updated successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }
    /*delete api*/
    public function destroy($customer_id)
    {

        $customer = Customer::find($customer_id);
        if (empty($customer)) {
            return response()->json(['status'=>false,'message'=>"Data not found.."]);
        }        
        $customer->delete(); 
        /*customer img delete*/
        /*s3 delete code*/ 
        $customer_image = \App\Models\CustomerFiles::where('client_id',$customer_id)->get(); 
        if(!empty($customer_image))
        {
            foreach ($customer_image as $value) {
                if(!empty($value->customer_doc) && $value->customer_doc != '')
                {
                    $delete_media = explode('/',$value->customer_doc);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }        
        /*customer img delete*/   
        $CustomerFiles = \App\Models\CustomerFiles::where('client_id',$customer_id)->delete();      
        $CustomerBankDetails = \App\Models\CustomerBankDetails::where('client_id',$customer_id)->delete();      
    
        if(!empty($customer)){
                return response(['status'=>true,'message'=>'Customer Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*Delete multiple record*/
    public function CustomerMuilipleDelete(Request $request)
    {
        $customer = Customer::whereIn('id',$request->id)->delete(); 
        /*customer img delete*/
        /*s3 delete code*/ 
        $customer_image = \App\Models\CustomerFiles::whereIn('client_id',$request->id)->get(); 
        if(!empty($customer_image))
        {
            foreach ($customer_image as $value) {
                if(!empty($value->customer_doc) && $value->customer_doc != '')
                {
                    $delete_media = explode('/',$value->customer_doc);
                    $file = base64_decode($delete_media['2']);
                    $media_delete = Storage::disk('s3')->delete($file);
                }
            }
        }        
        /*customer img delete*/   
        $CustomerFiles = \App\Models\CustomerFiles::whereIn('client_id',$request->id)->delete();      
        $CustomerBankDetails = \App\Models\CustomerBankDetails::whereIn('client_id',$request->id)->delete();      
    
        if(!empty($customer)){
                return response(['status'=>true,'message'=>'Customer Delete successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    /*CustomerExport*/
    public function CustomerExport(Request $request ,$id = '')
    {
        $request['user_id']   = Crypt::decrypt($id);
        $name = 'customer_' . date('Y-m-d i:h:s');
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$request['user_id'])->first();
        $request['business_id'] = $getBusinessId['active_business_id'];
        if(!empty($request) && $request['id'] != '')
        {
            $data = Excel::download(new CustomerExport($request), $name . '.xlsx'); ob_end_clean();
        }else{

            $data = Excel::download(new CustomerExport($request), $name . '.xlsx'); ob_end_clean();

        }

        return $data;
    }

    /*CustomerExport xml*/
    public function CustomerExportToXml()
    {
        $customers = Customer::leftjoin('customer_bank_details','customers.id','customer_bank_details.client_id');
        $customers->select('customers.id','customers.name','customers.tax_number','customers.email','customers.nature_of_business','customers.contact_person','customers.billing_phone as contact','customer_bank_details.upi','customer_bank_details.payment_terms_days');
        $customers = $customers->get();

        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument();
        $xml->startElement('customer');
        foreach($customers as $customer) {
            $xml->startElement('data');
            $xml->writeAttribute('id', $customer->id);
            $xml->writeAttribute('name', $customer->name);
            $xml->writeAttribute('gst_no', $customer->tax_number);
            $xml->writeAttribute('email', $customer->email);
            $xml->writeAttribute('nature_of_business', $customer->nature_of_business);
            $xml->writeAttribute('contact_person', $customer->contact_person);
            $xml->writeAttribute('contact', $customer->contact);
            $xml->writeAttribute('upi', $customer->upi);
            $xml->writeAttribute('payment_terms_days', $customer->payment_terms_days);
            $xml->endElement();
        }
        $xml->endElement();
        $xml->endDocument();

        $content = $xml->outputMemory();
        $xml = null;

        return response($content)->header('Content-Type', 'text/xml');
    }


    /*CustomerPdf*/
     public function CustomerPdf(Request $request,$id='') {
      // retreive all records from db
        $user_id   = Crypt::decrypt($id);
        $request = $request->all();
        $getBusinessId = \App\Models\User::where('id',$user_id)->first();

        if(!empty($request) && $request['id'] != '')
        {
            $data = Customer::whereIn('customers.id',$request['id']);
            $data->where('customers.business_id',$getBusinessId['active_business_id']);
            //$data->where('customers.platform',$request['platform']);
            //$data->where('customers.guard',$request['guard']);
            $data->leftjoin('customer_bank_details','customers.id','customer_bank_details.client_id');
            $data->select('customers.name','customers.tax_number','customers.email','customers.nature_of_business','customers.contact_person','customers.billing_phone as contact','customer_bank_details.upi','customer_bank_details.payment_terms_days');
            $data = $data->get();

        }else{
            
            $data = Customer::leftjoin('customer_bank_details','customers.id','customer_bank_details.client_id');
            $data->where('customers.created_by',$user_id);
            $data->where('customers.business_id',$getBusinessId['active_business_id']);
            //$data->where('customers.platform',$request['platform']);
            //$data->where('customers.guard',$request['guard']);
            $data->select('customers.name','customers.tax_number','customers.email','customers.nature_of_business','customers.contact_person','customers.billing_phone as contact','customer_bank_details.upi','customer_bank_details.payment_terms_days');
            $data = $data->get();
        }

      $pdf = PDF::loadView('pdfFormat.customer', compact('data'));
      $name = 'customer_' . date('Y-m-d i:h:s');
      return $pdf->download($name.'.pdf');
    }

    public function CustomerImport(Request $request)
    {
        $validatorArray = [
                'customer_file' => 'required|mimes:csv,txt'     
        ];
        $validator      = \Validator::make($request->all(), $validatorArray);
        if($validator->fails())
        {
            return response()->json(['status'=>false,'message'=>$validator->errors()->first()]);
        }
        
        $result = Excel::toArray(new CustomerImport, $request->file('customer_file'));
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
                $requestData = Customer::create($array);
                $last_record = Customer::orderBy('id','DESC')->first();
                $bank_array['client_id'] = $last_record->id;
                 /*add bank details*/
                $bnakDetails = new CustomerBankDetails;
                $bnakDetails->client_id  =    (!empty($bank_array['client_id']) ? $bank_array['client_id'] : '');
                $bnakDetails->bank_name  =    (!empty($bank_array['bank_name']) ? $bank_array['bank_name'] : '');
                $bnakDetails->ifsc_code  =    (!empty($bank_array['ifsc_code']) ? $bank_array['ifsc_code'] : '');
                $bnakDetails->account_no =    (!empty($bank_array['account_no']) ? $bank_array['account_no'] : '');
                $bnakDetails->branch_address =    (!empty($bank_array['branch_address']) ? $bank_array['branch_address'] : '');
                $bnakDetails->country_id =    (!empty($bank_array['country_id']) ? $bank_array['country_id'] : '');
                $bnakDetails->country_name =    (!empty($bank_array['country_name']) ? $bank_array['country_name'] : '');
                $bnakDetails->state_id =    (!empty($bank_array['state_id']) ? $bank_array['state_id'] : '');
                $bnakDetails->state_name =    (!empty($bank_array['state_name']) ? $bank_array['state_name'] : '');
                $bnakDetails->upi =    (!empty($bank_array['upi']) ? $bank_array['upi'] : '');
                $bnakDetails->zip_code =    (!empty($bank_array['zip_code']) ? $bank_array['zip_code'] : '');
                $bnakDetails->payment_terms_days =    (!empty($bank_array['payment_terms_days']) ? $bank_array['payment_terms_days'] : '');
                $bnakDetails->save();
                }

        if(!empty($requestData)){
                return response(['status'=>true,'message'=>'Customer import successfully..']);
        }else{

            return response()->json(['status'=>false,'message'=>"Something went wrong.Please try later!"]);
        }
    }

    
}