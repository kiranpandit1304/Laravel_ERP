<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceChargeLateFee;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceChargeLateFeeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'fee_type',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'fee_type',
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
        return SaleInvoiceChargeLateFee::class;
    }

    public function sale_invoice_charge_late_fee_list($invoice_id)
    {
        $sale_invoice_charge_late_fee_list = SaleInvoiceChargeLateFee::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $sale_invoice_charge_late_fee_list;
    }
    public function sale_invoice_charge_late_fee_show($id)
    {
        $sale_invoice_charge_late_fee_show = SaleInvoiceChargeLateFee::where('id',$id)->first();

        return $sale_invoice_charge_late_fee_show;
    }

    public function sale_invoice_charge_late_fee_add($input)
    {
        try {
            $requestData = new SaleInvoiceChargeLateFee;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->enable_late  =    (!empty($input['enable_late']) ? $input['enable_late'] : '');
            $requestData->show_in_invoice  =    (!empty($input['show_in_invoice']) ? $input['show_in_invoice'] : '');
            $requestData->fee_type  =    (!empty($input['fee_type']) ? $input['fee_type'] : '');
            $requestData->fee_amount  =    (!empty($input['fee_amount']) ? $input['fee_amount'] : '');
            $requestData->days_after_due_date  =    (!empty($input['days_after_due_date']) ? $input['days_after_due_date'] : '');
            $requestData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $requestData->hsn_code  =    (!empty($input['hsn_code']) ? $input['hsn_code'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_charge_late_fee_edit($input)
    {
        try {
            $requestData =  SaleInvoiceChargeLateFee::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->enable_late  =    (!empty($input['enable_late']) ? $input['enable_late'] : '');
            $requestData->show_in_invoice  =    (!empty($input['show_in_invoice']) ? $input['show_in_invoice'] : '');
            $requestData->fee_type  =    (!empty($input['fee_type']) ? $input['fee_type'] : '');
            $requestData->fee_amount  =    (!empty($input['fee_amount']) ? $input['fee_amount'] : '');
            $requestData->days_after_due_date  =    (!empty($input['days_after_due_date']) ? $input['days_after_due_date'] : '');
            $requestData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
            $requestData->hsn_code  =    (!empty($input['hsn_code']) ? $input['hsn_code'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
