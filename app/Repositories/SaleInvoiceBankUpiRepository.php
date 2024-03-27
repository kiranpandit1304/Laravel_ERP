<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceBankUpi;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
/**
 * Class Profilepository
 */
class SaleInvoiceBankUpiRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'upi_id',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'upi_id',
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
        return SaleInvoiceBankUpi::class;
    }

    public function sale_invoice_bank_upi_list()
    {
        $sale_invoice_bank_upi_List = SaleInvoiceBankUpi::where('sale_invoice_bank_upi.business_id',\Auth::user()->active_business_id)->get();

        return $sale_invoice_bank_upi_List;
    }
    public function sale_invoice_bank_upi_show($id)
    {
        $sale_invoice_bank_upi_List = SaleInvoiceBankUpi::where('id',$id)->first();

        return $sale_invoice_bank_upi_List;
    }

    public function sale_invoice_bank_upi_add($input)
    {
        try {
            $getUser =  \App\Models\User::where('id',\Auth::user()->id)->first();
                $team_id =  $getUser->parent_id;
                if ($getUser->parent_id == 0) {
                    $team_id = $getUser->id;
                }
             $SaleInvoiceBankDetails = SaleInvoiceBankUpi::where('team_id',$team_id)->where('business_id',\Auth::user()->active_business_id)->update(['is_active' => '0']);

            $requestData = new SaleInvoiceBankUpi;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->show_invoice  =    (!empty($input['show_invoice']) ? $input['show_invoice'] : '');
            $requestData->is_active  =    1;
            $requestData->created_by  =    \Auth::user()->id;
            $get_record = SaleInvoiceBankUpi::where('invoice_id',$input['invoice_id'])->get()->toArray();
            if(empty($get_record) && count($get_record) == 0)
            {
                $requestData->is_active  = "1";
            }
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_bank_upi_edit($input)
    {
        try {
            $requestData =  SaleInvoiceBankUpi::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->business_id = (!empty(\Auth::user()->active_business_id) ? \Auth::user()->active_business_id : '');
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->show_invoice  =    (!empty($input['show_invoice']) ? $input['show_invoice'] : '');
            //$requestData->is_active  =    (!empty($input['is_active']) ? $input['is_active'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $requestData->team_id = \Auth::user()->parent_id;
            }else{
                $requestData->team_id = \Auth::user()->id;
            }
            /*end*/
            $requestData->save();
           return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
