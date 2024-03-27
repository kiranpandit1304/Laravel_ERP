<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceKycDetails;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceKycDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'document_number',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'document_number',
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
        return SaleInvoiceKycDetails::class;
    }

    public function sale_invoice_kyc_list($invoice_id)
    {
        $sale_invoice_kyc_list = SaleInvoiceKycDetails::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $sale_invoice_kyc_list;
    }
    public function sale_invoice_kyc_show($id)
    {
        $sale_invoice_kyc_show = SaleInvoiceKycDetails::where('id',$id)->first();

        return $sale_invoice_kyc_show;
    }

    public function sale_invoice_kyc_add($input)
    {
        try {
            $requestData = new SaleInvoiceKycDetails;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->document_number  =    (!empty($input['document_number']) ? $input['document_number'] : '');
            $requestData->document_type  =    (!empty($input['document_type']) ? $input['document_type'] : '');
            $requestData->evidence_type  =    (!empty($input['evidence_type']) ? $input['evidence_type'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_kyc_edit($input)
    {
        try {
            $requestData =  SaleInvoiceKycDetails::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->document_number  =    (!empty($input['document_number']) ? $input['document_number'] : '');
            $requestData->document_type  =    (!empty($input['document_type']) ? $input['document_type'] : '');
            $requestData->evidence_type  =    (!empty($input['evidence_type']) ? $input['evidence_type'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
