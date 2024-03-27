<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vender;
use App\Models\LogActivity;
use App\Models\Module;
use App\Models\State;
use App\Models\Country;
use App\Models\User;
use App\Models\ProductService;
use App\Models\ProductBrand;
use App\Models\Send_invite;
use App\Models\ProductServiceCategory;
use App\Models\ProductVariation;
use App\Models\ProductServiceUnit;
use App\Models\SaleInvoiceLabelChange;
use App\Models\Business;
use App\Models\SaleInvoice;
use App\Models\SaleInvoiceBankUpi;
use App\Models\SaleInvoiceBankDetails;
use App\Models\SaleInvoiceAddPayment;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Decrypt;
use Illuminate\Support\Facades\Storage;
use App\Helpers\CommonHelper;
use Mockery\Undefined;

class FrontEndViewsController extends Controller
{
    public function dashboard(Request $request)
    {
        $enypt_id = $request->uid;
        if (!empty($enypt_id) && $enypt_id != "undefined") {
            $uid = Decrypt($enypt_id);
            $auth_user = User::find($uid);
            $permissions = $this->get_permissions($auth_user, $uid);
            $modules = Module::get();
            $countryList = Country::get();
            $stateList = State::where('country_id', '101')->get();
            $commonData = $this->getCommonData($auth_user);

            return view('allFrontendViews.dashboard', compact('permissions', 'auth_user', 'enypt_id', 'commonData', 'modules', 'countryList', 'stateList'));
        } else {
            return redirect('home');
        }
    }


    public function getCommonData($auth_user)
    {
        $dataArray = [];
        $getBusiness =  Business::leftjoin('business_assign', 'business.id', 'business_assign.business_id');
        $getBusiness->leftjoin('countries', 'countries.id', 'business.country_id');
        $getBusiness->leftjoin('states', 'states.id', 'business.state_id');
        if (empty($auth_user->parent_id)) {
            $getBusiness->where('business.created_by', $auth_user->id);
            $getBusiness->where('business.team_id', $auth_user->id);
        } else {
            $getBusiness->orwhere('business_assign.team_id', $auth_user->id);
            $getBusiness->orwhere('business.created_by', $auth_user->id);
        }
        $getBusiness->groupby('business.id');
        $getBusiness->select('business.*', 'countries.name as country_name', 'states.name as state_name');
        $dataArray['business'] = $getBusiness->get();
        // $dataArray['business'] = $getBusiness->get();
        foreach ($dataArray['business'] as $key => $getBusiness) {
            if (!is_null($getBusiness->business_logo)) {
                $profile_image = CommonHelper::getS3FileUrl($getBusiness->business_logo);
                if ($profile_image->status == "success") {
                    $getBusiness->business_logo = $profile_image->fileUrl;
                }
            }
        }
        $dataArray['active_business_data'] =  Business::where('business.id', $auth_user->active_business_id)
            ->leftjoin('states', 'business.state_id', 'states.id')
            ->leftjoin('countries', 'business.country_id', 'countries.id')
            ->select('business.*', 'countries.name as country', 'states.name as state', 'states.gst_code')
            ->first();
        if (!is_null($dataArray['active_business_data']['business_logo'])) {
            $profile_image = CommonHelper::getS3FileUrl($dataArray['active_business_data']['business_logo']);
            if ($profile_image->status == "success") {
                $dataArray['active_business_data']['business_logo'] = $profile_image->fileUrl;
            }
        }

        $dataArray['countryList'] = Country::get();
        $dataArray['stateList'] = State::where('country_id', '101')->get();
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $dataArray['customers'] = Customer::where("customers.team_id", $team_id)
            ->where('customers.business_id', $auth_user->active_business_id)
            ->get();
        $dataArray['allProducts'] = $this->getAllProducts($auth_user);
        return $dataArray;
    }


    public function customerView(Request $request)
    {
        $enypt_id = $request->uid;
        if (!empty($enypt_id)) {
            $auth_user = User::find(Decrypt($enypt_id));
            $team_id =  $auth_user->parent_id;
            $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
            $has_edit_permission = $this->module_hasPermission($permissions, 'Client_Vendors');
            if ($auth_user->parent_id == 0) {
                $team_id = $auth_user->id;
                $has_edit_permission = true;
            }
            $search = @$request->search;
            $customers = Customer::leftjoin('customer_bank_details', 'customer_bank_details.client_id', 'customers.id');
            $customers->select('customers.*', 'customers.id as customer_id', 'customer_bank_details.*');
            if (!empty($search)) {
                $customers = $customers->where(function ($q) use ($search) {
                    $q->where('customers.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('customers.email', 'LIKE', '%' . $search . '%')
                        ->orwhere('customers.tax_number', 'LIKE', '%' . $search . '%')
                        ->orwhere('customers.nature_of_business', 'LIKE', '%' . $search . '%')
                        ->orwhere('customer_bank_details.payment_terms_days', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->name)) {
                $customers->where("customers.name", 'LIKE', '%' . $request->name . '%');
            }
            if (!empty($request->nature_of_business)) {
                $customers->where("customers.nature_of_business", 'LIKE', '%' .  $request->nature_of_business . '%');
            }
            if (!empty($request->payment_terms_days)) {
                $customers->where("customer_bank_details.payment_terms_days", 'LIKE', '%' .  $request->payment_terms_days . '%');
            }

            if (!empty($request->is_have_gst)) {
                if ($request->is_have_gst == 'no') {
                    $customers->where("customers.tax_number", "=", '');
                    $customers->orwhere("customers.tax_number", "=", null);
                } else
                    $customers->where("customers.tax_number", "!=", '');
            }
            if (!empty($request->is_have_top_gst)) {
                if ($request->is_have_top_gst == 'no') {
                    $customers->where("customers.tax_number", "=", '');
                    $customers->orwhere("customers.tax_number", "=", null);
                } else
                    $customers->where("customers.tax_number", "!=", '');
            }
            $customers->where("customers.team_id", $team_id);
            $customers->where('business_id', $auth_user->active_business_id);
            $customers->orderBY("customers.id", "DESC");
            $customers = $customers->paginate(7);

            $modules = Module::get();
            $countryList = Country::get();
            $stateList = State::where('country_id', '101')->get();
            $totalCust = Customer::where("customers.team_id", $team_id)->where('business_id', $auth_user->active_business_id)->count();
            $totalGstCust = Customer::where("customers.tax_number", "!=", '')->where('business_id', $auth_user->active_business_id)->where("customers.team_id", $team_id)->count();
            $totalNonGstCust = Customer::where("customers.team_id", $team_id)->where('business_id', $auth_user->active_business_id)->where("customers.tax_number", "=", '')->count();
            $commonData = $this->getCommonData($auth_user);
            #   echo '<pre/>'; print_r($has_edit_permission);exit;
            $content =  view('allFrontendViews.customers._ajax.listing', compact('customers', 'has_edit_permission'))->render();
            $response['content'] = $content;
            $response['total_record'] = 0;
            if (!empty($request->name) || !empty($request->email) || !empty($request->nature_of_business) || !empty($request->payment_terms_days) || !empty($request->is_have_gst)) {
                $response['total_record'] = @$customers->total();
            }
            if ($request->ajax()) {
                echo json_encode($response);
                die(1);
            }

            return view('allFrontendViews.customers.index', compact('response', 'permissions', 'auth_user', 'enypt_id', 'commonData', 'customers', 'modules', 'stateList', 'countryList', 'totalCust', 'totalGstCust', 'totalNonGstCust', 'has_edit_permission'));
        } else {
            return redirect('home');
        }
    }

    public function VendorView(Request $request)
    {
        $enypt_id = $request->uid;
        if (!empty($enypt_id)) {
            $auth_user = User::find(Decrypt($enypt_id));
            $team_id =  $auth_user->parent_id;

            $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
            $has_edit_permission = $this->module_hasPermission($permissions, 'Client_Vendors');
            if ($auth_user->parent_id == 0) {
                $team_id = $auth_user->id;
                $has_edit_permission = true;
            }
            $search = @$request->search;
            $venders = Vender::leftjoin('venders_bank_details', 'venders_bank_details.vendor_id', 'venders.id');
            $venders->select('venders.*', 'venders.id as customer_id', 'venders_bank_details.*');
            if (!empty($search)) {
                $venders = $venders->where(function ($q) use ($search) {
                    $q->where('venders.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('venders.email', 'LIKE', '%' . $search . '%')
                        ->orwhere('venders.tax_number', 'LIKE', '%' . $search . '%')
                        ->orwhere('venders.nature_of_business', 'LIKE', '%' . $search . '%')
                        ->orwhere('venders_bank_details.payment_terms_days', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->name)) {
                $venders->where("venders.name", 'LIKE', '%' . $request->name . '%');
            }
            if (!empty($request->email)) {
                $venders->where("venders.email", 'LIKE', '%' .  $request->email . '%');
            }
            if (!empty($request->nature_of_business)) {
                $venders->where("venders.nature_of_business", 'LIKE', '%' .  $request->nature_of_business . '%');
            }
            if (!empty($request->payment_terms_days)) {
                $venders->where("venders_bank_details.payment_terms_days", 'LIKE', '%' .  $request->payment_terms_days . '%');
            }
            if (!empty($request->is_have_gst)) {
                if ($request->is_have_gst == 'no') {
                    $venders->where("venders.tax_number", "=", '');
                    $venders->orwhere("venders.tax_number", "=", null);
                } else
                    $venders->where("venders.tax_number", "!=", '');
            }
            if (!empty($request->is_have_top_gst)) {
                if ($request->is_have_top_gst == 'no') {
                    $venders->where("venders.tax_number", "=", '');
                    $venders->orwhere("venders.tax_number", "=", null);
                } else
                    $venders->where("venders.tax_number", "!=", '');
            }
            $venders->where("venders.team_id", $team_id);
            $venders->where('business_id', $auth_user->active_business_id);
            $venders->orderBY("venders.id", "DESC");
            $venders = $venders->paginate(7);

            $modules = Module::get();
            $countryList = Country::get();
            $stateList = State::where('country_id', '101')->get();
            $totalCust = Vender::where("venders.team_id", $team_id)->where('business_id', $auth_user->active_business_id)->count();
            $totalGstCust = Vender::where("venders.tax_number", "!=", '')->where("venders.team_id", $team_id)->where('business_id', $auth_user->active_business_id)->count();
            $totalNonGstCust = Vender::where("venders.team_id", $team_id)->where("venders.tax_number", "=", '')->where('business_id', $auth_user->active_business_id)->count();
            // $has_edit_permission = $this->module_hasPermission($permissions, 'Client_Vendors');
            $commonData = $this->getCommonData($auth_user);


            $content =  view('allFrontendViews.vendors._ajax.listing', compact('venders', 'has_edit_permission'))->render();
            $response['content'] = $content;
            $response['total_record'] = 0;
            if (!empty($request->name) || !empty($request->email) || !empty($request->nature_of_business) || !empty($request->payment_terms_days) || !empty($request->is_have_gst)) {
                $response['total_record'] = @$venders->total();
            }
            if ($request->ajax()) {
                echo json_encode($response);
                die(1);
            }
            return view('allFrontendViews.vendors.index', compact('response', 'permissions', 'has_edit_permission', 'commonData', 'auth_user', 'enypt_id', 'venders', 'modules', 'stateList', 'countryList', 'totalCust', 'totalGstCust', 'totalNonGstCust'));
        } else {
            return redirect('home');
        }
    }

    public function get_permissions($auth_user, $uid)
    {
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $Permission = \App\Models\Module_has_permissions::where('module_has_permissions.user_id', $uid);
        $Permission->leftjoin('module', 'module_has_permissions.module_id', 'module.id');
        $Permission->select('module_has_permissions.permission_id', 'module.id as moduleID', 'module.slug as moduleSlug');
        $Permission = $Permission->get();
        $tempArray = [];
        foreach ($Permission as $key => $data) {
            $tempArray[$data->moduleSlug] = $data->permission_id;
        }

        return  $tempArray;
    }
    public function module_hasPermission($permissions, $ukey)
    {
        $module_has_permission = "";
        if (!empty($permissions) && array_key_exists($ukey, $permissions)) {
            foreach ($permissions as $key => $permission) {
                if ($key == $ukey && $permission == 1) {
                    $module_has_permission = true;
                }
            }
        }
        #  echo '<pre/>';print_r($module_has_permission);exit;
        return $module_has_permission;
    }

    public function InventoryView(Request $request)
    {
        $enypt_id = $request->uid;
        if (!empty($enypt_id)) {
            $auth_user = User::find(Decrypt($enypt_id));
            $team_id =  $auth_user->parent_id;

            $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
            $modules = Module::get();
            $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
            if ($auth_user->parent_id == 0) {
                $team_id = $auth_user->id;
                $has_edit_permission = true;
            }
            $search = @$request->search;
            $inventory_topbar_filter = 0;

            $newproducts = ProductService::where('product_services.team_id', $team_id);
            $newproducts->where('product_services.business_id', $auth_user->active_business_id);
            $newproducts->leftjoin('adjustment_items', 'adjustment_items.product_id', 'product_services.id');
            $newproducts->leftjoin('product_variation', 'adjustment_items.variation_id', 'product_variation.id');

            if (!empty($search)) {
                $newproducts = $newproducts->where(function ($q) use ($search) {
                    $q->where('product_services.name', 'LIKE', '%' . $search . '%')
                        ->orwhere('product_variation.sku', 'LIKE', '%' . $search . '%')
                        ->orwhere('product_variation.hsn', 'LIKE', '%' . $search . '%');
                });
            }
            if (!empty($request->item_name)) {
                $newproducts->where("product_services.name", 'LIKE', '%' . $request->item_name . '%');
            }
            if (!empty($request->tax_rate)) {
                $newproducts->where("product_variation.tax_rate", 'LIKE', '%' . $request->tax_rate . '%');
            }
            if (!empty($request->purchase_price_from) || !empty($request->purchase_price_to)) {
                $newproducts->whereBetween("product_variation.purchase_price", [$request->purchase_price_from, $request->purchase_price_to]);
            }
            if (!empty($request->selling_price_from) || !empty($request->selling_price_to)) {

                $newproducts->whereBetween("product_variation.sale_price", [$request->selling_price_from, $request->selling_price_to]);
            }
            if (!empty($request->inventory_topbar_filter)) {
                if ($request->inventory_topbar_filter == 1) {
                    // $newproducts->where("adjustment_items.quantity", '<=', 'adjustment_items.stock_alert');
                    // $newproducts->groupby('adjustment_items.id');
                    $inventory_topbar_filter = 1;
                } else if ($request->inventory_topbar_filter == 2) {
                    // $newproducts->where("adjustment_items.quantity", '=', '0');
                    $inventory_topbar_filter = 2;
                }
            }

            $newproducts->select('product_services.id', 'product_services.name', 'product_services.is_manage_stock', 'product_services.is_group', 'product_services.group_stock');
            $newproducts->groupby('product_services.id');
            $newproducts->orderby('product_services.id', "DESC");
            $newproducts = $newproducts->paginate(7);

            $commonData = $this->getCommonData($auth_user);

            $content =  view('allFrontendViews.product_inventory._ajax.listing', compact('newproducts', 'has_edit_permission', 'inventory_topbar_filter'))->render();
            $response['content'] = $content;
            $response['total_record'] = 0;
            if (!empty($request->item_name) || !empty($request->tax_rate) || !empty($request->purchase_price_from) || !empty($request->purchase_price_to) || !empty($request->selling_price_from) || !empty($request->selling_price_to)) {
                $response['total_record'] = @$newproducts->total();
            }

            if ($request->ajax()) {
                echo json_encode($response);
                die(1);
            }

            $brands = ProductBrand::where("product_brands.team_id", $team_id)->where('product_brands.business_id', $auth_user->active_business_id)->orderBy('product_brands.id', 'DESC')->get();
            $categories = ProductServiceCategory::with('subcategories')->where('parent_id', '0')->where("product_service_categories.team_id", $team_id)->where('product_service_categories.business_id', $auth_user->active_business_id)->orderBy('product_service_categories.id', 'DESC')->get();
            $latest_categories = ProductServiceCategory::with('subcategories')->where('parent_id', '0')->where("product_service_categories.team_id", $team_id)->where('product_service_categories.business_id', $auth_user->active_business_id)->orderBy('product_service_categories.id', 'DESC')->take(10)->get();
            $productVariations = ProductVariation::where("product_variation.team_id", $team_id)->where('product_variation.business_id', $auth_user->active_business_id)->get();
            $productUnits = ProductServiceUnit::get();

            $vendors = Vender::where("venders.team_id", $team_id)->where('venders.business_id', $auth_user->active_business_id)->get();
            $customers = Customer::where("customers.team_id", $team_id)->where('customers.business_id', $auth_user->active_business_id)->get();
            $vendorArray = [];
            foreach ($vendors as $ky => $vendor) {
                $vendorArray[$ky]['user_type'] = 'vendor';
                $vendorArray[$ky]['id'] = $vendor->id;
                $vendorArray[$ky]['name'] = $vendor->name;
            }
            $customerArray = [];
            foreach ($customers as $key => $customer) {
                $customerArray[$key]['user_type'] = 'customer';
                $customerArray[$key]['id'] = $customer->id;
                $customerArray[$key]['name'] = $customer->name;
            }

            $vend_cutomers = array_merge($vendorArray, $customerArray);
            $allProducts = $this->getAllProducts($auth_user);
            $allGroupProducts = $this->getAllGroupProducts($auth_user);

            return view('allFrontendViews.product_inventory.index', compact('response', 'permissions', 'has_edit_permission', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules', 'brands', 'categories', 'latest_categories', 'productVariations', 'newproducts', 'vend_cutomers', 'productUnits', 'allProducts', 'allGroupProducts', 'inventory_topbar_filter'));
        } else {
            return redirect('home');
        }
    }

    public function getAllProducts($auth_user)
    {
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $products = ProductService::where('product_services.team_id', $team_id);
        $products->leftjoin('adjustment_items', 'adjustment_items.product_id', 'product_services.id');
        $products->leftjoin('product_variation', 'adjustment_items.variation_id', 'product_variation.id');
        $products->select('product_services.id as pro_id', 'product_services.name as prod_name', 'product_services.is_manage_stock', 'adjustment_items.id as adjusmt_id',  'product_variation.id as varit_id', 'product_variation.variation_name', 'adjustment_items.quantity', 'product_services.group_stock');
        $products->groupby('product_variation.id');
        //$products->where('product_services.is_group', '!=', "1");
        $products->where('product_services.business_id', $auth_user->active_business_id);
        $products = $products->get();

        return $products;
    }

    public function getAllGroupProducts($auth_user)
    {
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $products = ProductService::where('product_services.team_id', $team_id);
        $products->leftjoin('adjustment_items', 'adjustment_items.product_id', 'product_services.id');
        $products->leftjoin('product_variation', 'adjustment_items.variation_id', 'product_variation.id');
        $products->select('product_services.id as pro_id', 'product_services.name as prod_name', 'product_services.is_manage_stock', 'adjustment_items.id as adjusmt_id',  'product_variation.id as varit_id', 'product_variation.variation_name', 'adjustment_items.quantity', 'product_services.group_stock');
        $products->groupby('product_variation.id');
        $products->where('product_services.is_group', '!=', "1");
        $products->where('product_services.business_id', $auth_user->active_business_id);
        $products = $products->get();

        return $products;
    }
    // ProductBrand
    public function BrandListView(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
            $has_edit_permission = true;
        }
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        $Brands = ProductBrand::orderBy('product_brands.id', 'DESC');
        $Brands->where("product_brands.team_id", $team_id);
        $Brands->where('product_brands.business_id', $auth_user->active_business_id);

        if (!empty($search)) {
            $Brands = $Brands->where(function ($q) use ($search) {
                $q->where('product_brands.name', 'LIKE', '%' . $search . '%');
            });
        }
        $Brands = $Brands->paginate(5);
        $content =  view('allFrontendViews.product_inventory.brand.listing', compact('Brands', 'has_edit_permission'))->render();
        $response['content'] = $content;
        if ($request->ajax()) {
            echo json_encode($response);
            die(1);
        }
        return view('allFrontendViews.product_inventory.index', compact('response', 'permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules'));
    }

    public function getSingleBrand(Request $request, $id)
    {
        if (!empty($id)) {
            $Brands = ProductBrand::find($id);
            $response['state'] = true;
            $response['message'] = 'Success';
            $response['data'] = $Brands;
            return json_encode($response);
        } else {
            $response['state'] = false;
            $response['message'] = 'failed';
            $response['data'] = [];
            return json_encode($response);
        }
    }
    // ProductServiceCategory

    public function categoryListView(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;

        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
            $has_edit_permission = true;
        }
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        $categories = ProductServiceCategory::with('subcategories')->where('parent_id', '0');

        $categories->orderBy('product_service_categories.id', 'DESC');
        $categories->where("product_service_categories.team_id", $team_id);
        $categories->where('product_service_categories.business_id', $auth_user->active_business_id);
        if (!empty($search)) {
            $categories = $categories->where(function ($q) use ($search) {
                $q->where('product_service_categories.name', 'LIKE', '%' . $search . '%');
            });
        }
        $categories = $categories->paginate(5);

        $content =  view('allFrontendViews.product_inventory.category.listing', compact('categories', 'commonData', 'has_edit_permission'))->render();
        $response['content'] = $content;
        if ($request->ajax()) {
            echo json_encode($response);
            die(1);
        }
        return view('allFrontendViews.product_inventory.index', compact('response', 'permissions', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules'));
    }

    public function getSingleCategory(Request $request, $id)
    {
        if (!empty($id)) {
            $Brands = ProductServiceCategory::find($id);
            $response['state'] = true;
            $response['message'] = 'Success';
            $response['data'] = $Brands;
            return json_encode($response);
        } else {
            $response['state'] = false;
            $response['message'] = 'failed';
            $response['data'] = [];
            return json_encode($response);
        }
    }

    public function teamView(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        $invitees = Send_invite::orderBy('send_invite.id', 'DESC');

        if (!empty($search)) {
            $invitees = $invitees->where(function ($q) use ($search) {
                $q->where('send_invite.name', 'LIKE', '%' . $search . '%')
                    ->orwhere('send_invite.email', 'LIKE', '%' . $search . '%');
            });
        }
        if (!empty($request->status)) {

            $invitees->where("send_invite.invitee_status", $request->status);
        }
        $invitees->where("send_invite.created_by", $auth_user->id);
        $invitees->where('send_invite.business_id', $auth_user->active_business_id);
        $invitees = $invitees->paginate(5);

        $content =  view('allFrontendViews.manage_team.listing', compact('invitees', 'has_edit_permission'))->render();
        $response['content'] = $content;
        if ($request->ajax()) {
            echo json_encode($response);
            die(1);
        }
        return view('allFrontendViews.manage_team.index', compact('response', 'permissions', 'has_edit_permission', 'commonData', 'invitees', 'auth_user', 'enypt_id', 'modules'));
    }


    public function settingView(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;

        return view('allFrontendViews.layouts.business_setting', compact('permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules'));
    }

    public function showInvoice(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'accounting');
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
            $has_edit_permission = true;
        }
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $is_deleted = !empty($request->is_deleted) ? 1 : 0;

        $search = @$request->search;
        $sale_invoice_list = SaleInvoice::leftjoin('sale_invoice_advance_setting', 'sale_invoice.id', 'sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields', 'sale_invoice.id', 'sale_invoice_fields.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_label_change', 'sale_invoice.id', 'sale_invoice_label_change.invoice_id');
        $sale_invoice_list->leftjoin('currency', 'sale_invoice.currency', 'currency.id');
        $sale_invoice_list->leftjoin('users', 'sale_invoice.created_by', 'users.id');
        $sale_invoice_list->leftjoin('sale_invoice_client_details', 'sale_invoice.id', 'sale_invoice_client_details.invoice_id');
        $sale_invoice_list->leftjoin('customers', 'sale_invoice_client_details.client_id', 'customers.id');
        $sale_invoice_list->select('sale_invoice.*', 'customers.tax_number as gst_no', 'customers.pan as pan_no', 'customers.contact as customer_contact', 'sale_invoice_advance_setting.invoice_id', 'sale_invoice_advance_setting.number_format', 'sale_invoice_advance_setting.invoice_country', 'sale_invoice_advance_setting.decimal_digit_format', 'sale_invoice_advance_setting.hide_place_of_supply', 'sale_invoice_advance_setting.hsn_column_view', 'sale_invoice_advance_setting.show_hsn_summary', 'sale_invoice_advance_setting.add_original_images', 'sale_invoice_advance_setting.show_description_in_full_width', 'sale_invoice_fields.filed_data', 'sale_invoice_label_change.label_invoice_no', 'sale_invoice_label_change.label_invoice_date', 'sale_invoice_label_change.label_invoice_due_date', 'sale_invoice_label_change.label_invoice_billed_by', 'sale_invoice_label_change.label_invoice_billed_to', 'sale_invoice_label_change.label_invoice_shipped_from', 'sale_invoice_label_change.label_invoice_shipped_to', 'sale_invoice_label_change.label_invoice_transport_details', 'sale_invoice_label_change.label_invoice_challan_no', 'sale_invoice_label_change.label_invoice_challan_date', 'sale_invoice_label_change.label_invoice_transport', 'sale_invoice_label_change.label_invoice_extra_information', 'sale_invoice_label_change.label_invoice_terms_and_conditions', 'sale_invoice_label_change.label_invoice_additional_notes', 'sale_invoice_label_change.label_invoice_attachments', 'currency.type', 'currency.unit', 'users.name as CreatedBy');
        $sale_invoice_list->where('sale_invoice.is_delete', "=", $is_deleted);
        $sale_invoice_list->where("sale_invoice.team_id", $team_id);
        $sale_invoice_list->where('sale_invoice.business_id', $auth_user->active_business_id);
        $sale_invoice_list->orderBy('sale_invoice.id', 'DESC');
        if (!empty($search)) {
            $sales = $sale_invoice_list->where(function ($q) use ($search) {
                $q->where('sale_invoice.invoice_no', 'LIKE', '%' . $search . '%')
                    ->orwhere('sale_invoice.company_name', 'LIKE', '%' . $search . '%');
            });
        }
        if (!empty($request->payment_status)) {

            $sale_invoice_list->where("sale_invoice.payment_status", $request->payment_status);
        }
        if (!empty($request->client_id)) {
            $sale_invoice_list->where("sale_invoice.customer_id", $request->client_id);
        }
        if (!empty($request->start_date)) {

            $sale_invoice_list->where("sale_invoice.invoice_date", '>=', date("d-m-Y", strtotime($request->start_date)));
        }
        if (!empty($request->end_date)) {

            $sale_invoice_list->where("sale_invoice.invoice_date", '<=', date("d-m-Y", strtotime($request->end_date)));
        }
        $saleInvoices = $sale_invoice_list->paginate(7);
        // echo  ; exit;
        // echo "<pre>";print_r($saleInvoices); exit;
        $year = (date('m') > 6) ? date('Y') + 1 : date('Y');
        $f_y  = $year - 1;
        $from_year = $f_y . '-04-' . '01';
        $to_year =  $year . '-03-' . '31';
        //echo $from_year; exit;

        $totalInvoice = SaleInvoice::where('created_by', $team_id);
        $totalInvoice->where('business_id', $auth_user->active_business_id);
        $totalInvoice->where('sale_invoice.is_delete', "=", $is_deleted);
        $totalInvoice->whereDate('sale_invoice.created_at', ">=", $from_year);
        $totalInvoice->whereDate('sale_invoice.created_at', "<=", $to_year);
        $totalInvoice = $totalInvoice->count();

        $dueInvoice = SaleInvoice::where('created_by', $team_id);
        $dueInvoice->where('business_id', $auth_user->active_business_id);
        $dueInvoice->where('due_date', '<=', date('d-m-Y'));
        $dueInvoice->whereDate('sale_invoice.created_at', ">=", $from_year);
        $dueInvoice->whereDate('sale_invoice.created_at', "<=", $to_year);
        $dueInvoice->where('sale_invoice.is_delete', "=", $is_deleted);
        $dueInvoice->where('sale_invoice.payment_status', "!=", 'Paid');
        $dueInvoice = $dueInvoice->count();

        $totalAmount = SaleInvoice::where('created_by', $team_id);
        $totalAmount->where('business_id', $auth_user->active_business_id);
        $totalAmount->where('sale_invoice.is_delete', "=", $is_deleted);
        $totalAmount->whereDate('sale_invoice.created_at', ">=", $from_year);
        $totalAmount->whereDate('sale_invoice.created_at', "<=", $to_year);
        $totalAmount = $totalAmount->sum('final_total');

        $totalIgst = SaleInvoice::where('created_by', $team_id);
        $totalIgst->where('business_id', $auth_user->active_business_id);
        $totalIgst->where('sale_invoice.is_delete', "=", $is_deleted);
        $totalIgst->whereDate('sale_invoice.created_at', ">=", $from_year);
        $totalIgst->whereDate('sale_invoice.created_at', "<=", $to_year);
        $totalIgst = $totalIgst->sum('final_igst');

        $totalSgst = SaleInvoice::where('created_by', $team_id);
        $totalSgst->where('business_id', $auth_user->active_business_id);
        $totalSgst->where('sale_invoice.is_delete', "=", $is_deleted);
        $totalSgst->whereDate('sale_invoice.created_at', ">=", $from_year);
        $totalSgst->whereDate('sale_invoice.created_at', "<=", $to_year);
        $totalSgst = $totalSgst->sum('final_sgst');

        $totalCgst = SaleInvoice::where('created_by', $team_id);
        $totalCgst->where('business_id', $auth_user->active_business_id);
        $totalCgst->where('sale_invoice.is_delete', "=", $is_deleted);
        $totalCgst->whereDate('sale_invoice.created_at', ">=", $from_year);
        $totalCgst->whereDate('sale_invoice.created_at', "<=", $to_year);
        $totalCgst = $totalCgst->sum('final_cgst');

        $totalGst = $totalIgst + $totalSgst + $totalCgst;


        $content =  view('allFrontendViews.invoice._ajax.listing', compact('permissions', 'auth_user', 'enypt_id', 'saleInvoices', 'has_edit_permission', 'is_deleted', 'from_year', 'to_year'))->render();
        $response['content'] = $content;
        if ($request->ajax()) {
            echo json_encode($response);
            die(1);
        }

        //echo '<pre/>'; print_r($saleInvoices);exit;
        return view('allFrontendViews.invoice.index', compact('response', 'permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules', 'saleInvoices', 'totalInvoice', 'dueInvoice', 'totalAmount', 'totalGst'));
    }
    public function invoiceStep1View(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $is_inv_duplicate = '';
        $duplicate_status = @$request->inv_status;
        if (!empty($duplicate_status) && $duplicate_status == 'duplicate') {
            $is_inv_duplicate = 1;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);

        $search = @$request->search;
        $totalSaleInvoice = SaleInvoice::count();
        $lastSaleInvoiceNo = SaleInvoice::orderBy('id', 'DESC')
            ->where('created_by', $team_id)
            ->where('business_id', $auth_user->active_business_id)
            ->first();
        /*$inNumberString = @$lastSaleInvoiceNo->invoice_no;
        if (is_numeric($inNumberString)) {
            $new_invoice_no = (int)$inNumberString + 1;
        } else {
            $lastDigit = substr($inNumberString, -1);
            if (is_numeric($lastDigit)) {
                preg_match('/^([\/\\\\#,_A-Za-z :-]+)(\d+)$/', $lastSaleInvoiceNo->invoice_no, $matches);
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                // Increment the numeric part by 1
                $newNumericPart = $numericPart + 1;
                // Pad the numeric part with leading zeroes to maintain the desired format
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                // Combine the letter part and the new numeric part
                $new_invoice_no = $letterPart . $paddedNumericPart;
            } else {
                $new_invoice_no = !empty($inNumberString) ?  $inNumberString . '1' : 'A0001';
            }
        }*/
        $firstString = substr($lastSaleInvoiceNo->invoice_no, 0, -1);
        $lastDigit = substr($lastSaleInvoiceNo->invoice_no, -1);
        if(is_numeric($lastDigit) && is_numeric($firstString))
        {

            preg_match('/^([0A-Za-z]+)(\d+)$/', $lastSaleInvoiceNo->invoice_no, $matches);
            if(!empty($matches))
            {
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $new_invoice_no = $letterPart . $paddedNumericPart;
            }else{
                $inNumberString = @$lastSaleInvoiceNo->invoice_no;
                $new_invoice_no = (int)$inNumberString + 1;
            }

        }
        if(is_numeric($lastDigit) && !is_numeric($firstString))
        {
            //echo "dd"; exit;
            preg_match('/^([\/\\\\#,_|A-Za-z :-]+)(\d+)$/', $lastSaleInvoiceNo->invoice_no, $matches);
            if(!empty($matches))
            {
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $new_invoice_no = $letterPart . $paddedNumericPart;
            }else{
                //echo "dd"; exit;
                preg_match('/([A-Za-z]+)(\d+)/', $lastSaleInvoiceNo->invoice_no, $matches);
                $str = $matches[0];
                preg_match('/([A-Za-z]+)(\d+)\D*$/', $lastSaleInvoiceNo->invoice_no, $matches);
                $letterPart = $matches[1];
                $numericPart = intval($matches[2]);
                $newNumericPart = $numericPart + 1;
                $paddedNumericPart = str_pad($newNumericPart, strlen($matches[2]), '0', STR_PAD_LEFT);
                $new_invoice_no = $str. $matches[1] . $paddedNumericPart;

            }

        }
        if(!is_numeric($lastDigit) && !is_numeric($firstString) && !empty($lastSaleInvoiceNo->invoice_no))
        {
            $numericPart = preg_replace('/[^0-9]/', '', $lastSaleInvoiceNo->invoice_no);
            if(!empty($numericPart))
            { 
                $numericPart = (int)$numericPart;
                // Increment the numeric part
                $numericPart++;
                // Reconstruct the new invoice number
                $new_invoice_no = preg_replace('/[0-9]+/', sprintf('%03d', $numericPart), $lastSaleInvoiceNo->invoice_no);;
            }
            else            
            {
              $new_invoice_no = $lastSaleInvoiceNo->invoice_no.'1' ;
            }
        }
        if(empty($lastSaleInvoiceNo->invoice_no) && $lastSaleInvoiceNo->invoice_no =='') 
        {
            $new_invoice_no = 'A0001';
        }

        //echo $new_invoice_no; exit;
        $currencies = Currency::get();
        $SaleInvoiceLabelChange = SaleInvoiceLabelChange::where('created_by', $auth_user->id)->orderBy('id', 'DESC')->first();

        $invoice_id = @$request->inv_id;
        $row_index_id = @$request->row_index_id;
        $savedInvloiceAllData = [];
        $is_invoice_edit = '';
        if (!empty($invoice_id)) {
            $is_invoice_edit = 1;
        }

        $savedInvloiceAllData = $this->getAllinvoiceData(@$auth_user, @$invoice_id, @$row_index_id);

        $saleInvoice =  @$savedInvloiceAllData['saleInvoice'];
        $saleInvoiceProduct =  @$savedInvloiceAllData['SaleInvoiceProduct'];

        /*echo"<pre>";
        print_r($savedInvloiceAllData['SaleInvoiceSetting']); exit;*/
        return view('allFrontendViews.invoice.create', compact('permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'is_invoice_edit', 'is_inv_duplicate', 'modules', 'totalSaleInvoice', 'lastSaleInvoiceNo', 'SaleInvoiceLabelChange', 'currencies', 'saleInvoice', 'savedInvloiceAllData', 'invoice_id', 'saleInvoiceProduct', 'new_invoice_no'));
    }
    public function invoiceStep2View(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $invoice_id = @$request->inv_id;
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        /* $upi_details = SaleInvoiceBankUpi::where('invoice_id',$invoice_id)->get();
        $bank_details = SaleInvoiceBankDetails::where('invoice_id',$invoice_id)->get();*/
        if (!empty($invoice_id)) {
            $savedInvloiceAllData = $this->getAllinvoiceData(@$auth_user, @$invoice_id, '');
            $is_invoice_edit = 1;
            $upi_details = $savedInvloiceAllData['SaleInvoiceAllBankUpi'];
            $bank_details = $savedInvloiceAllData['SaleInvoiceAllBankDetails'];
        }

        return view('allFrontendViews.invoice.create_step2', compact('permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'modules', 'invoice_id', 'upi_details', 'bank_details'));
    }

    public function invoiceStep3View(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        $invoice_id = @$request->inv_id;
        $row_index_id = @$request->row_index_id;
        $templete_id = 1;

        $copy_id = (!empty($request->copy) && $request->copy == 'VHJpcGxpY2F0ZQ' || $request->copy == 'RHVwbGljYXRl' ? $request->copy : '');
        $copy_type = '';
        if ($copy_id == 'RHVwbGljYXRl') {
            $copy_type = 'Duplicate';
        } else if ($request->copy == 'VHJpcGxpY2F0ZQ') {
            $copy_type = 'Triplicate';
        }


        $amount_recived_sum =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)
            ->sum('amount_received');
        $total_tcs_amount =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('tcs_amount');
        $total_tds_amount =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('tds_amount');
        $total_transaction_charge =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('transaction_charge');
        $amount_recived =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)
            ->orderBy('id', "DESC")
            ->first();

        //getAllinvoiceData in diffrent table
        $getAllData = $this->getAllinvoiceData($auth_user, @$invoice_id, @$row_index_id);
        $saleInvoice = $getAllData['saleInvoice'];
        $SaleInvoiceProduct = $getAllData['SaleInvoiceProduct'];
        $SaleInvoiceProductImage = $getAllData['SaleInvoiceProductImage'];
        $SaleInvoiceService = $getAllData['SaleInvoiceService'];
        $SaleInvoiceGroup = $getAllData['SaleInvoiceGroup'];
        $SaleInvoiceGroup = $getAllData['SaleInvoiceGroupImg'];
        $SaleInvoiceAddFooter = $getAllData['SaleInvoiceAddFooter'];
        $SaleInvoiceAddLetterhead = $getAllData['SaleInvoiceAddLetterhead'];
        $SaleInvoiceBankUpi = $getAllData['SaleInvoiceBankUpi'];
        $SaleInvoiceBusinessDetails = $getAllData['SaleInvoiceBusinessDetails'];
        $SaleInvoiceChargeLateFee = $getAllData['SaleInvoiceChargeLateFee'];
        $SaleInvoiceClientDetails = $getAllData['SaleInvoiceClientDetails'];
        $SaleInvoiceQrCode = $getAllData['SaleInvoiceQrCode'];
        $SaleInvoiceShare = $getAllData['SaleInvoiceShare'];
        $SaleInvoiceBankDetails = $getAllData['SaleInvoiceBankDetails'];
        $advanceSetting = $getAllData['advanceSetting'];
        $hsnInvoiceDetails = $getAllData['hsnInvoiceDetails'];
        $SaleInvoiceAllBankUpi = $getAllData['SaleInvoiceAllBankUpi'];
        $SaleInvoiceAllBankDetails = $getAllData['SaleInvoiceAllBankDetails'];
        $invoice_id = $getAllData['invoice_id'];
        $getDecription = $getAllData['getDecription'];
        $getProductMedia = $getAllData['getProductMedia'];
        $SaleInvoiceAttachments_data = $getAllData['SaleInvoiceAttachments_data'];
        $SaleInvoiceSetting = $getAllData['SaleInvoiceSetting'];
        $SaleInvoiceAddPayment = $getAllData['SaleInvoiceAddPayment'];

        //   echo '<pre/>'; print_r($SaleInvoiceShare); exit;
        return view('allFrontendViews.invoice.create_step3', compact('permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'templete_id', 'modules', 'saleInvoice', 'SaleInvoiceProduct', 'SaleInvoiceProductImage', 'SaleInvoiceService', 'SaleInvoiceGroup', 'SaleInvoiceGroupImg', 'SaleInvoiceAddFooter', 'SaleInvoiceAddLetterhead', 'SaleInvoiceAddPayment', 'SaleInvoiceBankUpi', 'SaleInvoiceBusinessDetails', 'SaleInvoiceChargeLateFee', 'SaleInvoiceClientDetails', 'SaleInvoiceQrCode', 'SaleInvoiceShare', 'SaleInvoiceBankDetails', 'advanceSetting', 'hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id', 'getDecription', 'getProductMedia', 'SaleInvoiceAttachments_data', 'SaleInvoiceSetting', 'amount_recived_sum', 'total_transaction_charge', 'total_tcs_amount', 'total_tds_amount', 'copy_id', 'copy_type'));
    }

    /*getAllinvoiceData*/
    public function getAllinvoiceData($auth_user, $invoice_id = '', $row_index_id = '')
    {
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }

        $sale_invoice_list = SaleInvoice::where('sale_invoice.id', $invoice_id);
        $sale_invoice_list->leftjoin('sale_invoice_advance_setting', 'sale_invoice.id', 'sale_invoice_advance_setting.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_fields', 'sale_invoice.id', 'sale_invoice_fields.invoice_id');
        $sale_invoice_list->leftjoin('sale_invoice_label_change', 'sale_invoice.id', 'sale_invoice_label_change.invoice_id');
        $sale_invoice_list->leftjoin('currency', 'sale_invoice.currency', 'currency.id');
        $sale_invoice_list->leftjoin('users', 'sale_invoice.created_by', 'users.id');
        //$sale_invoice_list->select('sale_invoice.*','sale_invoice_advance_setting.invoice_id','sale_invoice_advance_setting.number_format','sale_invoice_advance_setting.invoice_country','sale_invoice_advance_setting.decimal_digit_format','sale_invoice_advance_setting.hide_place_of_supply','sale_invoice_advance_setting.hsn_column_view','sale_invoice_advance_setting.show_hsn_summary','sale_invoice_advance_setting.add_original_images','sale_invoice_advance_setting.show_description_in_full_width','sale_invoice_fields.filed_data','sale_invoice_label_change.label_invoice_no','sale_invoice_label_change.label_invoice_date','sale_invoice_label_change.label_invoice_due_date','sale_invoice_label_change.label_invoice_billed_by','sale_invoice_label_change.label_invoice_billed_to','sale_invoice_label_change.label_invoice_shipped_from','sale_invoice_label_change.label_invoice_shipped_to','sale_invoice_label_change.label_invoice_transport_details','sale_invoice_label_change.label_invoice_challan_no','sale_invoice_label_change.label_invoice_challan_date','sale_invoice_label_change.label_invoice_transport','sale_invoice_label_change.label_invoice_extra_information','sale_invoice_label_change.label_invoice_terms_and_conditions','sale_invoice_label_change.label_invoice_additional_notes','sale_invoice_label_change.label_invoice_attachments','currency.type','currency.unit','users.name as CreatedBy');
        $sale_invoice_list->select(
            'sale_invoice.*',
            'sale_invoice_advance_setting.invoice_id',
            'sale_invoice_advance_setting.number_format',
            'sale_invoice_advance_setting.invoice_country',
            'sale_invoice_advance_setting.decimal_digit_format',
            'sale_invoice_advance_setting.hide_place_of_supply',
            'sale_invoice_advance_setting.hsn_column_view',
            'sale_invoice_advance_setting.show_hsn_summary',
            'sale_invoice_advance_setting.add_original_images',
            'sale_invoice_advance_setting.show_description_in_full_width',
            'sale_invoice_fields.filed_data',
            'sale_invoice_label_change.label_invoice_no',
            'sale_invoice_label_change.label_invoice_date',
            'sale_invoice_label_change.label_invoice_due_date',
            'sale_invoice_label_change.label_invoice_billed_by',
            'sale_invoice_label_change.label_invoice_billed_to',
            'sale_invoice_label_change.label_invoice_shipped_from',
            'sale_invoice_label_change.label_invoice_shipped_to',
            'sale_invoice_label_change.label_invoice_transport_details',
            'sale_invoice_label_change.label_invoice_challan_no',
            'sale_invoice_label_change.label_invoice_challan_date',
            'sale_invoice_label_change.label_invoice_transport',
            'sale_invoice_label_change.label_invoice_extra_information',
            'sale_invoice_label_change.label_invoice_terms_and_conditions',
            'sale_invoice_label_change.label_invoice_additional_notes',
            'sale_invoice_label_change.label_invoice_attachments',
            'sale_invoice_label_change.additional_info_label',
            'sale_invoice_label_change.label_round_up',
            'sale_invoice_label_change.label_round_down',
            'sale_invoice_label_change.label_total',
            'currency.type',
            'currency.unit',
            'users.name as CreatedBy'
        );
        $sale_invoice_list->orderBy('sale_invoice.id', 'DESC');
        $saleInvoice = $sale_invoice_list->first();

        if (!is_null($saleInvoice['business_logo'])) {
            $profile_image = CommonHelper::getS3FileUrl($saleInvoice['business_logo']);
            if ($profile_image->status == "success") {
                $saleInvoice->business_logo = $profile_image->fileUrl;
            }
        }
        if (!is_null($saleInvoice['invoice_pdf'])) {
            $profile_image = CommonHelper::getS3FileUrl($saleInvoice['invoice_pdf']);
            if ($profile_image->status == "success") {
                $saleInvoice->invoice_pdf = $profile_image->fileUrl;
            }
        }
        $InvoiceProductData = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id', $invoice_id);
        //$InvoiceProduct->leftjoin('product_variation','sale_invoice_product.product_id','product_variation.id');
        // $InvoiceProduct->leftjoin('product_services','sale_invoice_product.product_id','product_services.id');
        $InvoiceProductData->where('sale_invoice_product.invoice_group_id', '0');
        $InvoiceProductData->select('sale_invoice_product.*');
        $InvoiceProductData = $InvoiceProductData->get();
        $count1 = 0;
        foreach ($InvoiceProductData as $key => $value) {
            $InvoiceProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id', $invoice_id);
            $InvoiceProduct->leftjoin('product_variation', 'sale_invoice_product.variation_id', 'product_variation.id');
            $InvoiceProduct->leftjoin('product_services', 'sale_invoice_product.product_id', 'product_services.id');
            $InvoiceProduct->where('sale_invoice_product.invoice_group_id', '0');
            $InvoiceProduct->select('sale_invoice_product.*', 'product_variation.variation_name', 'product_services.name as productName');
            $InvoiceProduct = $InvoiceProduct->get()->toArray();

            $SaleInvoiceProduct = \App\Models\SaleInvoiceProductImage::where('product_id', $value['product_id'])->where('product_id', $value['product_id'])->get()->toArray();

            $SaleInvoiceProductNew = [];
            foreach ($SaleInvoiceProduct  as $key => $ProductImage) {
                if (!is_null($ProductImage['invoice_product_image'])) {
                    $profile_image = CommonHelper::getS3FileUrl($ProductImage['invoice_product_image']);
                    if ($profile_image->status == "success") {
                        $SaleInvoiceProductNew[$key]['id'] = $ProductImage['id'];
                        $SaleInvoiceProductNew[$key]['invoice_id'] = $ProductImage['invoice_id'];
                        $SaleInvoiceProductNew[$key]['product_id'] = $ProductImage['product_id'];
                        $SaleInvoiceProductNew[$key]['invoice_product_image'] = $profile_image->fileUrl;
                    }
                }
            }

            $InvoiceProduct[$count1]['product_img'] = $SaleInvoiceProductNew;
            $count1++;
        }

        $InvoiceGroupProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id', $invoice_id);
        $InvoiceGroupProduct->where('sale_invoice_product.invoice_group_id', '!=', '0');
        $InvoiceGroupProduct->leftjoin('sale_invoice_group', 'sale_invoice_product.invoice_group_id', 'sale_invoice_group.id');
        $InvoiceGroupProduct->select('sale_invoice_product.product_id', 'sale_invoice_product.invoice_group_id', 'sale_invoice_group.group_name');
        $InvoiceGroupProduct = $InvoiceGroupProduct->get();

        $count = 0;
        $grpProduct = [];
        foreach ($InvoiceGroupProduct as  $value) {
            $GroupProduct = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id', $invoice_id);
            $GroupProduct->where('sale_invoice_product.invoice_group_id', $value['invoice_group_id']);
            $GroupProduct->leftjoin('product_variation', 'sale_invoice_product.variation_id', 'product_variation.id');
            $GroupProduct->leftjoin('sale_invoice_group', 'sale_invoice_product.invoice_group_id', 'sale_invoice_group.id');
            $GroupProduct->leftjoin('product_services', 'sale_invoice_product.product_id', 'product_services.id');
            $GroupProduct->select('sale_invoice_product.*', 'product_variation.variation_name', 'sale_invoice_group.group_name', 'product_services.name as productName');
            $GroupProduct = $GroupProduct->get()->toArray();


            $SaleInvoiceProduct = \App\Models\SaleInvoiceProductImage::where('product_id', $value['product_id'])->where('product_id', $value['product_id'])->get()->toArray();

            $SaleInvoiceProductNew = [];
            foreach ($SaleInvoiceProduct  as $key => $ProductImage) {
                if (!is_null($ProductImage['invoice_product_image'])) {
                    $profile_image = CommonHelper::getS3FileUrl($ProductImage['invoice_product_image']);
                    if ($profile_image->status == "success") {
                        $SaleInvoiceProductNew[$key]['id'] = $ProductImage['id'];
                        $SaleInvoiceProductNew[$key]['invoice_id'] = $ProductImage['invoice_id'];
                        $SaleInvoiceProductNew[$key]['product_id'] = $ProductImage['product_id'];
                        $SaleInvoiceProductNew[$key]['invoice_product_image'] = $profile_image->fileUrl;
                    }
                }
            }

            $grpProduct[$count]['group_name'] = @$value->group_name;
            $grpProduct[$count]['group_details'] = $GroupProduct;
            $grpProduct[$count]['product_img'] = $SaleInvoiceProductNew;
            $count++;
        }


        if (!empty($InvoiceProduct) && !empty($grpProduct)) {
            $SaleInvoiceProduct1 = array_merge($InvoiceProduct, $grpProduct);
            $SaleInvoiceProduct = array_map("unserialize", array_unique(array_map("serialize", $SaleInvoiceProduct1)));
        } else if (!empty($InvoiceProduct) && empty($grpProduct)) {
            $SaleInvoiceProduct = $InvoiceProduct;
        } else if (empty($InvoiceProduct) && !empty($grpProduct)) {
            $SaleInvoiceProduct = $grpProduct;
        } else {
            $SaleInvoiceProduct = [];
        }

        $SaleInvoiceService = \App\Models\SaleInvoiceService::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceGroup = \App\Models\SaleInvoiceGroup::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceGroupImg = \App\Models\SaleInvoiceGroupImg::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceProductImage = \App\Models\SaleInvoiceProductImage::where('invoice_id', $invoice_id)->get();
        foreach ($SaleInvoiceProductImage as $key => $ProductImage) {
            if (!is_null($ProductImage->invoice_product_image)) {
                $profile_image = CommonHelper::getS3FileUrl($ProductImage->invoice_product_image);
                if ($profile_image->status == "success") {
                    $ProductImage->invoice_product_image = $profile_image->fileUrl;
                }
            }
        }
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id', $invoice_id)->first();
        if (!is_null($SaleInvoiceAddFooter->footer_img)) {
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddFooter->footer_img);
            if ($profile_image->status == "success") {
                $SaleInvoiceAddFooter->footer_img = $profile_image->fileUrl;
            }
        }
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id', $invoice_id)->first();
        if (!is_null($SaleInvoiceAddLetterhead->letterhead_img)) {
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceAddLetterhead->letterhead_img);
            if ($profile_image->status == "success") {
                $SaleInvoiceAddLetterhead->letterhead_img = $profile_image->fileUrl;
            }
        }
        $SaleInvoiceAddPayment = \App\Models\SaleInvoiceAddPayment::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceBusinessDetails = \App\Models\SaleInvoiceBusinessDetails::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceChargeLateFee = \App\Models\SaleInvoiceChargeLateFee::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceClientDetails = \App\Models\SaleInvoiceClientDetails::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceQrCode = \App\Models\SaleInvoiceQrCode::where('invoice_id', $invoice_id)->first();
        if (!is_null($SaleInvoiceQrCode->qr_logo)) {
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceQrCode->qr_logo);
            if ($profile_image->status == "success") {
                $SaleInvoiceQrCode->qr_logo = $profile_image->fileUrl;
            }
        }
        if (!is_null($SaleInvoiceQrCode->qr_image)) {
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceQrCode->qr_image);
            if ($profile_image->status == "success") {
                $SaleInvoiceQrCode->qr_image = $profile_image->fileUrl;
            }
        }
        $SaleInvoiceShare = \App\Models\SaleInvoiceShare::where('invoice_id', $invoice_id)->get();
        $SaleInvoiceAllBankUpi = \App\Models\SaleInvoiceBankUpi::where('team_id', $team_id)->where('business_id', $auth_user->active_business_id)->get();
        $SaleInvoiceAllBankDetails = SaleInvoiceBankDetails::where('team_id', $team_id)->where('business_id', $auth_user->active_business_id)->get();

        $SaleInvoiceBankDetails = SaleInvoiceBankDetails::where('team_id', $team_id)->where('business_id', $auth_user->active_business_id)->where('is_show', 1)->first();
        $SaleInvoiceBankUpi = \App\Models\SaleInvoiceBankUpi::where('team_id', $team_id)->where('business_id', $auth_user->active_business_id)->where('is_active', 1)->first();
        // Advance setting
        $advanceSetting = \App\Models\SaleInvoiceAdvanceSetting::where('invoice_id', $invoice_id)->first();
        // show hsn code"
        $hsnInvoiceDetails = \App\Models\SaleInvoiceProduct::where('sale_invoice_product.invoice_id', $invoice_id)->get();

        //get product decription
        $getDecription = CommonHelper::getDecription($invoice_id, $row_index_id);
        //get product decription
        $getProductMedia = CommonHelper::getProductMedia($invoice_id, $row_index_id);
        /*SaleInvoiceAttachments*/
        $SaleInvoiceAttachments_data = \App\Models\SaleInvoiceAttachments::where('invoice_id', $invoice_id)->get();
        foreach ($SaleInvoiceAttachments_data as $key => $Attachments) {
            if (!is_null($Attachments->invoice_attachments)) {
                $profile_image = CommonHelper::getS3FileUrl($Attachments->invoice_attachments);
                if ($profile_image->status == "success") {
                    $Attachments->invoice_attachments = $profile_image->fileUrl;
                }
            }
        }
        /*SaleInvoiceAddFooter*/
        $SaleInvoiceAddFooter = \App\Models\SaleInvoiceAddFooter::where('invoice_id', $invoice_id)->first();
        if (!is_null($SaleInvoiceAddFooter->footer_img)) {
            $profile_image = CommonHelper::getS3FileUrl($Attachments->footer_img);
            if ($profile_image->status == "success") {
                $SaleInvoiceAddFooter->footer_img = $profile_image->fileUrl;
            }
        }
        /*SaleInvoiceAddLetterhead*/
        $SaleInvoiceAddLetterhead = \App\Models\SaleInvoiceAddLetterhead::where('invoice_id', $invoice_id)->first();
        if (!is_null($SaleInvoiceAddLetterhead->footer_img)) {
            $profile_image = CommonHelper::getS3FileUrl($Attachments->footer_img);
            if ($profile_image->status == "success") {
                $SaleInvoiceAddLetterhead->letterhead_img = $profile_image->fileUrl;
            }
        }
        /*signature_url get*/
        //echo $auth_user->id; exit;
        $SaleInvoiceSetting = \App\Models\SaleInvoiceSetting::where('created_by', $team_id);
        $SaleInvoiceSetting->where('business_id', $auth_user->active_business_id);
        $SaleInvoiceSetting = $SaleInvoiceSetting->first();
        if (!empty($SaleInvoiceSetting) && $SaleInvoiceSetting->signature_url != '') {
            $SaleInvoiceSetting->signature_url = env('APP_URL') . '/' . @$SaleInvoiceSetting->signature_url;
        }
        if (!is_null($SaleInvoiceSetting->s3_signature_url)) {
            $profile_image = CommonHelper::getS3FileUrl($SaleInvoiceSetting->s3_signature_url);
            if ($profile_image->status == "success") {
                $SaleInvoiceSetting->s3_signature_url = $profile_image->fileUrl;
            }
        }
        /*SaleInvoiceAddPayment*/
        $SaleInvoiceAddPayment = \App\Models\SaleInvoiceAddPayment::where('invoice_id', $invoice_id)->first();
        $data['saleInvoice'] = @$saleInvoice;
        $data['SaleInvoiceProduct'] = @$SaleInvoiceProduct;
        $data['SaleInvoiceProductImage'] = @$SaleInvoiceProductImage;
        $data['SaleInvoiceService'] = @$SaleInvoiceService;
        $data['SaleInvoiceGroup'] = @$SaleInvoiceGroup;
        $data['SaleInvoiceGroupImg'] = @$SaleInvoiceGroup;
        $data['SaleInvoiceAddFooter'] = @$SaleInvoiceAddFooter;
        $data['SaleInvoiceAddLetterhead'] = @$SaleInvoiceAddLetterhead;
        $data['SaleInvoiceAddPayment'] = @$SaleInvoiceAddPayment;
        $data['SaleInvoiceBankUpi'] = @$SaleInvoiceBankUpi;
        $data['SaleInvoiceBusinessDetails'] = @$SaleInvoiceBusinessDetails;
        $data['SaleInvoiceChargeLateFee'] = @$SaleInvoiceChargeLateFee;
        $data['SaleInvoiceClientDetails'] = @$SaleInvoiceClientDetails;
        $data['SaleInvoiceQrCode'] = @$SaleInvoiceQrCode;
        $data['SaleInvoiceShare'] = @$SaleInvoiceShare;
        $data['SaleInvoiceBankDetails'] = @$SaleInvoiceBankDetails;
        $data['advanceSetting'] = @$advanceSetting;
        $data['hsnInvoiceDetails'] = @$hsnInvoiceDetails;
        $data['SaleInvoiceAllBankUpi'] = @$SaleInvoiceAllBankUpi;
        $data['SaleInvoiceAllBankDetails'] = @$SaleInvoiceAllBankDetails;
        $data['invoice_id'] = @$invoice_id;
        $data['getDecription'] = @$getDecription;
        $data['getProductMedia'] = @$getProductMedia;
        $data['SaleInvoiceAttachments_data'] = @$SaleInvoiceAttachments_data;
        $data['SaleInvoiceSetting'] = @$SaleInvoiceSetting;
        $data['SaleInvoiceAddPayment'] = @$SaleInvoiceAddPayment;

        /* echo "<pre>";
        print_r($data['saleInvoice']); exit;*/
        return $data;
    }

    public function invoiceShow(Request $request)
    {
        $enypt_id = $request->uid;
        $auth_user = User::find(Decrypt($enypt_id));
        $team_id =  $auth_user->parent_id;
        if ($auth_user->parent_id == 0) {
            $team_id = $auth_user->id;
        }
        $permissions = $this->get_permissions($auth_user, Decrypt($enypt_id));
        $has_edit_permission = $this->module_hasPermission($permissions, 'products_inventory');
        $modules = Module::get();
        $commonData = $this->getCommonData($auth_user);
        $search = @$request->search;
        $invoice_id = @$request->inv_id;
        $row_index_id = @$request->row_index_id;
        $templete_id = 1;


        $amount_recived_sum =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)
            ->sum('amount_received');
        $total_tcs_amount =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('tcs_amount');
        $total_tds_amount =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('tds_amount');
        $total_transaction_charge =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)->sum('transaction_charge');
        $amount_recived =  SaleInvoiceAddPayment::where('invoice_id', @$invoice_id)
            ->orderBy('id', "DESC")
            ->first();



        //getAllinvoiceData in diffrent table
        $getAllData = $this->getAllinvoiceData($auth_user, @$invoice_id, @$row_index_id);
        $saleInvoice = $getAllData['saleInvoice'];
        $SaleInvoiceProduct = $getAllData['SaleInvoiceProduct'];
        $SaleInvoiceProductImage = $getAllData['SaleInvoiceProductImage'];
        $SaleInvoiceService = $getAllData['SaleInvoiceService'];
        $SaleInvoiceGroup = $getAllData['SaleInvoiceGroup'];
        $SaleInvoiceGroup = $getAllData['SaleInvoiceGroupImg'];
        $SaleInvoiceAddFooter = $getAllData['SaleInvoiceAddFooter'];
        $SaleInvoiceAddLetterhead = $getAllData['SaleInvoiceAddLetterhead'];
        $SaleInvoiceBankUpi = $getAllData['SaleInvoiceBankUpi'];
        $SaleInvoiceBusinessDetails = $getAllData['SaleInvoiceBusinessDetails'];
        $SaleInvoiceChargeLateFee = $getAllData['SaleInvoiceChargeLateFee'];
        $SaleInvoiceClientDetails = $getAllData['SaleInvoiceClientDetails'];
        $SaleInvoiceQrCode = $getAllData['SaleInvoiceQrCode'];
        $SaleInvoiceShare = $getAllData['SaleInvoiceShare'];
        $SaleInvoiceBankDetails = $getAllData['SaleInvoiceBankDetails'];
        $advanceSetting = $getAllData['advanceSetting'];
        $hsnInvoiceDetails = $getAllData['hsnInvoiceDetails'];
        $SaleInvoiceAllBankUpi = $getAllData['SaleInvoiceAllBankUpi'];
        $SaleInvoiceAllBankDetails = $getAllData['SaleInvoiceAllBankDetails'];
        $invoice_id = $getAllData['invoice_id'];
        $getDecription = $getAllData['getDecription'];
        $getProductMedia = $getAllData['getProductMedia'];
        $SaleInvoiceAttachments_data = $getAllData['SaleInvoiceAttachments_data'];
        $SaleInvoiceSetting = $getAllData['SaleInvoiceSetting'];
        $SaleInvoiceAddPayment = $getAllData['SaleInvoiceAddPayment'];

        # echo '<pre/>'; print_r($saleInvoice); exit;
        return view('allFrontendViews.invoice.show_invoice_in_link', compact('permissions', 'commonData', 'has_edit_permission', 'auth_user', 'enypt_id', 'templete_id', 'modules', 'saleInvoice', 'SaleInvoiceProduct', 'SaleInvoiceProductImage', 'SaleInvoiceService', 'SaleInvoiceGroup', 'SaleInvoiceGroupImg', 'SaleInvoiceAddFooter', 'SaleInvoiceAddLetterhead', 'SaleInvoiceAddPayment', 'SaleInvoiceBankUpi', 'SaleInvoiceBusinessDetails', 'SaleInvoiceChargeLateFee', 'SaleInvoiceClientDetails', 'SaleInvoiceQrCode', 'SaleInvoiceShare', 'SaleInvoiceBankDetails', 'advanceSetting', 'hsnInvoiceDetails', 'SaleInvoiceAllBankUpi', 'SaleInvoiceAllBankDetails', 'invoice_id', 'getDecription', 'getProductMedia', 'SaleInvoiceAttachments_data', 'SaleInvoiceSetting', 'amount_recived_sum', 'total_transaction_charge', 'total_tcs_amount', 'total_tds_amount'));
    }

    public function invoiceShoIinShortUrl(Request $request)
    {
        if (!empty($request->inv_id)) {
            $inv_id = @$request->inv_id;
            $enypt_id = encrypt(0);
            return redirect()->route('fn.invoice_show', [$enypt_id, $inv_id]);
        }
    }
}
