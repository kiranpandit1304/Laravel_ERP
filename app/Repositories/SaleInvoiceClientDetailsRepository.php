<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceClientDetails;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceClientDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
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
        return SaleInvoiceClientDetails::class;
    }

    public function sale_client_details_list($invoice_id)
    {
        $sale_client_details_list = SaleInvoiceClientDetails::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $sale_client_details_list;
    }
    public function sale_client_details_show($id)
    {
        $sale_client_details_show = \App\Models\Customer::where('customers.id',$id)
        ->leftjoin('states','customers.billing_state','states.id')
        ->leftjoin('sale_invoice_client_details','customers.id','sale_invoice_client_details.client_id')
        ->select('customers.*','sale_invoice_client_details.show_email_invoice','sale_invoice_client_details.client_phone','sale_invoice_client_details.show_phone_invoice','sale_invoice_client_details.current_changes_business','states.name as state','states.gst_code')
        ->first();
        return $sale_client_details_show;
    }

    public function sale_client_details_add($input)
    {
        try {
            /*$requestData = new SaleInvoiceClientDetails;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->client_id  =    (!empty($input['client_id']) ? $input['client_id'] : '');
            $requestData->name  =    (!empty($input['name']) ? $input['name'] : '');
            $requestData->client_gst_in  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
            $requestData->client_pan_no  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
            $requestData->address_country_id =    (!empty($input['address_country_id']) ? $input['address_country_id'] : '');
            $requestData->address_state_id  =    (!empty($input['address_state_id']) ? $input['address_state_id'] : '');
            $requestData->address_zip_code  =    (!empty($input['address_zip_code']) ? $input['address_zip_code'] : '');
            $requestData->street_address  =    (!empty($input['street_address']) ? $input['street_address'] : '');
            $requestData->client_email  =    (!empty($input['client_email']) ? $input['client_email'] : '');
            $requestData->show_email_invoice  =    (!empty($input['show_email_invoice']) ? $input['show_email_invoice'] : '');
            $requestData->client_phone  =    (!empty($input['client_phone']) ? $input['business_phone'] : '');
            $requestData->show_phone_invoice  =    (!empty($input['show_phone_invoice']) ? $input['show_phone_invoice'] : '');
            $requestData->current_changes_business  =    (!empty($input['current_changes_business']) ? $input['current_changes_business'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();*/


            if(!empty($input['client_id']) && $input['client_current_changes_business'] == 1)
            {
                
                /* echo "<pre>";
                print_r($input); exit;
                /*all business details chnage*/
                $change_all_buss =  \App\Models\SaleInvoiceClientDetails::where('client_id',$input['client_id'])->update($input);
                $requestData =  \App\Models\Customer::find($input['client_id']);
                if(!empty($input['client_gst_in']))
                {
                    $requestData->tax_number  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
                }
                if(!empty($input['client_email']))
                {
                    $requestData->email  =    (!empty($input['client_email']) ? $input['client_email'] : '');
                }
                if(!empty($input['business_gst_in']))
                {
                    $requestData->gst_no  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
                }
                if(!empty($input['client_business_name']))
                {
                    $requestData->name  =    (!empty($input['client_business_name']) ? $input['client_business_name'] : '');
                }
                if(!empty($input['client_street_address']))
                {
                    $requestData->billing_address  =    (!empty($input['client_street_address']) ? $input['client_street_address'] : '');
                }
                if(!empty($input['client_address_country_id']))
                {
                    $requestData->billing_country  =    (!empty($input['client_address_country_id']) ? $input['client_address_country_id'] : '');
                }
                if(!empty($input['client_address_state_id']))
                {
                    $requestData->billing_state  =    (!empty($input['client_address_state_id']) ? $input['client_address_state_id'] : '');
                }
                if(!empty($input['client_pan_no']))
                {
                    $requestData->pan  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
                }
                if(!empty($input['client_phone']))
                {
                    $requestData->billing_phone  =    (!empty($input['client_phone']) ? $input['client_phone'] : '');
                }
                $requestData->save();
            }

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_client_details_edit($input)
    {
       /* echo "<pre>";
        print_r($input); exit;*/
        try {
            $requestData = 1;
            $requestData =  \App\Models\Customer::find($input['client_id']);
            if(!empty($input['client_gst_in']))
            {
                $requestData->tax_number  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
            }
            if(!empty($input['client_email']))
            {
                $requestData->email  =    (!empty($input['client_email']) ? $input['client_email'] : '');
            }
            if(!empty($input['business_gst_in']))
            {
                $requestData->gst_no  =    (!empty($input['business_gst_in']) ? $input['business_gst_in'] : '');
            }
            if(!empty($input['client_business_name']))
            {
                $requestData->name  =    (!empty($input['client_business_name']) ? $input['client_business_name'] : '');
            }
            if(!empty($input['client_street_address']))
            {
                $requestData->billing_address  =    (!empty($input['client_street_address']) ? $input['client_street_address'] : '');
            }
            if(!empty($input['client_address_country_id']))
            {
                $requestData->billing_country  =    (!empty($input['client_address_country_id']) ? $input['client_address_country_id'] : '');
            }
            if(!empty($input['client_address_state_id']))
            {
                $requestData->billing_state  =    (!empty($input['client_address_state_id']) ? $input['client_address_state_id'] : '');
            }
            if(!empty($input['client_pan_no']))
            {
                $requestData->pan  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
            }
            if(!empty($input['client_phone']))
            {
                $requestData->billing_phone  =    (!empty($input['client_phone']) ? $input['client_phone'] : '');
            }
            if(!empty($input['client_address_zip_code']))
            {
                $requestData->billing_zip  =    (!empty($input['client_address_zip_code']) ? $input['client_address_zip_code'] : '');
            }
            /*echo "<pre>";
            print_r($requestData->billing_phone); exit;*/
            $requestData->save();
            if(!empty($input['client_id']) && $input['client_current_changes_business'] == 1)
            {
                /*all business details chnage*/
                unset($input['id']);
                $SaleInvoiceClient['client_id']  =    (!empty($input['client_id']) ? $input['client_id'] : '');
                $SaleInvoiceClient['name']  =    (!empty($input['client_business_name']) ? $input['client_business_name'] : '');
                $SaleInvoiceClient['client_gst_in']  =    (!empty($input['client_gst_in']) ? $input['client_gst_in'] : '');
                $SaleInvoiceClient['client_pan_no']  =    (!empty($input['client_pan_no']) ? $input['client_pan_no'] : '');
                $SaleInvoiceClient['address_country_id'] =    (!empty($input['client_address_country_id']) ? $input['client_address_country_id'] : '');
                $SaleInvoiceClient['address_state_id']  =    (!empty($input['client_address_state_id']) ? $input['client_address_state_id'] : '');
                $SaleInvoiceClient['street_address']   =    (!empty($input['client_street_address']) ? $input['client_street_address'] : '');
                $SaleInvoiceClient['address_zip_code']  =    (!empty($input['client_address_zip_code']) ? $input['client_address_zip_code'] : '');
                $SaleInvoiceClient['client_email']  =    (!empty($input['client_email']) ? $input['client_email'] : '');
                $SaleInvoiceClient['show_email_invoice']  =    (!empty($input['client_show_email_invoice']) ? $input['client_show_email_invoice'] : '');
                $SaleInvoiceClient['client_phone']  =    (!empty($input['client_phone']) ? $input['business_phone'] : '');
                $SaleInvoiceClient['show_phone_invoice']  =    (!empty($input['client_show_phone_invoice']) ? $input['client_show_phone_invoice'] : '');
                $SaleInvoiceClient['current_changes_business']  =    (!empty($input['client_current_changes_business']) ? $input['client_current_changes_business'] : '');
                $SaleInvoiceClient['created_by']  =    \Auth::user()->id;
                $change_all_buss =  \App\Models\SaleInvoiceClientDetails::where('client_id',$input['client_id'])->update($SaleInvoiceClient);
                
            }
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
