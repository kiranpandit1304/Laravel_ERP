<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceProvideEinvoiceDetails;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceProvideEinvoiceDetailsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'gstin',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'gstin',
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
        return SaleInvoiceProvideEinvoiceDetails::class;
    }

    public function sale_invoice_provide_einvoice_details_list($invoice_id)
    {
        $sale_invoice_provide_einvoice_details_list = SaleInvoiceProvideEinvoiceDetails::where('created_by',\Auth::user()->id)
                    ->where('invoice_id',$invoice_id)
                    ->get();

        return $sale_invoice_provide_einvoice_details_list;
    }
    public function sale_invoice_provide_einvoice_details_show($id)
    {
        $sale_invoice_provide_einvoice_details_show = SaleInvoiceProvideEinvoiceDetails::where('id',$id)->first();

        return $sale_invoice_provide_einvoice_details_show;
    }

    public function sale_invoice_provide_einvoice_details_add($input)
    {
        try {
            $requestData = new SaleInvoiceProvideEinvoiceDetails;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->gstin  =    (!empty($input['gstin']) ? $input['gstin'] : '');
            $requestData->gsp_username  =    (!empty($input['gsp_username']) ? $input['gsp_username'] : '');
            $requestData->gsp_password  =    (!empty($input['gsp_password']) ? $input['gsp_password'] : '');
            $requestData->save_credentials_browser_only  =    (!empty($input['save_credentials_browser_only']) ? $input['save_credentials_browser_only'] : '');
            $requestData->save_credentials_across_all  =    (!empty($input['save_credentials_across_all']) ? $input['save_credentials_across_all'] : '');
            $requestData->created_by  =    \Auth::user()->id;
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
            $requestData =  SaleInvoiceProvideEinvoiceDetails::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->gstin  =    (!empty($input['gstin']) ? $input['gstin'] : '');
            $requestData->gsp_username  =    (!empty($input['gsp_username']) ? $input['gsp_username'] : '');
            $requestData->gsp_password  =    (!empty($input['gsp_password']) ? $input['gsp_password'] : '');
            $requestData->save_credentials_browser_only  =    (!empty($input['save_credentials_browser_only']) ? $input['save_credentials_browser_only'] : '');
            $requestData->save_credentials_across_all  =    (!empty($input['save_credentials_across_all']) ? $input['save_credentials_across_all'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
