<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceAddFooter;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class SaleInvoiceAddFooterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'footer_img',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'footer_img',
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
        return SaleInvoiceAddFooter::class;
    }

    public function sale_invoice_add_footer_show($id)
    {
        $SaleInvoiceAddFooter = SaleInvoiceAddFooter::where('id',$id)->first();
        return $SaleInvoiceAddFooter;
    }
    
    public function sale_invoice_add_footer($input)
    {
        try {
            /**/
            SaleInvoiceAddFooter::where('invoice_id',$input['invoice_id'])->delete();
            /**/
            $requestData = new SaleInvoiceAddFooter;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->footer_on_last_page  =    (!empty($input['footer_on_last_page']) ? $input['footer_on_last_page'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            if (!empty($input['footer_img'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['footer_img'], 'footer_img', FOOTERIMG);
                if($imgResponse->status == "success"){
                     $requestData->footer_img = $imgResponse->fileUrl;
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
