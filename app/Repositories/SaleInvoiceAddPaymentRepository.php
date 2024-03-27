<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceAddPayment;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceAddPaymentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'amount_received',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'amount_received',
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
        return SaleInvoiceAddPayment::class;
    }

    public function sale_invoice_add_payment_list($invoice_id)
    {
        $saleInvoiceAddPaymentList = SaleInvoiceAddPayment::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $saleInvoiceAddPaymentList;
    }
    public function sale_invoice_add_payment_show($id)
    {
        $saleInvoiceAddPaymentList = SaleInvoiceAddPayment::where('id',$id)->first();

        return $saleInvoiceAddPaymentList;
    }

    public function sale_invoice_add_payment_add($input)
    {
        try {
            $amount_recived = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])
                                                            ->sum('amount_received');

            $total_tcs_amount =  SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])->sum('tcs_amount');
            $total_tds_amount =  SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])->sum('tds_amount');
            $total_transaction_charge =  SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])->sum('transaction_charge');

            $SaleInvoice= \App\Models\SaleInvoice::where('id',@$input['invoice_id'])->select('sale_invoice.invoice_no','sale_invoice.customer_name','sale_invoice.final_total','sale_invoice.final_amount','sale_invoice.due_date')->first();

            
            $last_amount_recived = \App\Models\SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])
                                                            ->orderBy('id',"DESC")
                                                            ->first();
           

            $data['invoice_no'] = @$SaleInvoice->invoice_no;
            $data['customer_name'] = @$SaleInvoice->customer_name;
            $data['final_total'] = @$SaleInvoice->final_total;
            $data['total_pay_amount'] = @$amount_recived;
            $data['due_amount'] =  @$SaleInvoice->final_total - $amount_recived;
            $data['last_paid_amount'] =  @$last_amount_recived->amount_received;
            $data['total_amount'] =  @$SaleInvoice->final_amount;

            $total_tcs = @$total_tcs_amount +  @$input['tcs_amount'];
            $total_tds_amount = @$total_tds_amount_amount +  @$input['total_tds_amount'];
            $total_transaction = @$total_transaction_charge +  @$input['transaction_charge'];
            $amount_recived_total = @$input['amount_received'] +@$amount_recived ;
            //echo $total_tcs; exit;
            $check = @$amount_recived_total + @$total_tcs + @$total_tds + @$total_transaction;

            /*if(empty($total_tcs_amount) || empty($total_tcs_amount) || empty($total_tds_amount))
            { 
                $check = @$amount_recived + @$total_tcs_amount + @$total_tds_amount + @$total_transaction_charge + $input['amount_received'];
            }else{
                $check = @$input['amount_received'] + @$input['tds_amount'] + @$input['tcs_amount'] + @$input['transaction_charge'];
            }*/
            /*$total_amount_to_settle =  SaleInvoiceAddPayment::where('invoice_id',@$input['invoice_id'])->sum('amount_to_settle');
           echo  $total_amount_to_settle + $check; exit;*/
            //echo  $check; exit;


            if($last_amount_recived->amount_recived == '0')
            {
                $pay_status = "Unpaid";
            }
            else if($data['final_total'] !=  $check && $data['final_total'] > $check)
            {
                $pay_status = "Part Paid";
            }
            else if($data['final_total'] ==  $check && $data['final_total'] < $check)
            {
                $pay_status = "Paid";
            }
            else if($data['final_total'] < $check)
            {
                $pay_status = "Paid";
            }
           /* else if($SaleInvoice['due_date'] < date('d-m-Y'))
            {
                $pay_status = "Overdue";
            }*/
            else{
                 $pay_status = "Paid";
            }

            $update_status = \App\Models\SaleInvoice::where('id',$input['invoice_id'])->update(['payment_status' => @$pay_status]);

            $requestData = new SaleInvoiceAddPayment;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->amount_received  =    (!empty($input['amount_received']) ? $input['amount_received'] : '');
            $requestData->transaction_charge  =    (!empty($input['transaction_charge']) ? $input['transaction_charge'] : '');
            $requestData->tds_percentage  =    (!empty($input['tds_percentage']) ? $input['tds_percentage'] : '');
            $requestData->tds_amount  =    (!empty($input['tds_amount']) ? $input['tds_amount'] : '');
            $requestData->tcs_percentage  =    (!empty($input['tcs_percentage']) ? $input['tcs_percentage'] : '');
            $requestData->tcs_amount  =    (!empty($input['tcs_amount']) ? $input['tcs_amount'] : '');
            $requestData->amount_to_settle  =    (!empty($input['amount_to_settle']) ? $input['amount_to_settle'] : '');
            $requestData->payment_date  =    (!empty($input['payment_date']) ? $input['payment_date'] : '');
            $requestData->payment_method  =    (!empty($input['payment_method']) ? $input['payment_method'] : '');
            $requestData->additional_notes  =    (!empty($input['additional_notes']) ? $input['additional_notes'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            //$requestData->payment_status  =    @$pay_status;
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_add_payment_edit($input)
    {
        try {
            $requestData =  SaleInvoiceAddPayment::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->amount_received  =    (!empty($input['amount_received']) ? $input['amount_received'] : '');
            $requestData->transaction_charge  =    (!empty($input['transaction_charge']) ? $input['transaction_charge'] : '');
            $requestData->tds_percentage  =    (!empty($input['tds_percentage']) ? $input['tds_percentage'] : '');
            $requestData->tds_amount  =    (!empty($input['tds_amount']) ? $input['tds_amount'] : '');
            $requestData->tcs_percentage  =    (!empty($input['tcs_percentage']) ? $input['tcs_percentage'] : '');
            $requestData->tcs_amount  =    (!empty($input['tcs_amount']) ? $input['tcs_amount'] : '');
            $requestData->amount_to_settle  =    (!empty($input['amount_to_settle']) ? $input['amount_to_settle'] : '');
            $requestData->payment_date  =    (!empty($input['payment_date']) ? $input['payment_date'] : '');
            $requestData->payment_method  =    (!empty($input['payment_method']) ? $input['payment_method'] : '');
            $requestData->additional_notes  =    (!empty($input['additional_notes']) ? $input['additional_notes'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
