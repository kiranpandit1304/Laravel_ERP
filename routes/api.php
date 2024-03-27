<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*New Route*/
Route::post('/mobile_send_otp','API\AuthApiController@mobile_send_otp');
Route::post('/register','API\AuthApiController@register');
Route::post('/verify_otp','API\AuthApiController@verify_otp');
Route::post('/resend_otp','API\AuthApiController@resend_otp');
Route::post('/update_password','API\AuthApiController@update_password');
Route::post('/login','API\AuthApiController@login');
Route::post('/login_via_otp_send','API\AuthApiController@login_via_otp_send');
Route::post('/login_via_otp','API\AuthApiController@login_via_otp');
Route::post('/reset_password_send_otp','API\AuthApiController@reset_password_send_otp');
Route::post('/reset_password','API\AuthApiController@reset_password');

Route::post('/testUserDelete','API\AuthApiController@testUserDelete');

Route::post('/CustomerAddMedia ','API\CustomerApiController@CustomerAddMedia');


//Route::post('login', 'ApiController@login');
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', 'ApiController@logout');
    /*Invite route*/
    Route::get('/moduleList','API\InviteApiController@moduleList');
    Route::get('/inviteeUsersList/{id?}','API\InviteApiController@inviteeUsersList');
    Route::get('/module_has_permissions','API\InviteApiController@module_has_permissions');
    Route::post('/send_invite','API\InviteApiController@send_invite');
    Route::get('/get_user_modules/{id?}','API\InviteApiController@get_user_modules');
    Route::get('/UserPermissonList/{id?}','API\InviteApiController@UserPermissonList');
    Route::post('/UserPermissonEdit','API\InviteApiController@UserPermissonEdit');

    Route::get('/sendInviteList','API\InviteApiController@sendInviteList');
    Route::get('/sendInviteShow/{id?}','API\InviteApiController@sendInviteShow');
    Route::get('/sendInviteDelete/{id?}','API\InviteApiController@destroy');
    Route::post('/sendInviteMuilipleDelete','API\InviteApiController@sendInviteMuilipleDelete');

    /**/
    /*profile route*/
    Route::get('/stateList/{id?}','API\ProfileApiController@stateList');
    Route::post('/profileUpdate','API\ProfileApiController@profileUpdate');
    Route::post('/activeBusinessIdUpdate ','API\ProfileApiController@activeBusinessIdUpdate');
    Route::get('/getGstDetails/{gst_no}','API\ProfileApiController@getGstDetails');
    Route::get('/teamMemberUserDetail/{id?}','API\ProfileApiController@teamMemberUserDetail');

    /**/

    /*Customer route*/
    Route::post('/CustomerAdd','API\CustomerApiController@CustomerAdd');
    Route::post('/CustomerUpdate','API\CustomerApiController@CustomerUpdate');
    // Route::post('/CustomerAddMedia ','API\CustomerApiController@CustomerAddMedia');
    Route::get('/CustomerList','API\CustomerApiController@CustomerList');
    Route::get('/CustomerShow/{id?}','API\CustomerApiController@CustomerShow');
    Route::post('/CustomerEdit/{id?}','API\CustomerApiController@CustomerEdit');
    Route::get('/CustomerDelete/{id?}','API\CustomerApiController@destroy');
    Route::post('/CustomerMuilipleDelete','API\CustomerApiController@CustomerMuilipleDelete');
    Route::get('/CustomerMediadelete/{id?}','API\CustomerApiController@CustomerMediadelete');
    Route::post('/AddCustomerInvoice','API\CustomerApiController@AddCustomerInvoice');
    /**/

    /*Vendor route*/
    Route::post('/VenderAdd','API\VenderApiController@VenderAdd');
    Route::post('/VenderUpdate','API\VenderApiController@VenderUpdate');
    Route::post('/VenderAddMedia ','API\VenderApiController@VenderAddMedia');
    Route::get('/VenderList','API\VenderApiController@VenderList');
    Route::get('/VenderShow/{id?}','API\VenderApiController@VenderShow');
    Route::post('/VenderEdit/{id?}','API\VenderApiController@VenderEdit');
    Route::get('/VenderDelete/{id?}','API\VenderApiController@destroy');
    Route::post('/VenderMuilipleDelete','API\VenderApiController@VenderMuilipleDelete');
    Route::get('/VenderMediadelete/{id?}','API\VenderApiController@VenderMediadelete');
    /**/
    /*Brand Api*/
     Route::get('/BrandList','API\BrandAPIController@BrandList');
     Route::get('/BrandShow/{id?}','API\BrandAPIController@BrandShow');
     Route::post('/BrandAdd','API\BrandAPIController@BrandAdd');
     Route::post('/BrandEdit/{id?}','API\BrandAPIController@BrandEdit');
     Route::get('/BrandDelete/{id?}','API\BrandAPIController@destroy');
     Route::post('/BrandMultipleDelete','API\BrandAPIController@BrandMultipleDelete');
    /**/
    /*Category Api*/
     Route::get('/CategoryList','API\CategoryAPIController@CategoryList');
     Route::get('/CategoryShow/{id?}','API\CategoryAPIController@CategoryShow');
     Route::post('/CategoryAdd','API\CategoryAPIController@CategoryAdd');
     Route::post('/CategoryEdit/{id?}','API\CategoryAPIController@CategoryEdit');
     Route::get('/CategoryDelete/{id?}','API\CategoryAPIController@destroy');
     Route::post('/CategoryMultipleDelete','API\CategoryAPIController@CategoryMultipleDelete');
    /**/
    /*unit Api*/
     Route::get('/UnitList','API\UnitAPIController@UnitList');
     Route::get('/UnitShow/{id?}','API\UnitAPIController@UnitShow');
     Route::post('/UnitAdd','API\UnitAPIController@UnitAdd');
     Route::post('/UnitEdit/{id?}','API\UnitAPIController@UnitEdit');
     Route::get('/UnitDelete/{id?}','API\UnitAPIController@destroy');
     Route::post('/UnitMultipleDelete','API\UnitAPIController@UnitMultipleDelete');
    /**/
    /*Service Api*/
    Route::get('/ServiceList','API\ServiceApiController@ServiceList');
    Route::get('/ServiceShow/{id?}','API\ServiceApiController@ServiceShow');
    Route::post('/ServiceAdd','API\ServiceApiController@ServiceAdd');
    Route::post('/ServiceEdit/{id?}','API\ServiceApiController@ServiceEdit');
    Route::get('/ServiceDelete/{id?}','API\ServiceApiController@destroy');
   /**/
   /*Sale Invoice Api*/
   Route::get('/SaleInvoiceList','API\SaleInvoiceApiController@SaleInvoiceList');
   Route::get('/SaleInvoiceShow/{id?}','API\SaleInvoiceApiController@SaleInvoiceShow');
   Route::post('/SaleInvoiceAdd','API\SaleInvoiceApiController@SaleInvoiceAdd');
   Route::post('/SaleInvoiceEdit/{id?}','API\SaleInvoiceApiController@SaleInvoiceEdit');
   Route::get('/SaleInvoiceDelete/{id?}','API\SaleInvoiceApiController@destroy');
   Route::get('/SaleInvoiceCancel/{id?}','API\SaleInvoiceApiController@invoiceCancel');
   Route::get('/SaleInvoiceRemovePayment/{id?}','API\SaleInvoiceApiController@invoiceRemovePayment');
   Route::get('/SaleInvoiceGetLastRecord','API\SaleInvoiceApiController@SaleInvoiceGetLastRecord');
   Route::post('/SaleInvoiceCheckNo','API\SaleInvoiceApiController@SaleInvoiceCheckNo');
   Route::post('/SaleInvoiceAddColor','API\SaleInvoiceApiController@SaleInvoiceAddColor');
   Route::post('/SaleInvoiceGetMedia','API\SaleInvoiceApiController@SaleInvoiceGetMedia');
   Route::get('/SaleInvoiceMediadelete/{id?}','API\SaleInvoiceApiController@SaleInvoiceMediadelete');
   Route::post('/SaleInvoiceDuplicate','API\SaleInvoiceApiController@SaleInvoiceDuplicate');
   Route::post('/SaleInvoiceAddTempalate','API\SaleInvoiceApiController@SaleInvoiceAddTempalate');
   Route::post('/SaleInvoiceMuilipleDelete','API\SaleInvoiceApiController@SaleInvoiceMuilipleDelete');
   Route::get('/SaleInvoiceRecover/{id?}','API\SaleInvoiceApiController@SaleInvoiceRecover');
  /**/
  /*Sale Invoice Bank Details Api*/
   Route::get('/SaleInvoiceBankDetailsList','API\SaleInvoiceBankDetailsApiController@SaleInvoiceBankDetailsList');
   Route::get('/SaleInvoiceBankDetailsShow/{id?}','API\SaleInvoiceBankDetailsApiController@SaleInvoiceBankDetailsShow');
   Route::post('/SaleInvoiceBankDetailsAdd','API\SaleInvoiceBankDetailsApiController@SaleInvoiceBankDetailsAdd');
   Route::post('/SaleInvoiceBankDetailsEdit/{id?}','API\SaleInvoiceBankDetailsApiController@SaleInvoiceBankDetailsEdit');
   Route::get('/SaleInvoiceBankDetailsDelete/{id?}','API\SaleInvoiceBankDetailsApiController@destroy');
   Route::post('/SaleInvoiceBankDetailsActive/{id?}','API\SaleInvoiceBankDetailsApiController@SaleInvoiceBankDetailsActive');
   /*Sale Invoice Bank Upi Api*/
   Route::get('/SaleInvoiceBankUpiList','API\SaleInvoiceBankUpiApiController@SaleInvoiceBankUpiList');
   Route::get('/SaleInvoiceBankUpiShow/{id?}','API\SaleInvoiceBankUpiApiController@SaleInvoiceBankUpiShow');
   Route::post('/SaleInvoiceBankUpiAdd','API\SaleInvoiceBankUpiApiController@SaleInvoiceBankUpiAdd');
   Route::post('/SaleInvoiceBankUpiEdit/{id?}','API\SaleInvoiceBankUpiApiController@SaleInvoiceBankUpiEdit');
   Route::get('/SaleInvoiceBankUpiDelete/{id?}','API\SaleInvoiceBankUpiApiController@destroy');
   Route::post('/SaleInvoiceBankUpiActive/{id?}','API\SaleInvoiceBankUpiApiController@SaleInvoiceBankUpiActive');
   /**/
   Route::get('/SaleInvoiceAddSettingShow/{id?}','API\SaleInvoiceAddSettingApiController@SaleInvoiceAddSettingShow');
   Route::post('/SaleInvoiceAddSetting','API\SaleInvoiceAddSettingApiController@SaleInvoiceAddSetting');
   Route::get('/SaleInvoiceResetSetting','API\SaleInvoiceAddSettingApiController@SaleInvoiceResetSetting');
   Route::post('/SaleInvoiceSetDueDate','API\SaleInvoiceAddSettingApiController@SaleInvoiceSetDueDate');
   Route::post('/SaleInvoiceBankAndUpiStatus','API\SaleInvoiceAddSettingApiController@SaleInvoiceBankAndUpiStatus');
  /**/
  /*Busines Api*/
  Route::get('/BusinesList','API\BusinessApiController@BusinesList');
  Route::get('/BusinesShow/{id?}','API\BusinessApiController@BusinesShow');
  Route::post('/BusinesAdd','API\BusinessApiController@BusinesAdd');
  Route::post('/BusinesEdit/{id?}','API\BusinessApiController@BusinesEdit');
  Route::get('/BusinesDelete/{id?}','API\BusinessApiController@destroy');
 /**/
 /*SaleInvoiceAddPayment Api*/
  Route::get('/SaleInvoiceAddPaymentList/{id?}','API\SaleInvoiceAddPaymentApiController@SaleInvoiceAddPaymentList');
  Route::get('/SaleInvoiceAddPaymentShow/{id?}','API\SaleInvoiceAddPaymentApiController@SaleInvoiceAddPaymentShow');
  Route::post('/SaleInvoiceAddPaymentAdd','API\SaleInvoiceAddPaymentApiController@SaleInvoiceAddPaymentAdd');
  Route::post('/SaleInvoiceAddPaymentEdit/{id?}','API\SaleInvoiceAddPaymentApiController@SaleInvoiceAddPaymentEdit');
  Route::get('/SaleInvoiceAddPaymentDelete/{id?}','API\SaleInvoiceAddPaymentApiController@destroy');
  Route::get('/SaleInvoiceGetPayment/{invoice_id?}','API\SaleInvoiceAddPaymentApiController@SaleInvoiceGetPayment');
 /**/
 /*sale_invoice_provide_e_invoice_details Api*/
  Route::get('/SaleInvoiceProvideEInvoiceDetailsList/{id?}','API\SaleInvoiceProvideEInvoiceDetailsApiController@SaleInvoiceProvideEInvoiceDetailsList');
  Route::get('/SaleInvoiceProvideEInvoiceDetailsShow/{id?}','API\SaleInvoiceProvideEInvoiceDetailsApiController@SaleInvoiceProvideEInvoiceDetailsShow');
  Route::post('/SaleInvoiceProvideEInvoiceDetailsAdd','API\SaleInvoiceProvideEInvoiceDetailsApiController@SaleInvoiceProvideEInvoiceDetailsAdd');
  Route::post('/SaleInvoiceProvideEInvoiceDetailsEdit/{id?}','API\SaleInvoiceProvideEInvoiceDetailsApiController@SaleInvoiceProvideEInvoiceDetailsEdit');
  Route::get('/SaleInvoiceProvideEInvoiceDetailsDelete/{id?}','API\SaleInvoiceProvideEInvoiceDetailsApiController@destroy');
 /**/
 /*SaleInvoiceKycDetails Api*/
  Route::get('/SaleInvoiceKycDetailsList/{id?}','API\SaleInvoiceKycDetailsApiController@SaleInvoiceKycDetailsList');
  Route::get('/SaleInvoiceKycDetailsShow/{id?}','API\SaleInvoiceKycDetailsApiController@SaleInvoiceKycDetailsShow');
  Route::post('/SaleInvoiceKycDetailsAdd','API\SaleInvoiceKycDetailsApiController@SaleInvoiceKycDetailsAdd');
  Route::post('/SaleInvoiceKycDetailsEdit/{id?}','API\SaleInvoiceKycDetailsApiController@SaleInvoiceKycDetailsEdit');
  Route::get('/SaleInvoiceKycDetailsDelete/{id?}','API\SaleInvoiceKycDetailsApiController@destroy');
 /**/ 
 /*SaleInvoiceChargeLateFee Api*/
  Route::get('/SaleInvoiceChargeLateFeeList/{id?}','API\SaleInvoiceChargeLateFeeApiController@SaleInvoiceChargeLateFeeList');
  Route::get('/SaleInvoiceChargeLateFeeShow/{id?}','API\SaleInvoiceChargeLateFeeApiController@SaleInvoiceChargeLateFeeShow');
  Route::post('/SaleInvoiceChargeLateFeeAdd','API\SaleInvoiceChargeLateFeeApiController@SaleInvoiceChargeLateFeeAdd');
  Route::post('/SaleInvoiceChargeLateFeeEdit/{id?}','API\SaleInvoiceChargeLateFeeApiController@SaleInvoiceChargeLateFeeEdit');
  Route::get('/SaleInvoiceChargeLateFeeDelete/{id?}','API\SaleInvoiceKycDetailsApiController@destroy');
 /**/

 /*SaleBusinessDetails Api*/
  Route::get('/SaleBusinessDetailsList/{id?}','API\SaleBusinessDetailsApiController@SaleBusinessDetailsList');
  Route::get('/SaleBusinessDetailsShow/{id?}','API\SaleBusinessDetailsApiController@SaleBusinessDetailsShow');
  Route::post('/SaleBusinessDetailsAdd','API\SaleBusinessDetailsApiController@SaleBusinessDetailsAdd');
  Route::post('/SaleBusinessDetailsEdit/{id?}','API\SaleBusinessDetailsApiController@SaleBusinessDetailsEdit');
  Route::get('/SaleBusinessDetailsDelete/{id?}','API\SaleBusinessDetailsApiController@destroy');
 /**/
 /*SaleClientDetails Api*/
  Route::get('/SaleClientDetailsList/{id?}','API\SaleClientDetailsApiController@SaleClientDetailsList');
  Route::get('/SaleClientDetailsShow/{id?}','API\SaleClientDetailsApiController@SaleClientDetailsShow');
  Route::post('/SaleClientDetailsAdd','API\SaleClientDetailsApiController@SaleClientDetailsAdd');
  Route::post('/SaleClientDetailsEdit/{id?}','API\SaleClientDetailsApiController@SaleClientDetailsEdit');
  Route::get('/SaleClientDetailsDelete/{id?}','API\SaleClientDetailsApiController@destroy');
 /**/

 /*SaleInvoiceAddLetterhead Api*/
  Route::get('/SaleInvoiceAddLetterheadShow/{id?}','API\SaleInvoiceAddLetterheadApiController@SaleInvoiceAddLetterheadShow');
  Route::post('/SaleInvoiceAddLetterheadAdd','API\SaleInvoiceAddLetterheadApiController@SaleInvoiceAddLetterheadAdd');
  
  /**/
  Route::get('/SaleInvoiceAddFooterShow/{id?}','API\SaleInvoiceAddFooterApiController@SaleInvoiceAddFooterShow');
  Route::post('/SaleInvoiceAddFooter','API\SaleInvoiceAddFooterApiController@SaleInvoiceAddFooter');
 /**/
/*sale_invoice_qr_code Api*/
  Route::get('/SaleInvoiceQrCodeList/{id?}','API\SaleInvoiceQrCodeApiController@SaleInvoiceQrCodeList');
  Route::get('/SaleInvoiceQrCodeShow/{id?}','API\SaleInvoiceQrCodeApiController@SaleInvoiceQrCodeShow');
  Route::post('/SaleInvoiceQrCodeAdd','API\SaleInvoiceQrCodeApiController@SaleInvoiceQrCodeAdd');
  Route::post('/SaleInvoiceQrCodeEdit/{id?}','API\SaleInvoiceQrCodeApiController@SaleInvoiceQrCodeEdit');
  Route::get('/SaleInvoiceQrCodeDelete/{id?}','API\SaleInvoiceQrCodeApiController@destroy');
 /**/
 /*sale_invoice_share Api*/
  Route::get('/SaleInvoiceShareList/{id?}','API\SaleInvoiceShareApiController@SaleInvoiceShareList');
  Route::get('/SaleInvoiceShareShow/{id?}','API\SaleInvoiceShareApiController@SaleInvoiceShareShow');
  Route::post('/SaleInvoiceShareAdd','API\SaleInvoiceShareApiController@SaleInvoiceShareAdd');
  Route::post('/SaleInvoiceShareEdit/{id?}','API\SaleInvoiceShareApiController@SaleInvoiceShareEdit');
  Route::get('/SaleInvoiceShareDelete/{id?}','API\SaleInvoiceShareApiController@destroy');
 /**/

    /*Product Api*/
    /*add mobile data*/
    Route::post('/MobileProductAdd','API\ProductAPIController@MobileProductAdd');
    Route::post('/MobileProductEdit','API\ProductAPIController@MobileProductEdit');
    Route::post('/MobileStockUpdate','API\ProductAPIController@MobileStockUpdate');
    /**/
     Route::get('/ProductList','API\ProductAPIController@ProductList');
     Route::get('/CatAssignProductList','API\ProductAPIController@CatAssignProductList');
     Route::get('/ProductShow/{id?}','API\ProductAPIController@ProductShow');
     Route::post('/ProductAdd','API\ProductAPIController@ProductAdd');
     Route::post('/ProductEdit/{id?}','API\ProductAPIController@ProductEdit');
     Route::get('/ProductDelete/{id?}','API\ProductAPIController@destroy');
     Route::post('/ProductMultipleDelete','API\ProductAPIController@ProductMultipleDelete');
     Route::get('/ProductMediadelete/{id?}','API\ProductAPIController@ProductMediadelete');
     Route::get('/ProductSingleMediadelete/{id?}','API\ProductAPIController@ProductSingleMediadelete');
     Route::post('/ProductManageStockUpdate','API\ProductAPIController@ProductManageStockUpdate');
     Route::post('/ProductlowStockUpdate','API\ProductAPIController@ProductlowStockUpdate');
     Route::post('/CategoryAssignItem','API\ProductAPIController@CategoryAssignItem');
     Route::post('/CategoryRemoveItem','API\ProductAPIController@CategoryRemoveItem');
     Route::post('/AddNewItem','API\ProductAPIController@AddNewItem');

     /*Item group add*/
     Route::post('/AddGroupProduct','API\ProductAPIController@AddGroupProduct');
     Route::post('/EditGroupProduct/{id?}','API\ProductAPIController@EditGroupProduct');
     Route::get('/GroupProductShow/{id?}','API\ProductAPIController@GroupProductShow');
     /*Product Variation*/
     Route::post('/ProductVariationAdd','API\ProductAPIController@ProductVariationAdd');
     Route::get('/VariationProductShow/{id?}','API\ProductAPIController@VariationProductShow');
     Route::get('/VariationProductList','API\ProductAPIController@VariationProductList');
     Route::post('/VariationProductEdit','API\ProductAPIController@VariationProductEdit');
     Route::get('/VariationProductdelete/{id?}','API\ProductAPIController@VariationProductdelete');
     Route::post('/VariationProductAddAssign','API\ProductAPIController@VariationProductAddAssign');
    /**/

    /*adjustment*/
     Route::post('/AdjustmentAdd','API\AdjustmentAPIController@AdjustmentAdd');
     Route::post('/AdjustmentUpdate','API\AdjustmentAPIController@AdjustmentUpdate');
     Route::get('/AdjustmentProductWiseShow/{id?}','API\AdjustmentAPIController@AdjustmentProductWiseShow');
     Route::get('/AdjustmentVariationWiseShow/{id?}','API\AdjustmentAPIController@AdjustmentVariationWiseShow');
     Route::get('/StockHistory','API\AdjustmentAPIController@StockHistory');
    /**/

    
    Route::get('get-projects', 'ApiController@getProjects');
    Route::post('add-tracker', 'ApiController@addTracker');
    Route::post('stop-tracker', 'ApiController@stopTracker');
    Route::post('upload-photos', 'ApiController@uploadImage');

    Route::post('/CustomerImport','API\CustomerApiController@CustomerImport');
    Route::post('/VenderImport','API\VenderApiController@VenderImport');
    Route::post('/BrandImport','API\BrandApiController@BrandImport');
    Route::post('/CategoryImport','API\CategoryAPIController@CategoryImport');
    Route::post('/ProductImport','API\ProductAPIController@ProductImport');
});
    Route::get('/SaleInvoiceExport/{id?}','API\SaleInvoiceApiController@SaleInvoiceExport');
    Route::post('/SaleInvoiceExport/Export/{id?}','API\SaleInvoiceApiController@SaleInvoiceExport');

    Route::post('/sendInviteExport/{id?}','API\InviteApiController@sendInviteExport');
    Route::get('/CustomerExport/{id?}','API\CustomerApiController@CustomerExport');
    Route::post('/SelectedCustomer/Export/{id?}','API\CustomerApiController@CustomerExport');
    Route::get('/CustomerPdf/{id?}','API\CustomerApiController@CustomerPdf')->name('Customer.pdf');
    Route::post('/SelectedCustomer/Pdf/{id?}','API\CustomerApiController@CustomerPdf')->name('Customer.pdf');
    Route::get('/CustomerExportToXml','API\CustomerApiController@CustomerExportToXml');

    Route::get('/SaleInvoice/Pdf/{id?}/{template_id?}/{auth_id?}','API\SaleInvoiceApiController@InvoicePdf');
    Route::post('/SaleInvoiceCheck/Pdf/{id?}','API\SaleInvoiceApiController@SaleInvoiceCheck');

    Route::get('/VenderExport/{id?}','API\VenderApiController@VenderExport');
    Route::post('/SelectedVender/Export/{id?}','API\VenderApiController@VenderExport');
    Route::get('/VenderPdf/{id?}','API\VenderApiController@VenderPdf')->name('Vender.pdf');
    Route::post('/SelectedVender/Pdf/{id?}','API\VenderApiController@VenderPdf')->name('Vender.pdf');
    Route::get('/VenderExportToXml','API\VenderApiController@VenderExportToXml');

    Route::get('/ProductExport/{id?}','API\ProductAPIController@ProductExport');
    Route::post('/SelectedProduct/Export/{id?}','API\ProductAPIController@ProductExport');
    Route::get('/ProductPdf/{id?}','API\ProductAPIController@ProductPdf')->name('Product.pdf');
    Route::post('/SelectedProduct/Pdf/{id?}','API\ProductAPIController@ProductPdf')->name('Product.pdf');
    Route::get('/ProductExportToXml','API\ProductAPIController@ProductExportToXml');

    Route::get('/BrandExport/{id?}','API\BrandAPIController@BrandExport');
    Route::post('/SelectedBrand/Export/{id?}','API\BrandAPIController@BrandExport');
    Route::get('/BrandPdf/{id?}','API\BrandAPIController@BrandPdf')->name('Brand.pdf');
    Route::post('/SelectedBrand/Pdf/{id?}','API\BrandAPIController@BrandPdf')->name('Brand.pdf');
    Route::get('/BrandExportToXml','API\BrandAPIController@BrandExportToXml');

    Route::get('/CategoryExport/{id?}','API\CategoryAPIController@CategoryExport');
    Route::post('/SelectedCategory/Export/{id?}','API\CategoryAPIController@CategoryExport');
    Route::get('/CategoryPdf/{id?}','API\CategoryAPIController@CategoryPdf')->name('Category.pdf');
    Route::post('/SelectedCategory/Pdf/{id?}','API\CategoryAPIController@CategoryPdf')->name('Category.pdf');
    Route::get('/CategoryExportToXml','API\CategoryAPIController@CategoryExportToXml');
    
