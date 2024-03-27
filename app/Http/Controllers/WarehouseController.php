<?php

namespace App\Http\Controllers;

use App\Models\Utility;
use App\Models\warehouse;
use App\Models\Country;
use App\Models\WarehouseProduct;
use App\Models\ManageStock;
use DB;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $warehouses_data = warehouse::where('warehouses.created_by', '=', \Auth::user()->creatorId());
        $warehouses_data->leftjoin('countries','warehouses.country','countries.id');
        $warehouses_data->leftjoin('states','warehouses.state','states.id');
        $warehouses_data->leftjoin('cities','warehouses.city','cities.id');
        $warehouses_data->select('warehouses.*','countries.name as country','states.name as state','cities.name as city');
        $warehouses = $warehouses_data->get();

        return view('warehouse.index',compact('warehouses'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::get()->pluck('name', 'id');
        return view('warehouse.create',compact('countries'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('create warehouse'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $warehouse             = new warehouse();
            $warehouse->name       = $request->name;
            $warehouse->address    = $request->address;
            $warehouse->phone      = $request->phone;
            $warehouse->country    = $request->country;
            $warehouse->state    = $request->state;
            $warehouse->email    = $request->email;
            $warehouse->latitude    = $request->latitude;
            $warehouse->longitude    = $request->longitude;
            $warehouse->city       = $request->city;
            $warehouse->city_zip   = $request->city_zip;
            $warehouse->created_by = \Auth::user()->creatorId();
            $warehouse->save();

            return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(warehouse $warehouse)
    {

        $id = WarehouseProduct::where('warehouse_id' , $warehouse->id)->first();

        if(\Auth::user()->can('show warehouse'))
        {
//            dd($warehouse->id);

            /*if(WarehouseProduct::where('warehouse_id' , $warehouse->id)->exists())
            {*/

                /*$warehouse = WarehouseProduct::where('warehouse_id' , $warehouse->id)->where('created_by', '=', \Auth::user()->creatorId())->get();*/
                 $warehouse = ManageStock::where('manage_stocks.warehouse_id' , $warehouse->id)
                                ->leftjoin('product_services','manage_stocks.product_id','product_services.id')
                                ->select('manage_stocks.*','product_services.name as productName')
                                ->get();

//                $data = DB::table('warehouse_products')
//                    ->select(DB::raw("SUM(quantity) as count"),'product_id')
//                    ->groupBy('product_id')
//                    ->get();
//                dd($data);


                return view('warehouse.show', compact('warehouse'));
            /*}
            else
            {


                $warehouse = [];
                return view('warehouse.show', compact('warehouse'));
            }*/
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(warehouse $warehouse)
    {

        if(\Auth::user()->can('edit warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
            {
                $countries = Country::get()->pluck('name', 'id');
                $states = \App\Models\State::where('country_id',$warehouse->country)->get()->pluck('name', 'id');
                $cities = \App\Models\City::where('state_id',$warehouse->state)->get()->pluck('name', 'id');

                return view('warehouse.edit', compact('warehouse','countries', 'states', 'cities'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, warehouse $warehouse)
    {

        if(\Auth::user()->can('edit warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                        'name' => 'required',
                    ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $warehouse->name       = $request->name;
                $warehouse->address    = $request->address;
                $warehouse->phone      = $request->phone;
                $warehouse->city       = $request->city;
                $warehouse->city_zip   = $request->city_zip;
                $warehouse->country    = $request->country;
                $warehouse->state    = $request->state;
                $warehouse->email    = $request->email;
                $warehouse->latitude    = $request->latitude;
                $warehouse->longitude    = $request->longitude;
                $warehouse->save();

                return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(warehouse $warehouse)
    {
        if(\Auth::user()->can('delete warehouse'))
        {
            if($warehouse->created_by == \Auth::user()->creatorId())
            {
                $warehouse->delete();


                return redirect()->route('warehouse.index')->with('success', __('Warehouse successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /*Get State list country wise*/
    public function stateList(Request $request)
    {
        $stateList = \App\Models\State::where('country_id',$request->country_id)->get();
        return response()->json($stateList);
    }
    /*Get city list state wise*/
    public function cityList(Request $request)
    {
        $cityList = \App\Models\City::where('state_id',$request->state_id)->get();
        return response()->json($cityList);
    }
    /*Get productList warehouse wise*/
    public function productList(Request $request)
    {
        $productList = \App\Models\Purchase::where('purchases.warehouse_id',$request->warehouse_id);
        $productList->leftjoin('purchase_products','purchases.id','purchase_products.purchase_id');
        $productList->leftjoin('product_services','purchase_products.product_id','product_services.id');
        $productList->leftjoin('manage_stocks','manage_stocks.product_id','product_services.id');
        $productList->select('product_services.id', 'product_services.name', 'manage_stocks.quantity as stock_qty');
        $productList->groupBy('purchase_products.product_id');
        $productList->where('manage_stocks.quantity',">", 0);
        $productList =$productList->get();
        return response()->json($productList);
    }
    
}
