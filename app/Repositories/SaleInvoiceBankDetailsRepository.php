<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceBankDetails;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
/**
 * Class Profilepository
 */
class SaleInvoiceBankDetailsRepository extends BaseRepository
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
        return SaleInvoiceBankDetails::class;
    }

    public function sale_invoice_bank_details_list()
    {
        $sale_invoice_bank_details_List = SaleInvoiceBankDetails::where('sale_invoice_bank_details.business_id',\Auth::user()->active_business_id)->get();

        return $sale_invoice_bank_details_List;
    }
    public function sale_invoice_bank_details_show($id)
    {
        $sale_invoice_bank_details_List = SaleInvoiceBankDetails::where('id',$id)->first();

        return $sale_invoice_bank_details_List;
    }

    public function sale_invoice_bank_details_add($input)
    {
        try {
            $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
            $team_id =  $getUser->parent_id;
            if ($getUser->parent_id == 0) {
                $team_id = $getUser->id;
            }

            $SaleInvoiceBankDetails = SaleInvoiceBankDetails::where('team_id',$team_id)->where('business_id',\Auth::user()->active_business_id)->update(['is_show' => '0']);

            $requestData = new SaleInvoiceBankDetails;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->ifsc  =    (!empty($input['ifsc']) ? $input['ifsc'] : '');
            $requestData->account_no  =    (!empty($input['account_no']) ? $input['account_no'] : '');
            $requestData->bank_name  =    (!empty($input['bank_name']) ? $input['bank_name'] : '');
            $requestData->country_id  =    (!empty($input['country_id']) ? $input['country_id'] : '');
            $requestData->iban  =    (!empty($input['iban']) ? $input['iban'] : '');
            $requestData->swift_code  =    (!empty($input['swift_code']) ? $input['swift_code'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->account_type  =    (!empty($input['account_type']) ? $input['account_type'] : '');
            $requestData->account_holder_name  =    (!empty($input['account_holder_name']) ? $input['account_holder_name'] : '');
            $requestData->is_show  =    1;
            $requestData->mobile_no  =    (!empty($input['mobile_no']) ? $input['mobile_no'] : '');
            if(!empty($input['custom_bank_details_key']))
            {
                $custom_bank_details_data = [];
                for($i = 0; $i < count($input['custom_bank_details_key']); $i++)
                {
                    if(!empty($input['custom_bank_details_key'][$i]) && !empty($input['custom_bank_details_value'][$i])){
                      $custom_bank_details_data[$i]['key'] = array($input['custom_bank_details_key'][$i]);
                      $custom_bank_details_data[$i]['value'] = array($input['custom_bank_details_value'][$i]);
                      //$custom_bank_details_data = array($input['custom_bank_details_key'][$i] => $input['custom_bank_details_value'][$i]);
                    }
                }                
                $requestData->custom_bank_details  =    json_encode($custom_bank_details_data);
            }
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $get_record = SaleInvoiceBankDetails::where('invoice_id',$input['invoice_id'])->get()->toArray();
            if(empty($get_record) && count($get_record) == 0)
            {
                $requestData->is_show  = "1";
            }
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_bank_details_edit($input)
    {
        try {
            
            $requestData =  SaleInvoiceBankDetails::find($input['id']);
            $requestData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->ifsc  =    (!empty($input['ifsc']) ? $input['ifsc'] : '');
            $requestData->account_no  =    (!empty($input['account_no']) ? $input['account_no'] : '');
            $requestData->bank_name  =    (!empty($input['bank_name']) ? $input['bank_name'] : '');
            $requestData->country_id  =    (!empty($input['country_id']) ? $input['country_id'] : '');
            $requestData->iban  =    (!empty($input['iban']) ? $input['iban'] : '');
            $requestData->swift_code  =    (!empty($input['swift_code']) ? $input['swift_code'] : '');
            $requestData->currency  =    (!empty($input['currency']) ? $input['currency'] : '');
            $requestData->account_type  =    (!empty($input['account_type']) ? $input['account_type'] : '');
            $requestData->account_holder_name  =    (!empty($input['account_holder_name']) ? $input['account_holder_name'] : '');
            $requestData->mobile_no  =    (!empty($input['mobile_no']) ? $input['mobile_no'] : '');
            if(!empty($input['custom_bank_details_key']))
            {
                $custom_bank_details_data = [];
                for($i = 0; $i < count($input['custom_bank_details_key']); $i++)
                {
                    if(!empty($input['custom_bank_details_key'][$i]) && !empty($input['custom_bank_details_value'][$i])){
                       $custom_bank_details_data[$i]['key'] = array($input['custom_bank_details_key'][$i]);
                       $custom_bank_details_data[$i]['value'] = array($input['custom_bank_details_value'][$i]);
                    }
                }                
                $requestData->custom_bank_details  =    json_encode($custom_bank_details_data);
            }
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
