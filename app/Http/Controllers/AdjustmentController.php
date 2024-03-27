<?php

namespace App\Http\Controllers;

use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use App\Models\ManageStock;
use App\Models\ProductService;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AdjustmentController extends Controller
{
    /** @var  AdjustmentRepository */
    public function index(Request $request)
    {
        $adjustments = Adjustment::get();

        if ($request->get('warehouse_id')) {
            $adjustments->where('warehouse_id', $request->get('warehouse_id'));
        }

        //$adjustments = $adjustments->get();
    //    dd($adjustments);
        return view('adjustments.index', compact('adjustments'));
    }


    /**
     * @param Request $request
     *
     *
     * @return AdjustmentResource
     */

     public function create(Adjustment $adjustment)
     {
        $warehouse     = warehouse::get()->pluck('name', 'id');
        $product_services = ProductService::get()->pluck('name', 'id');
        $product_services->prepend('--', '');
         return view('adjustments.create', compact('product_services', 'warehouse'));
         
     }
    public function store(Request $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        $input['total_products'] = count($input['items']);
        $input['date'] = $input['date'] ?? date("Y/m/d");
        $adjustmentInputArray = \Arr::only($input, [
            'date', 'warehouse_id', 'total_products',
        ]);
        $adjustment = Adjustment::create($adjustmentInputArray);
        $reference_code = 'AD_111'.$adjustment->id;
        $adjustment->update(['reference_code' => $reference_code]);

        $adjustment = $this->storeAdjustmentItems($adjustment, $input);

        DB::commit();

        return redirect()->route('adjustments.index')->with('success', __('Adjustment successfully created .'));

    }
    public function storeAdjustmentItems($adjustment, $input)
    {
        foreach ($input['items'] as $adjustmentItem) {
            $adjustmentItem['adjustment_id'] = $adjustment->id;
            $adjustmentItem['product_id'] = @$adjustmentItem['item'];
            AdjustmentItem::Create($adjustmentItem);

            $product = ManageStock::whereWarehouseId($adjustment->warehouse_id)->whereProductId($adjustmentItem['item'])->first();
            if (!empty($product)) {
                $totalQuantity = 0;
                if ($adjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                    $totalQuantity = $product->quantity + $adjustmentItem['quantity'];
                    $product->update([
                        'quantity' => $totalQuantity,
                    ]);
                } else {
                    $totalQuantity = $product->quantity - $adjustmentItem['quantity'];
                    if ($totalQuantity < 0) {
                        throw new UnprocessableEntityHttpException("Quantity exceeds quantity available in stock.");
                    }
                    
                    $product->update([
                        'quantity' => $totalQuantity,
                    ]);
                }
            } else {
                
                if ($adjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                    ManageStock::create([
                        'warehouse_id' => $adjustment->warehouse_id,
                        'product_id'   => $adjustmentItem['item'],
                        'quantity'     => $adjustmentItem['quantity'],
                    ]);
                }
            }
        }

        return $adjustment;
    }

    /**
     * @param Adjustment $adjustment
     *
     *
     * @return AdjustmentResource
     */
    public function show(Adjustment $adjustment)
    {
        $warehouse     = warehouse::get()->pluck('name', 'id');
        $adjustment_items = AdjustmentItem::whereAdjustmentId($adjustment->id)->get();
        $product_services = ProductService::get()->pluck('name', 'id');
        $product_services->prepend('--', '');
        return view('adjustments.view', compact('adjustment', 'adjustment_items', 'product_services', 'warehouse'));
    }


    /**
     * @param Adjustment $adjustment
     *
     *
     * @return AdjustmentResource
     */
    public function edit(Adjustment $adjustment)
    {
        $warehouse     = warehouse::get()->pluck('name', 'id');
        $adjustment_items = AdjustmentItem::whereAdjustmentId($adjustment->id)->get();
        $product_services = ProductService::get()->pluck('name', 'id');
        $product_services->prepend('--', '');
        return view('adjustments.edit', compact('adjustment', 'adjustment_items', 'product_services', 'warehouse'));
        
    }


    /**
     * @param UpdateAdjustmentRequest $request
     * @param $id
     *
     *
     * @return AdjustmentResource
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        // dd($input);
        try {

            DB::beginTransaction();
            $adjustment = Adjustment::findOrFail($id);

            $input['total_products'] = count($input['items']);
            $input['date'] = $input['date'] ?? date("Y/m/d");
            $adjustmentInputArray = \Arr::only($input, [
                'date', 'warehouse_id', 'total_products',
            ]);
            $adjustment->update($adjustmentInputArray);

            $adjustment = $this->updateAdjustmentItems($adjustment, $input);

            DB::commit();

            return redirect()->route('adjustments.index')->with('success', __('Adjustment successfully updated .'));

            } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        


    }
     public function updateAdjustmentItems($adjustment, $input)
    {
        $adjustmentItmOldIds = AdjustmentItem::whereAdjustmentId($adjustment->id)->pluck('id')->toArray();
        $adjustmentItemIds = [];
        // dd($input);
        foreach ($input['items'] as $key => $adjustmentItem) {

            $adjustmentItemIds[$key] = $adjustmentItem['adjustment_item_id'];

            $product = ManageStock::whereWarehouseId($adjustment->warehouse_id)->whereProductId($adjustmentItem['item'])->first();

            if (is_null($adjustmentItem['adjustment_item_id'])) {

                $adjustmentItem['adjustment_id'] = $adjustment->id;
                $adjustmentItem['product_id'] = $adjustmentItem['item'];

                AdjustmentItem::Create($adjustmentItem);

                if (!empty($product)) {

                    if ($adjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                        $totalQuantity = $product->quantity + $adjustmentItem['quantity'];
                       
                        $product->update([
                            'quantity' => $totalQuantity,
                        ]);
                    } else {
                        $totalQuantity = $product->quantity - $adjustmentItem['quantity'];
                        
                        if ($totalQuantity < 0) {
                           
                            return redirect()->back()->with('error', __("Quantity exceeds quantity available in stock."));

                        }
                        $product->update([
                            'quantity' => $totalQuantity,
                        ]);
                    }
                } else {
                    if ($adjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                        ManageStock::create([
                            'warehouse_id' => $adjustment->warehouse_id,
                            'product_id'   => $adjustmentItem['item'],
                            'quantity'     => $adjustmentItem['quantity'],
                        ]);
                    }
                }
            } else {

                $exitAdjustmentItem = AdjustmentItem::whereId($adjustmentItem['adjustment_item_id'])->firstOrFail();

                if ($exitAdjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                    $existQuantity = $product->quantity - $exitAdjustmentItem->quantity;
                } else {
                    $existQuantity = $product->quantity + $exitAdjustmentItem->quantity;
                }
               
                if ($adjustmentItem['method_type'] == AdjustmentItem::METHOD_ADDITION) {
                    $totalQuantity = $existQuantity + $adjustmentItem['quantity'];
                    $product->update([
                        'quantity' => $totalQuantity,
                    ]);
                } else {
                    $totalQuantity = $existQuantity - $adjustmentItem['quantity'];
                    if ($totalQuantity < 0) {
                        return redirect()->back()->with('error', __("Quantity exceeds quantity available in stock."));

                    }
                    $product->update([
                        'quantity' => $totalQuantity,
                    ]);
                }

                $exitAdjustmentItem->update([
                    'quantity'    => $adjustmentItem['quantity'],
                    'method_type' => $adjustmentItem['method_type'],
                ]);

            }

        }

        $removeItemIds = array_diff($adjustmentItmOldIds, $adjustmentItemIds);

        if (!empty(array_values($removeItemIds))) {
            foreach ($removeItemIds as $removeItemId) {
                $oldItem = AdjustmentItem::whereId($removeItemId)->firstOrFail();
                $existProductStock = ManageStock::whereWarehouseId($adjustment->warehouse_id)->whereProductId($oldItem->product_id)->first();

                if ($oldItem->method_type == AdjustmentItem::METHOD_ADDITION) {
                    $totalQuantity = $existProductStock->quantity - $oldItem['quantity'];
                } else {
                    $totalQuantity = $existProductStock->quantity + $oldItem['quantity'];
                }
               
                $existProductStock->update([
                    'quantity' => $totalQuantity,
                ]);
            }
            AdjustmentItem::whereIn('id', array_values($removeItemIds))->delete();
        }

        return $adjustment;
    }
/**
     * Get product stock ..
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function productStock(Request $request)
    {

        $product = ProductService::find($request->product_id);
        $manageStock = ManageStock::where('warehouse_id', $request->warehouse_id)->where("product_id", $request->product_id)->first();
        $data['sku'] = (!empty($product->sku) ? $product->sku : '');
        $data['totalStock'] = (!empty($manageStock->quantity) ? $manageStock->quantity : 0);
        // dd($manageStock);
        return json_encode($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $adjustment = Adjustment::with('adjustmentItems')->where('id', $id)->firstOrFail();


            foreach ($adjustment->adjustmentItems as $adjustmentItem) {

                $oldItem = AdjustmentItem::whereId($adjustmentItem->id)->firstOrFail();
                $existProductStock = ManageStock::whereWarehouseId($adjustment->warehouse_id)->whereProductId($oldItem->product_id)->first();

                if ($oldItem->method_type == AdjustmentItem::METHOD_ADDITION) {
                    $totalQuantity = $existProductStock->quantity - $oldItem['quantity'];
                } else {
                    $totalQuantity = $existProductStock->quantity + $oldItem['quantity'];
                }

                $existProductStock->update([
                    'quantity' => $totalQuantity,
                ]);

            }

             AdjustmentItem::where('adjustment_id', $id)->delete();
             $adjustment->delete();

            DB::commit();
            return redirect()->route('adjustments.index')->with('success', __('Adjustment delete updated .'));

        } catch (Exception $e) {
            DB::rollBack();
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
