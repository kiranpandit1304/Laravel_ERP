<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

/**
 * Class UserAPIController
 */
class ManageStockAPIController extends Controller
{
    /** @var $manageStockRepository */

    /**
     * @param ManageStockRepository $manageStockRepository
     */
    
    /**
     * @param Request $request
     *
     * @return ManageStockCollection
     */
    public function stockReport(Request $request)
    {
        $request->request->remove('filter');
        $perPage = getPageSize($request);
        $search = $request->get('search');
        $warehouseId = $request->get('warehouse_id');
        if ($search && $search != "null") {
            $stocks = $this->manageStockRepository->whereHas('product_services.productCategory',
                function ($query) use ($search) {
                    $query->where('product_services.code', 'like', '%'.$search.'%')
                        ->orWhere('product_services.name', 'like', '%'.$search.'%')
                        ->orWhere('product_services.product_cost', 'like', '%'.$search.'%')
                        ->orWhere('product_services.product_price', 'like', '%'.$search.'%')
                        ->orWhere('product_services.product_price', 'like', '%'.$search.'%')
                        ->orWhere('product_categories.name', 'like', '%'.$search.'%');
                })->where('warehouse_id', $warehouseId)->paginate($perPage);
        } else {
            $stocks = $this->manageStockRepository->where('warehouse_id', $warehouseId)->paginate($perPage);
        }
        ManageStockResource::usingWithCollection();

        return new ManageStockCollection($stocks);
    }
    public function stockGet(Request $request)
    {
        $stock = \App\Models\ManageStock::leftjoin('warehouses','manage_stocks.warehouse_id','warehouses.id');
        $stock->leftjoin('product_services','manage_stocks.product_id','product_services.id');
        $stock->select('manage_stocks.*','warehouses.name as warehousesName','product_services.name as productName','product_services.code as productCode');
        $stocks = $stock->get();

         if($stocks != ''){
            return response(['status'=>'200','Message'=>'stocks retrieved successfully','stocks' => $stocks]);
        }else{
            return response(['status'=>'401','Failed'=>"Failed"]);
        }
    }
}
