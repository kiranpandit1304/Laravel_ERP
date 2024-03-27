<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Vender;
use App\Models\VenderBankDetails;
use App\Models\VenderFiles;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper; 
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class VenderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'created_at',
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
        'email',
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
        return Vender::class;
    }

    public function vender_list()
    {
        $vendersList = Vender::where('venders.created_by',\Auth::user()->id);
        $vendersList->where('venders.business_id',\Auth::user()->active_business_id);
       // $vendersList->where('venders.platform',\Auth::user()->platform);
        // $vendersList->where('venders.guard',\Auth::user()->guard);
        $vendersList->leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
        $vendersList->select('venders.*','venders_bank_details.bank_name','venders_bank_details.ifsc_code','venders_bank_details.account_no','venders_bank_details.branch_address','venders_bank_details.country_id','venders_bank_details.state_id','venders_bank_details.upi','venders_bank_details.payment_terms_days','venders_bank_details.zip_code');
        $vendersList = $vendersList->get();

        return $vendersList;
    }
    public function vender_show($id)
    {
        $vendersList = Vender::where('venders.id',$id);
        $vendersList->leftjoin('venders_bank_details','venders.id','venders_bank_details.vendor_id');
        $vendersList->select('venders.*','venders_bank_details.bank_name','venders_bank_details.ifsc_code','venders_bank_details.account_no','venders_bank_details.branch_address','venders_bank_details.country_id','venders_bank_details.state_id','venders_bank_details.upi','venders_bank_details.payment_terms_days','venders_bank_details.country_name','venders_bank_details.state_name','venders_bank_details.zip_code');
        $vendersList = $vendersList->first();

        return $vendersList;
    }

    public function vender_add($input)
    {
        try {
            if(!empty($input['guard']) && $input['guard'] == 'APP')
            {
                $requestData = $this->add_mobile_vender($input);
                return $requestData;
            }
            else
            {
                $requestData = new Vender;
                $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
                $requestData->tax_number   =    (!empty($input['gst_no']) ? $input['gst_no'] : '');
                $requestData->platform   =    (!empty($input['platform']) ? $input['platform'] : '');
                $requestData->guard   =    (!empty($input['guard']) ? $input['guard'] : '');
                $requestData->business_id   =    (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
                $requestData->warehouse_id   =    (!empty(\Auth::user()->warehouse_id) ? \Auth::user()->warehouse_id : '');
                $requestData->created_by   =    \Auth::user()->id;
                /*add team id*/
                if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                {
                    $requestData->team_id = \Auth::user()->parent_id;
                }else{
                    $requestData->team_id = \Auth::user()->id;
                }
                /*end*/
                $requestData->save();
            }
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    public function add_mobile_vender($input)
    {

        try {
            $requestData = new Vender;
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->tax_number   =    (!empty($input['gst_no']) ? $input['gst_no'] : '');
            $requestData->platform   =    (!empty($input['platform']) ? $input['platform'] : '');
            $requestData->guard   =    (!empty($input['guard']) ? $input['guard'] : '');
            $requestData->created_by   =    \Auth::user()->id;
            $requestData->billing_address  = (!empty($input['billing_address']) ? $input['billing_address'] : '');
            $requestData->billing_country  = (!empty($input['billing_country']) ? $input['billing_country'] : '');
            $requestData->billing_state  = (!empty($input['billing_state']) ? $input['billing_state'] : '');
            $requestData->billing_country_name  = (!empty($input['billing_country_name']) ? $input['billing_country_name'] : '');
            $requestData->billing_state_name  = (!empty($input['billing_state_name']) ? $input['billing_state_name'] : '');
            $requestData->email  = (!empty($input['email']) ? $input['email'] : '');
            $requestData->nature_of_business  = (!empty($input['nature_of_business']) ? $input['nature_of_business'] : '');
            $requestData->contact_person  = (!empty($input['contact_person']) ? $input['contact_person'] : '');
            $requestData->billing_phone  = (!empty($input['billing_phone']) ? $input['billing_phone'] : '');
            $requestData->billing_zip  = (!empty($input['billing_zip']) ? $input['billing_zip'] : '');
            $requestData->shipping_address  = (!empty($input['shipping_address']) ? $input['shipping_address'] : '');
            $requestData->shipping_country  = (!empty($input['shipping_country']) ? $input['shipping_country'] : '');
            $requestData->shipping_state  = (!empty($input['shipping_state']) ? $input['shipping_state'] : '');

            $requestData->shipping_country_name  = (!empty($input['shipping_country_name']) ? $input['shipping_country_name'] : '');
            $requestData->shipping_state_name  = (!empty($input['shipping_state_name']) ? $input['shipping_state_name'] : '');

            $requestData->shipping_zip  = (!empty($input['shipping_zip']) ? $input['shipping_zip'] : '');
            $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            $requestData->pan  = (!empty($input['pan']) ? $input['pan'] : '');
            $requestData->is_msme  = (!empty($input['is_msme']) ? $input['is_msme'] : '0');
            $requestData->billing_city  = (!empty($input['billing_city']) ? $input['billing_city'] : '');
            $requestData->shipping_city  = (!empty($input['shipping_city']) ? $input['shipping_city'] : '');
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                 $requestData->team_id = \Auth::user()->parent_id;
            }else{
                 $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();
            $customer_id = Vender::orderBy('id','DESC')->first();
                /*Add bank details*/
                $bnakDetails = new VenderBankDetails;
                $bnakDetails->vendor_id  =    (!empty($customer_id['id']) ? $customer_id['id'] : '');
                $bnakDetails->bank_name  =    (!empty($input['bank_name']) ? $input['bank_name'] : '');
                $bnakDetails->ifsc_code  =    (!empty($input['ifsc_code']) ? $input['ifsc_code'] : '');
                $bnakDetails->account_no =    (!empty($input['account_no']) ? $input['account_no'] : '');
                $bnakDetails->branch_address =    (!empty($input['branch_address']) ? $input['branch_address'] : '');
                $bnakDetails->country_id =    (!empty($input['country_id']) ? $input['country_id'] : '');
                $bnakDetails->country_name =    (!empty($input['country_name']) ? $input['country_name'] : '');
                $bnakDetails->state_id =    (!empty($input['state_id']) ? $input['state_id'] : '');
                $bnakDetails->state_name =    (!empty($input['state_name']) ? $input['state_name'] : '');
                $bnakDetails->upi =    (!empty($input['upi']) ? $input['upi'] : '');
                $bnakDetails->zip_code =    (!empty($input['zip_code']) ? $input['zip_code'] : '');
                $bnakDetails->payment_terms_days =    (!empty($input['payment_terms_days']) ? $input['payment_terms_days'] : '');
                $bnakDetails->save();

                # save media
                $image = @$input['customer_doc'];
                if (!empty($image)) {
                    for ($i = 0; $i < count($image); $i++) {
                        if ($image[$i] != '') {
                            if (isset($image[$i]) && $image[$i] != '') {
                                $errorMessages = array();                                    
                                $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'vendor_doc', VENDOR_DOC);
                                if($imgResponse->status == "success"){
                                    $input['vendor_doc'] = $imgResponse->fileUrl;
                                }else{
                                    $errorMessages[]= $imgResponse->message;
                                }

                                $custFile['vendor_id'] = (!empty($customer_id['id']) ? $customer_id['id'] : '');;
                                $custFile['vendor_doc'] = $input['vendor_doc'];
                                $custFile['vendor_doc_name'] =  @$image[$i]->getClientOriginalName();
                                $requestData = VenderFiles::create($custFile);
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

    public function vender_update($input)
    {
        try {
            $requestData =  Vender::find($input['id']);
            $requestData->billing_address  = (!empty($input['billing_address']) ? $input['billing_address'] : '');
            $requestData->billing_country  = (!empty($input['billing_country']) ? $input['billing_country'] : '');
            $requestData->billing_state  = (!empty($input['billing_state']) ? $input['billing_state'] : '');
            $requestData->billing_country_name  = (!empty($input['billing_country_name']) ? $input['billing_country_name'] : '');
            $requestData->billing_state_name  = (!empty($input['billing_state_name']) ? $input['billing_state_name'] : '');
            $requestData->email  = (!empty($input['email']) ? $input['email'] : '');
            $requestData->nature_of_business  = (!empty($input['nature_of_business']) ? $input['nature_of_business'] : '');
            $requestData->contact_person  = (!empty($input['contact_person']) ? $input['contact_person'] : '');
            $requestData->billing_phone  = (!empty($input['billing_phone']) ? $input['billing_phone'] : '');
            $requestData->billing_zip  = (!empty($input['billing_zip']) ? $input['billing_zip'] : '');
            $requestData->shipping_address  = (!empty($input['shipping_address']) ? $input['shipping_address'] : '');
            $requestData->shipping_country  = (!empty($input['shipping_country']) ? $input['shipping_country'] : '');
            $requestData->shipping_state  = (!empty($input['shipping_state']) ? $input['shipping_state'] : '');

            $requestData->shipping_country_name  = (!empty($input['shipping_country_name']) ? $input['shipping_country_name'] : '');
            $requestData->shipping_state_name  = (!empty($input['shipping_state_name']) ? $input['shipping_state_name'] : '');

            $requestData->shipping_zip  = (!empty($input['shipping_zip']) ? $input['shipping_zip'] : '');
            $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            $requestData->pan  = (!empty($input['pan']) ? $input['pan'] : '');
            $requestData->is_msme  = (!empty($input['is_msme']) ? $input['is_msme'] : '0');
            $requestData->billing_city  = (!empty($input['billing_city']) ? $input['billing_city'] : '');
            $requestData->shipping_city  = (!empty($input['shipping_city']) ? $input['shipping_city'] : '');
            if ($requestData->save()) {
                /*Add bank details*/
                $bnakDetails = new VenderBankDetails;
                $bnakDetails->vendor_id  =    (!empty($input['id']) ? $input['id'] : '');
                $bnakDetails->bank_name  =    (!empty($input['bank_name']) ? $input['bank_name'] : '');
                $bnakDetails->ifsc_code  =    (!empty($input['ifsc_code']) ? $input['ifsc_code'] : '');
                $bnakDetails->account_no =    (!empty($input['account_no']) ? $input['account_no'] : '');
                $bnakDetails->branch_address =    (!empty($input['branch_address']) ? $input['branch_address'] : '');
                $bnakDetails->country_id =    (!empty($input['country_id']) ? $input['country_id'] : '');
                $bnakDetails->country_name =    (!empty($input['country_name']) ? $input['country_name'] : '');
                $bnakDetails->state_id =    (!empty($input['state_id']) ? $input['state_id'] : '');
                $bnakDetails->state_name =    (!empty($input['state_name']) ? $input['state_name'] : '');
                $bnakDetails->upi =    (!empty($input['upi']) ? $input['upi'] : '');
                $bnakDetails->payment_terms_days =    (!empty($input['payment_terms_days']) ? $input['payment_terms_days'] : '');
                $bnakDetails->zip_code =    (!empty($input['zip_code']) ? $input['zip_code'] : '');
                $bnakDetails->save();

                # save media
                $image = @$input['customer_doc'];
                if (!empty($image)) {
                    for ($i = 0; $i < count($image); $i++) {
                        if ($image[$i] != '') {
                            if (isset($image[$i]) && $image[$i] != '') {
                                $errorMessages = array();                                    
                                $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'vendor_doc', VENDOR_DOC);
                                if($imgResponse->status == "success"){
                                    $input['vendor_doc'] = $imgResponse->fileUrl;
                                }else{
                                    $errorMessages[]= $imgResponse->message;
                                }

                                $custFile['vendor_id'] = (!empty($input['id']) ? $input['id'] : '');;
                                $custFile['vendor_doc'] = $input['vendor_doc'];
                                $custFile['vendor_doc_name'] =  @$image[$i]->getClientOriginalName();
                                $requestData = VenderFiles::create($custFile);
                            }
                        }
                    }
                    
                }
                # end media Code ...
                return $requestData;
            }
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /*vender_add_media*/
    public function vender_add_media($input)
    {
        try {
            $image = $input['customer_doc'];
            if (!empty($image)) {
                \App\Models\VenderFiles::where('vendor_id', $input['vendor_id'])->delete();
                for ($i = 0; $i < count($image); $i++) {
                    if ($image[$i] != '') {
                        if (isset($image[$i]) && $image[$i] != '') {
                            $errorMessages = array();                                    
                            $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'vendor_doc', VENDOR_DOC);
                            if($imgResponse->status == "success"){
                                $input['vendor_doc'] = $imgResponse->fileUrl;
                            }else{
                                $errorMessages[]= $imgResponse->message;
                            }

                            $custFile['vendor_id'] = (!empty($input['client_id']) ? $input['client_id'] : '');;
                            $custFile['vendor_doc'] = $input['vendor_doc'];
                            $custFile['vendor_doc_name'] =  @$image[$i]->getClientOriginalName();
                            $requestData = VenderFiles::create($custFile);
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

    public function vender_edit($input)
    {
        try {
            
            $requestData =  Vender::find($input['id']);
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->tax_number   =    (!empty($input['gst_no']) ? $input['gst_no'] : '');
            $requestData->billing_address  = (!empty($input['billing_address']) ? $input['billing_address'] : '');
            $requestData->billing_country  = (!empty($input['billing_country']) ? $input['billing_country'] : '');
            $requestData->billing_state  = (!empty($input['billing_state']) ? $input['billing_state'] : '');
            $requestData->billing_country_name  = (!empty($input['billing_country_name']) ? $input['billing_country_name'] : '');
            $requestData->billing_state_name  = (!empty($input['billing_state_name']) ? $input['billing_state_name'] : '');
            $requestData->email  = (!empty($input['email']) ? $input['email'] : '');
            $requestData->nature_of_business  = (!empty($input['nature_of_business']) ? $input['nature_of_business'] : '');
            $requestData->contact_person  = (!empty($input['contact_person']) ? $input['contact_person'] : '');
            $requestData->billing_phone  = (!empty($input['billing_phone']) ? $input['billing_phone'] : '');
            $requestData->billing_zip  = (!empty($input['billing_zip']) ? $input['billing_zip'] : '');
            $requestData->shipping_address  = (!empty($input['shipping_address']) ? $input['shipping_address'] : '');
            $requestData->shipping_country  = (!empty($input['shipping_country']) ? $input['shipping_country'] : '');
            $requestData->shipping_state  = (!empty($input['shipping_state']) ? $input['shipping_state'] : '');
            $requestData->shipping_zip  = (!empty($input['shipping_zip']) ? $input['shipping_zip'] : '');
            $requestData->shipping_country_name  = (!empty($input['shipping_country_name']) ? $input['shipping_country_name'] : '');
            $requestData->shipping_state_name  = (!empty($input['shipping_state_name']) ? $input['shipping_state_name'] : '');
            $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            $requestData->pan  = (!empty($input['pan']) ? $input['pan'] : '');
            $requestData->is_msme  = (!empty($input['is_msme']) ? $input['is_msme'] : '0');
            $requestData->billing_city  = (!empty($input['billing_city']) ? $input['billing_city'] : '');
            $requestData->shipping_city  = (!empty($input['shipping_city']) ? $input['shipping_city'] : '');
            $requestData->save();


            /*edit bank details*/
            //\App\Models\VenderBankDetails::where('vendor_id',$input['id'])->delete();
            $bnakDetails_data = VenderBankDetails::where('vendor_id',$input['id'])->first();
            $bnakDetails['vendor_id']  =    (!empty($input['id']) ? $input['id'] : '');
            $bnakDetails['bank_name']  =    (!empty($input['bank_name']) ? $input['bank_name'] : '');
            $bnakDetails['ifsc_code']  =    (!empty($input['ifsc_code']) ? $input['ifsc_code'] : '');
            $bnakDetails['account_no'] =    (!empty($input['account_no']) ? $input['account_no'] : '');
            $bnakDetails['branch_address'] =    (!empty($input['branch_address']) ? $input['branch_address'] : '');
            $bnakDetails['country_id'] =    (!empty($input['country_id']) ? $input['country_id'] : '');
            $bnakDetails['country_name'] =    (!empty($input['country_name']) ? $input['country_name'] : '');
            $bnakDetails['state_id'] =    (!empty($input['state_id']) ? $input['state_id'] : '');
            $bnakDetails['state_name'] =    (!empty($input['state_name']) ? $input['state_name'] : '');
            $bnakDetails['upi'] =    (!empty($input['upi']) ? $input['upi'] : '');
            $bnakDetails['payment_terms_days'] =    (!empty($input['payment_terms_days']) ? $input['payment_terms_days'] : '');
            $bnakDetails['zip_code'] =    (!empty($input['zip_code']) ? $input['zip_code'] : '');
            if(!empty( $bnakDetails_data))
            {
                $bnakDetails = VenderBankDetails::where('vendor_id',$input['id'])->update($bnakDetails);
                
            }else{
                $bnakDetails = VenderBankDetails::create($bnakDetails);

            }
            # save media
            $image = @$input['customer_doc'];
            if (!empty($image)) {
                for ($i = 0; $i < count($image); $i++) {
                    if ($image[$i] != '') {
                        if (isset($image[$i]) && $image[$i] != '') {
                            $errorMessages = array();                                    
                            $imgResponse = CommonHelper::s3UploadFilesMultiple($image[$i], 'vendor_doc', VENDOR_DOC);
                            if($imgResponse->status == "success"){
                                $input['vendor_doc'] = $imgResponse->fileUrl;
                            }else{
                                $errorMessages[]= $imgResponse->message;
                            }

                            $custFile['vendor_id'] = (!empty($input['id']) ? $input['id'] : '');;
                            $custFile['vendor_doc'] = $input['vendor_doc'];
                            $custFile['vendor_doc_name'] =  @$image[$i]->getClientOriginalName();
                            $requestData = VenderFiles::create($custFile);
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
}
