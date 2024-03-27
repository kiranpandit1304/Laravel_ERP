<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceShare;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
/**
 * Class Profilepository
 */
class SaleInvoiceShareRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'mesg_type',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'mesg_type',
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
        return SaleInvoiceShare::class;
    }

    public function sale_invoice_share_list($invoice_id)
    {
        $sale_invoice_share_List = SaleInvoiceShare::where('sale_invoice_share.invoice_id',$invoice_id)->get();

        return $sale_invoice_share_List;
    }
    public function sale_invoice_share_show($id)
    {
        $sale_invoice_share_List = SaleInvoiceShare::where('id',$id)->first();

        return $sale_invoice_share_List;
    }

    public function sale_invoice_share_add($input,$invoice,$GetCustData)
    {
        try {
            $requestData = new SaleInvoiceShare;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->mesg_type  =    (!empty($input['mesg_type']) ? $input['mesg_type'] : '');
            $requestData->recipient  =    (!empty($invoice['customer_name']) ? $invoice['customer_name'] : '');
            if(!empty($input['mesg_type']) && $input['mesg_type'] != 'email')
            {
                $requestData->mobile_no  =    (!empty($GetCustData['billing_phone']) ? $GetCustData['billing_phone'] : '');

            }
            $requestData->created_by = \Auth::user()->id;
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_share_edit($input)
    {
        try {
            $requestData =  SaleInvoiceShare::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->mesg_type  =    (!empty($input['mesg_type']) ? $input['mesg_type'] : '');
            $requestData->recipient  =    (!empty($input['recipient']) ? $input['recipient'] : '');
            $requestData->mobile_no  =    (!empty($input['mobile_no']) ? $input['mobile_no'] : '');
            $requestData->save();
            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
