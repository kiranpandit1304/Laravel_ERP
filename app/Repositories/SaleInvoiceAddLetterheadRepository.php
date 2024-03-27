<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\SaleInvoiceAddLetterhead;
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
class SaleInvoiceAddLetterheadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'letterhead_img',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'letterhead_img',
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
        return SaleInvoiceAddLetterhead::class;
    }

    
    public function sale_invoice_add_letterhead_show($id)
    {
        $saleInvoiceAddLetterhead = SaleInvoiceAddLetterhead::where('id',$id)->first();

        return $saleInvoiceAddLetterhead;
    }

    public function sale_invoice_add_letterhead_add($input)
    {
        try {
            /**/
            SaleInvoiceAddLetterhead::where('invoice_id',$input['invoice_id'])->delete();
            /**/
            $requestData = new SaleInvoiceAddLetterhead;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->letterhead_on_first_page  =    (!empty($input['letterhead_on_first_page']) ? $input['letterhead_on_first_page'] : '');
            $requestData->created_by  =    \Auth::user()->id;
            if (!empty($input['letterhead_img'])) {
                $errorMessages = array();            
                $imgResponse = CommonHelper::s3UploadFilesSingel($input['letterhead_img'], 'letterhead_img', LETTERHEADIMG);
                if($imgResponse->status == "success"){
                     $requestData->letterhead_img = $imgResponse->fileUrl;
                     //$requestData->business_logo_name =  @$input['business_logo']->getClientOriginalName();
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

    public function sale_invoice_add_footer_show($id)
    {
        $saleInvoiceAddFooter = SaleInvoiceAddFooter::where('id',$id)->first();
        return $saleInvoiceAddFooter;
    }

    public function sale_invoice_add_footer_add($input)
    {
        try {
            /**/
            SaleInvoiceAddFooter::where('invoice_id',$input['invoice_id'])->delete();
            /**/
            $requestData = new SaleInvoiceAddFooter;
            $requestData->invoice_id  =    (!empty($input['invoice_id']) ? $input['invoice_id'] : '');
            $requestData->footer_on_last_page  =    (!empty($input['footer_on_last_page']) ? $input['letterhead_on_first_page'] : '');
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
