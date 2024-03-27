<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceBusinessDetails;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleBusinessDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'business_name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'business_name',
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
        return SaleInvoiceBusinessDetails::class;
    }

    public function sale_business_details_list($invoice_id)
    {
        $sale_business_details_list = SaleInvoiceBusinessDetails::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $sale_business_details_list;
    }
    public function sale_business_details_show($id)
    {
        $sale_business_details_show = \App\Models\Business::where('business.id',$id)
        ->leftjoin('states','business.state_id','states.id')
        ->leftjoin('sale_invoice_business_details','business.id','sale_invoice_business_details.business_id')
        ->select('business.*','sale_invoice_business_details.id as sale_invoice_business_id','sale_invoice_business_details.show_email_invoice','sale_invoice_business_details.business_phone as business_phone_new','sale_invoice_business_details.show_phone_invoice','sale_invoice_business_details.current_changes_business','states.name as state','states.gst_code')
        ->first();

        return $sale_business_details_show;
    }

    public function sale_business_details_add($input)
    {
        try {
           /* $requestData = new SaleInvoiceBusinessDetails;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->business_id  =    (!empty($input['business_id']) ? $input['business_id'] : '');
            $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            $requestData->business_gst_in  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            $requestData->business_pan_no  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
            $requestData->address_country_id =    (!empty($input['address_country_id']) ? $input['address_country_id'] : '');
            $requestData->address_state_id  =    (!empty($input['address_state_id']) ? $input['address_state_id'] : '');
            $requestData->business_zip_code  =    (!empty($input['business_zip_code']) ? $input['business_zip_code'] : '');
            $requestData->street_address  =    (!empty($input['street_address']) ? $input['street_address'] : '');
            $requestData->business_email  =    (!empty($input['business_email']) ? $input['business_email'] : '');
            $requestData->show_email_invoice  =    (!empty($input['show_email_invoice']) ? $input['show_email_invoice'] : '');
            $requestData->business_phone  =    (!empty($input['business_phone']) ? $input['business_phone'] : '');
            $requestData->show_phone_invoice  =    (!empty($input['show_phone_invoice']) ? $input['show_phone_invoice'] : '');
            $requestData->current_changes_business  =    (!empty($input['current_changes_business']) ? $input['current_changes_business'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();*/

            $requestData =  \App\Models\Business::find($input['business_id']);
            if(!empty($input['business_email']))
            {
                $requestData->email  =    (!empty($input['business_email']) ? $input['business_email'] : '');
            }
            if(!empty($input['business_gst_in']))
            {
                $requestData->gst_no  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            }
            if(!empty($input['business_name']))
            {
                $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            }
            if(!empty($input['brand_name']))
            {
                $requestData->brand_name  =    (!empty($input['brand_name']) ? $input['brand_name'] : '');
            }
            if(!empty($input['business_street_address']))
            {
                $requestData->street_address  =    (!empty($input['business_street_address']) ? $input['business_street_address'] : '');
            }
            if(!empty($input['business_address_country_id']))
            {
                $requestData->country_id  =    (!empty($input['business_address_country_id']) ? $input['business_address_country_id'] : '');
            }
            if(!empty($input['business_address_state_id']))
            {
                $requestData->state_id  =    (!empty($input['business_address_state_id']) ? $input['business_address_state_id'] : '');
            }
            if(!empty($input['business_pan_no']))
            {
                $requestData->pan_no  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
            }
            if(!empty($input['bussiness_gstin']))
            {
                $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            }
            if(!empty($input['bussiness_phone']))
            {
                $requestData->bussiness_phone  = (!empty($input['bussiness_phone']) ? $input['bussiness_phone'] : '');
            }
            $requestData->save();
            if(!empty($input['business_id']) && $input['business_current_changes_business'] == 1)
            {               
                /*all business details chnage*/
                $change_all_buss =  \App\Models\SaleInvoiceBusinessDetails::where('business_id',$input['business_id'])->update($input);
               
            }

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_business_details_edit($input)
    {
        try {
            /*echo "<pre>";
            print_r($input); exit;*/
            $requestData = 1;
            $requestData =  \App\Models\Business::find($input['business_id']);
            if(!empty($input['business_email']))
            {
                $requestData->email  =    (!empty($input['business_email']) ? $input['business_email'] : '');
            }
            if(!empty($input['business_gst_in']))
            {
                $requestData->gst_no  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            }
            if(!empty($input['business_name']))
            {
                $requestData->business_name  =    (!empty($input['business_name']) ? $input['business_name'] : '');
            }
            if(!empty($input['brand_name']))
            {
                $requestData->brand_name  =    (!empty($input['brand_name']) ? $input['brand_name'] : '');
            }
            if(!empty($input['business_street_address']))
            {
                $requestData->street_address  =    (!empty($input['business_street_address']) ? $input['business_street_address'] : '');
            }
            if(!empty($input['business_address_country_id']))
            {
                $requestData->country_id  =    (!empty($input['business_address_country_id']) ? $input['business_address_country_id'] : '');
            }
            if(!empty($input['business_address_state_id']))
            {
                $requestData->state_id  =    (!empty($input['business_address_state_id']) ? $input['business_address_state_id'] : '');
            }
            if(!empty($input['business_pan_no']))
            {
                $requestData->pan_no  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
            }
            if(!empty($input['bussiness_gstin']))
            {
                $requestData->bussiness_gstin  = (!empty($input['bussiness_gstin']) ? $input['bussiness_gstin'] : '');
            }
            if(!empty($input['business_phone']))
            {
                $requestData->bussiness_phone  = (!empty($input['business_phone']) ? $input['business_phone'] : '');
            }
            if(!empty($input['business_zip_code']))
            {
                $requestData->zip_code  = (!empty($input['business_zip_code']) ? $input['business_zip_code'] : '');
            }
            $requestData->save();
            if(!empty($input['business_id']) && $input['business_current_changes_business'] == 1)
            {
                /*all business details chnage*/
                unset($input['id']);
                $SaleInvoiceBusiness['business_id']  =    (!empty($input['business_id']) ? $input['business_id'] : '');
                $SaleInvoiceBusiness['business_name']  =    (!empty($input['business_name']) ? $input['business_name'] : '');
                $SaleInvoiceBusiness['business_gst_in']  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
                $SaleInvoiceBusiness['business_pan_no']  =    (!empty($input['business_pan_no']) ? $input['business_pan_no'] : '');
                $SaleInvoiceBusiness['address_country_id'] =    (!empty($input['business_address_country_id']) ? $input['business_address_country_id'] : '');
                $SaleInvoiceBusiness['address_state_id']  =    (!empty($input['business_address_state_id']) ? $input['business_address_state_id'] : '');
                $SaleInvoiceBusiness['business_zip_code']  =    (!empty($input['business_zip_code']) ? $input['business_zip_code'] : '');
                $SaleInvoiceBusiness['street_address']  =    (!empty($input['business_street_address']) ? $input['business_street_address'] : '');
                $SaleInvoiceBusiness['business_email']  =    (!empty($input['business_email']) ? $input['business_email'] : '');
                $SaleInvoiceBusiness['show_email_invoice']  =    (!empty($input['business_show_email_invoice']) ? $input['business_show_email_invoice'] : '');
                $SaleInvoiceBusiness['business_phone']  =    (!empty($input['business_phone']) ? $input['business_phone'] : '');
                $SaleInvoiceBusiness['show_phone_invoice']  =    (!empty($input['business_show_phone_invoice']) ? $input['business_show_phone_invoice'] : '');
                $SaleInvoiceBusiness['current_changes_business']  =    (!empty($input['business_current_changes_business']) ? $input['business_current_changes_business'] : '');
                $SaleInvoiceBusiness['created_by']  =    \Auth::user()->id;
               
                $exit_check =  \App\Models\SaleInvoiceBusinessDetails::where('business_id',$input['business_id'])->first();
                if(!empty($exit_check))
                {
                    $change_all_buss =  \App\Models\SaleInvoiceBusinessDetails::where('business_id',$input['business_id'])->update($SaleInvoiceBusiness);

                }else{
                    $change_all_buss =  \App\Models\SaleInvoiceBusinessDetails::create($SaleInvoiceBusiness);
                }
            }
                
           

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
