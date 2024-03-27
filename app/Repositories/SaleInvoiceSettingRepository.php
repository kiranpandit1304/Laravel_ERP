<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceSetting;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceSettingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'signature_url',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'signature_url',
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
        return SaleInvoiceSetting::class;
    }

    public function sale_invoice_setting_show($id)
    {
        $SaleInvoiceSetting = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
        $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->first();
        return $SaleInvoiceSetting;
    }
    
    public function sale_invoice_add_setting($input)
    {
        try {
            /**/
            $SaleInvoiceSetting = SaleInvoiceSetting::where('created_by',\Auth::user()->id);
            $SaleInvoiceSetting->where('business_id',\Auth::user()->active_business_id);
            $SaleInvoiceSetting = $SaleInvoiceSetting->delete();
            /**/
            $requestData = new SaleInvoiceSetting;

            $requestData->user_id  =    \Auth::user()->id;
            $requestData->business_id  =    \Auth::user()->active_business_id;            
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->signature_labed_name  =    (!empty($input['signature_labed_name']) ? $input['signature_labed_name'] : '');;
            if (!empty($input['signature_url']) && $input['signature_url'] != 'undefined') 
            {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['signature_url'], 'signature_url', SIGNATURE);
                if($imgResponse->status == "success"){
                     $requestData->s3_signature_url = $imgResponse->fileUrl;
                     //$requestData->signature_name = @$input['signature_url']->getClientOriginalName();
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
              
           
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
   
}
