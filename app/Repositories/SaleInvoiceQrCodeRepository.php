<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceQrCode;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
/**
 * Class Profilepository
 */
class SaleInvoiceQrCodeRepository extends BaseRepository
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
        return SaleInvoiceQrCode::class;
    }

    public function sale_invoice_qr_code_list($invoice_id)
    {
        $sale_invoice_qr_code_List = SaleInvoiceQrCode::where('sale_invoice_qr_code.invoice_id',$invoice_id)->get();

        return $sale_invoice_qr_code_List;
    }
    public function sale_invoice_qr_code_show($id)
    {
        $sale_invoice_qr_code_List = SaleInvoiceQrCode::where('id',$id)->first();

        return $sale_invoice_qr_code_List;
    }

    public function sale_invoice_qr_code_add($input)
    {
        try {
            $checkExit = SaleInvoiceQrCode::where('invoice_id',$input['invoice_id'])->first();
            if(!empty($checkExit))
            {
                $requestData = SaleInvoiceQrCode::find($checkExit['id']);
            }else{

                $requestData = new SaleInvoiceQrCode;
            }
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->amount  =    (!empty($input['amount']) ? $input['amount'] : '');
            $requestData->qr_color  =    (!empty($input['qr_color']) ? $input['qr_color'] : '');
            $requestData->qr_background_color  =    (!empty($input['qr_background_color']) ? $input['qr_background_color'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            // QR LOGO
            if (!empty($input['qr_logo'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel(base64_encode($input['qr_logo']), 'qr_logo', QRLOGO);
                if($imgResponse->status == "success"){
                     $requestData->qr_logo = $imgResponse->fileUrl;
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            // QR IMAGE
            /*if (!empty($input['qr_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['qr_image'], 'qr_image', QRIMAGE);
                if($imgResponse->status == "success"){
                     $requestData->qr_image = $imgResponse->fileUrl;
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }*/
            $requestData->qr_image = $input['qr_image'];
            $requestData->save();

            return $requestData;
        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    public function sale_invoice_qr_code_edit($input)
    {
        try {
            $requestData =  SaleInvoiceQrCode::find($input['id']);
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->upi_id  =    (!empty($input['upi_id']) ? $input['upi_id'] : '');
            $requestData->amount  =    (!empty($input['amount']) ? $input['amount'] : '');
            $requestData->qr_color  =    (!empty($input['qr_color']) ? $input['qr_color'] : '');
            $requestData->qr_background_color  =    (!empty($input['qr_background_color']) ? $input['qr_background_color'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            // QR LOGO
            if (!empty($input['qr_logo'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['qr_logo'], 'qr_logo', QRLOGO);
                if($imgResponse->status == "success"){
                     $requestData->qr_logo = $imgResponse->fileUrl;
                }else{
                    $errorMessages[]= $imgResponse->message;
                }
            }
            // QR IMAGE
            if (!empty($input['qr_image'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['qr_image'], 'qr_image', QRIMAGE);
                if($imgResponse->status == "success"){
                     $requestData->qr_image = $imgResponse->fileUrl;
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
