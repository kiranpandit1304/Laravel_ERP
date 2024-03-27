<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Adjustment;
use App\Models\AdjustmentItem;
use App\Models\AdjustmentItempractise;
use App\Models\StockHistoryPractise;
use App\Models\ManageStock;
use App\Models\StockHistory;
use App\Models\ProductService;
use App\Models\ProductVariation;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;


/**
 * Class Profilepository
 */
class AdjustmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        
    ];

    /**
     * @var string[]
     */
    protected $allowedFields = [
        'name',
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
        return Adjustment::class;
    }
   /*storeAdjustmentItems*/
    public function adjustment_add($input)
    {
        $manage_stock = ProductService::where('id',$input['product_id'])->first();
        if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1)
        {
            $adjustmentItem = new AdjustmentItem;
        }else{
            $adjustmentItem = new AdjustmentItempractise;
        }
        //$adjustmentItem->adjustment_id = (!empty($requestData['id']) ? $requestData['id'] : '');
        $adjustmentItem->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
        $adjustmentItem->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
        $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
        //$adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
        $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
        $adjustmentItem->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
        $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
        if(!empty($input['user_type']) && $input['user_type'] == 'customer')
        {
            $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
        }
        else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
        {
            $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
        }
        $adjustmentItem->vendor_client_name = @$customer['name'];
        $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                      $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $adjustmentItem->custome_field  =    json_encode($custome_data);
            }
        $adjustmentItem->created_by  =    \Auth::user()->id;
        /*add team id*/
        if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
        {
            $adjustmentItem->team_id = \Auth::user()->parent_id;
        }else{
            $adjustmentItem->team_id = \Auth::user()->id;
        }
        /*end*/
        $adjustmentItem = $adjustmentItem->save();

        /*StockHistory*/
        if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1)
        {
            $stockHistory = new StockHistory;
        }else{
            $stockHistory = new StockHistoryPractise;
        }
                if(!empty($input['variation_id']))
                {
                    $variation_name = \App\Models\ProductVariation::where('id',$input['variation_id'])->first();
                }
                $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
                $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
                $stockHistory->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
                $stockHistory->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
                $stockHistory->variation_name = @$variation_name['variation_name'];
                $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                
                if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                {
                    $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                }
                else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                {
                    $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                }
                $stockHistory->vendor_client_name = @$customer['name'];
                $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
                $stockHistory->created_by = \Auth::user()->id;
                $stockHistory->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
                $stockHistory->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
                if(!empty($input['custome_key']))
                {
                    $custome_data = [];
                    for($i = 0; $i < count($input['custome_key']); $i++)
                    {
                        if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                            $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                        }
                    }                
                    $stockHistory->custome_field  =    json_encode($custome_data);
                }
                $stockHistory->stock_date = date("Y-m-d h:i:s");
                $requestData = $stockHistory->save();
        

        return $requestData;
    }
  
    /*updateAdjustmentItems*/
    public function adjustment_update($input)
    {

        $manage_stock = ProductService::where('id',$input['product_id'])->first();
        if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1 && $manage_stock->is_group == 0)
        {
            $get_data = AdjustmentItem::where('variation_id',$input['variation_id'])->first();
            $adjustmentItem['adjustment_id'] = (!empty($input['adjustment_id']) ? $input['adjustment_id'] : '');
            if(!empty($input['product_id'])){
                $adjustmentItem['product_id'] = (!empty($input['product_id']) ? $input['product_id'] : '');
            }
            $adjustmentItem['variation_id'] = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            if(!empty($get_data) && $get_data->quantity != '')
            {
                if($input['method_type'] == '1')
                {
                    $adjustmentItem['quantity'] = (!empty($input['quantity'] + $get_data->quantity) ? $input['quantity'] + $get_data->quantity : '');
                }else{
                    $adjustmentItem['quantity'] = (!empty($get_data->quantity - $input['quantity']) ?  $get_data->quantity - $input['quantity']: '');
                }
            }else{
                $adjustmentItem['quantity'] = (!empty($input['quantity']) ? $input['quantity'] : '');
            }
            if(!empty($input['stock_alert']))
            {
                $adjustmentItem['stock_alert'] = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            }
            $adjustmentItem['method_type'] = (!empty($input['method_type']) ? $input['method_type'] : '');
            if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                $adjustmentItem['adjust_reason'] = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
            }else{
                $adjustmentItem['adjust_reason'] = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            }
                if(!empty($input['custome_key']))
                {
                    $custome_data = [];
                    for($i = 0; $i < count($input['custome_key']); $i++)
                    {
                        if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                        $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                        }
                    }                
                    $adjustmentItem['custome_field']  =    json_encode($custome_data);
                }
            $adjustmentItem['created_by']  =    \Auth::user()->id;
            $requestData = AdjustmentItem::where('variation_id',$input['variation_id'])
                                        ->where('product_id',$input['product_id'])
                                        ->update($adjustmentItem);

        }

        /*add group stock*/
        if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1 && $manage_stock->is_group == 1)
        {
            $group_product = \App\Models\ProductGroupItems::where('product_id',$input['product_id'])->get();
            foreach ($group_product as $value) 
            {
                $get_data = AdjustmentItem::where('variation_id',$value['variation_id'])->first();
                if(!empty($get_data) && $get_data->quantity != '')
                {
                    if($input['method_type'] == '1')
                    {
                            
                        $quantity = $input['quantity'] * $value['bundle_quantity'];
                        $adjustmentItem['quantity'] = (!empty($quantity + $get_data->quantity) ? $quantity + $get_data->quantity : '');
                    }
                    else
                    {
                        $quantity = $input['quantity'] * $value['bundle_quantity'];
                        $adjustmentItem['quantity'] = (!empty($get_data->quantity - $quantity ) ?  $get_data->quantity - $quantity : '');
                    }
                }
                else
                {
                    $adjustmentItem['quantity'] = (!empty($input['quantity']) ? $input['quantity'] : '');
                }
                $adjustmentItem['group_id'] = $input['product_id'];
                $requestData = AdjustmentItem::where('variation_id',$value['variation_id'])
                                              ->update($adjustmentItem);
            
                /*Stock StockHistory*/
                if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1 && $manage_stock->is_group == 1)
                {           
                    $stockHistory = new StockHistory;
                }else{            
                    $stockHistory = new StockHistoryPractise;
                }
                if(!empty($value['variation_id']))
                {
                    $variation_name = \App\Models\ProductVariation::where('id',$value['variation_id'])->first();
                }
                $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
                $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
                $stockHistory->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
                $stockHistory->variation_id = (!empty($value['variation_id']) ? $value['variation_id'] : '');
                $stockHistory->variation_name = @$variation_name['variation_name'];
                $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
                if(!empty($input['user_type']) && $input['user_type'] == 'customer')
                {
                    $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
                }
                else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
                {
                    $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
                }
                $stockHistory->vendor_client_name = @$customer['name'];
                $stockHistory->stock = (!empty($quantity) ? $quantity : '');
                $stockHistory->created_by = \Auth::user()->id;
                $stockHistory->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
                if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                        $stockHistory->adjust_reason = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
                }else{
                    $stockHistory->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
                }
                if(!empty($input['custome_key']))
                {
                    $custome_data = [];
                    for($i = 0; $i < count($input['custome_key']); $i++)
                    {
                        if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                            $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                        }
                    }                
                    $stockHistory->custome_field  =    json_encode($custome_data);
                }
                $stockHistory->stock_date = date("Y-m-d h:i:s");

                $requestData = $stockHistory->save();
            }
            
        }
        /*end group stock*/
        /*Direct stock add*/
        else if(!empty($input['is_first_stock_']) && $input['is_first_stock_'] == 'true')
        { 
            if(empty($input['variation_id']) && $input['variation_id'] == '')
            {
                $productVariationData = new ProductVariation;
                $productVariationData->variation_name  =    (!empty($input['variation_name']) ? $input['variation_name'] : '');
                $productVariationData->sku  =    (!empty($input['sku']) ? $input['sku'] : '');
                $productVariationData->purchase_price  =    (!empty($input['purchase_price']) ? $input['purchase_price'] : '');
                $productVariationData->sale_price  =    (!empty($input['sale_price']) ? $input['sale_price'] : '');
                $productVariationData->tax_rate  =    (!empty($input['tax_rate']) ? $input['tax_rate'] : '');
                $productVariationData->hsn  =    (!empty($input['hsn']) ? $input['hsn'] : '');
                $productVariationData->unit_id  =    (!empty($input['unit_id']) ? $input['unit_id'] : '');
                $productVariationData->created_by  =    \Auth::user()->id;
                $productVariationData->platform  =    (!empty($input['platform']) ? $input['platform'] : '');
                $productVariationData->guard  =    (!empty($input['guard']) ? $input['guard'] : '');  
                /*add team id*/
                 if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
                 {
                      $productVariationData->team_id = \Auth::user()->parent_id;
                 }else{
                      $productVariationData->team_id = \Auth::user()->id;
                 }
                 /*end*/          
                 $productVariationData = $productVariationData->save(); 
            }
            
            $get_variation = \App\Models\ProductVariation::orderBy('id','DESC')->first();
            $adjustmentItem['adjustment_id'] = (!empty($input['adjustment_id']) ? $input['adjustment_id'] : '');
            if(!empty($input['product_id'])){
                $adjustmentItem['product_id'] = (!empty($input['product_id']) ? $input['product_id'] : '');
            }
            if(!empty($input['variation_id']) && $input['variation_id'] != '')
            {
                $adjustmentItem['variation_id'] = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            }else{
                $adjustmentItem['variation_id'] = (!empty($get_variation['id']) ? $get_variation['id'] : '');

            }
            $get_data = AdjustmentItem::where('variation_id',$input['variation_id'])->first();
            if(!empty($get_data) && $get_data->quantity != '')
            {
                $adjustmentItem['quantity'] = (!empty($input['quantity'] + $get_data->quantity) ? $input['quantity'] + $get_data->quantity : '');
            }
            else
            {
                $adjustmentItem['quantity'] = (!empty($input['quantity']) ? $input['quantity'] : '');
            }
            if(!empty($input['stock_alert']))
            {
                $adjustmentItem['stock_alert'] = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            }
            $adjustmentItem['method_type'] = (!empty($input['method_type']) ? $input['method_type'] : '');
            if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                $adjustmentItem['adjust_reason'] = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
            }else{
                $adjustmentItem['adjust_reason'] = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            }

            $adjustmentItem['vendor_id'] = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $adjustmentItem['user_type'] = (!empty($input['user_type']) ? $input['user_type'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $adjustmentItem['vendor_client_name'] = @$customer['name'];
                if(!empty($input['custome_key']))
                {
                    $custome_data = [];
                    for($i = 0; $i < count($input['custome_key']); $i++)
                    {
                        if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                        $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                        }
                    }                
                    $adjustmentItem['custome_field']  =    json_encode($custome_data);
                }
            $adjustmentItem['created_by']  =    \Auth::user()->id;
            if(!empty($input['variation_id']) && $input['variation_id'] != '')
            {
               $requestData = AdjustmentItem::where('variation_id',$input['variation_id'])
                                        ->update($adjustmentItem);
            }
            else
            {
                $requestData = AdjustmentItem::create($adjustmentItem);
            }
            

        }
        else
        {

            $adjustmentItem = new AdjustmentItempractise;          
            $adjustmentItem->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
            $adjustmentItem->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
            $adjustmentItem->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $adjustmentItem->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $adjustmentItem->vendor_client_name = @$customer['name'];
            $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                      $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $adjustmentItem->custome_field  =    json_encode($custome_data);
            }
            $adjustmentItem->created_by  =    \Auth::user()->id;
            /*add team id*/
            if(!empty(\Auth::user()->parent_id) && \Auth::user()->parent_id != 0)
            {
                $adjustmentItem->team_id = \Auth::user()->parent_id;
            }else{
                $adjustmentItem->team_id = \Auth::user()->id;
            }
            /*end*/
            $adjustmentItem = $adjustmentItem->save();

        }
        /*manage stock direct*/
        if(empty($input['variation_id']) && $input['variation_id'] == '' &&  $input['is_first_stock_'] != 'true' && $manage_stock->is_group != 1)
        {
            $adjustmentItem = new AdjustmentItem;
            $adjustmentItem->quantity = (!empty($input['quantity']) ? $input['quantity'] : '');
            $adjustmentItem->stock_alert = (!empty($input['stock_alert']) ? $input['stock_alert'] : '');
            $adjustmentItem->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
            if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                $adjustmentItem->adjust_reason = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
            }else{
                $adjustmentItem->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            }
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                    $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $adjustmentItem->custome_field  =    json_encode($custome_data);
            }
            $adjustmentItem->created_by  =    \Auth::user()->id;
            $requestData = $adjustmentItem->save();

            /*add stock history data*/
            $stockHistory = new StockHistory;
            if(!empty($input['variation_id']))
            {
                $variation_name = \App\Models\ProductVariation::where('id',$input['variation_id'])->first();
            }
            $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
            $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
            $stockHistory->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
            $stockHistory->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
            $stockHistory->variation_name = @$variation_name['variation_name'];
            $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
            if(!empty($input['user_type']) && $input['user_type'] == 'customer')
            {
                $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
            }
            else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
            {
                $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
            }
            $stockHistory->vendor_client_name = @$customer['name'];
            $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
            $stockHistory->created_by = \Auth::user()->id;
            $stockHistory->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
            if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                $stockHistory->adjust_reason = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
            }else{
                $stockHistory->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
            }
            if(!empty($input['custome_key']))
            {
                $custome_data = [];
                for($i = 0; $i < count($input['custome_key']); $i++)
                {
                    if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                        $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                    }
                }                
                $stockHistory->custome_field  =    json_encode($custome_data);
            }
            $stockHistory->stock_date = date("Y-m-d h:i:s");
            $requestData = $stockHistory->save();

        }
        /*StockHistory*/
        if(isset($manage_stock->is_manage_stock) && $manage_stock->is_manage_stock == 1 && $manage_stock->is_group == 0)
        {       

            $stockHistory = new StockHistory;
        }else{            
            $stockHistory = new StockHistoryPractise;
        }
        if(!empty($input['variation_id']))
        {
            $variation_name = \App\Models\ProductVariation::where('id',$input['variation_id'])->first();
        }
        $stockHistory->vendor_id = (!empty($input['vendor_id']) ? $input['vendor_id'] : '');
        $stockHistory->vendor_client_name = (!empty($input['vendor_client_name']) ? $input['vendor_client_name'] : '');
        $stockHistory->product_id = (!empty($input['product_id']) ? $input['product_id'] : '');
        $stockHistory->variation_id = (!empty($input['variation_id']) ? $input['variation_id'] : '');
        $stockHistory->variation_name = @$variation_name['variation_name'];
        $stockHistory->user_type = (!empty($input['user_type']) ? $input['user_type'] : '');
        if(!empty($input['user_type']) && $input['user_type'] == 'customer')
        {
            $customer = \App\Models\Customer::where('id',$input['vendor_id'])->first();
        }
        else if(!empty($input['user_type']) && $input['user_type'] == 'vendor')
        {
            $customer = \App\Models\Vender::where('id',$input['vendor_id'])->first();
        }
        $stockHistory->vendor_client_name = @$customer['name'];
        $stockHistory->stock = (!empty($input['quantity']) ? $input['quantity'] : '');
        $stockHistory->created_by = \Auth::user()->id;
        $stockHistory->method_type = (!empty($input['method_type']) ? $input['method_type'] : '');
        if(!empty($input['adjust_reason']) && $input['adjust_reason']=='Other'){
                $stockHistory->adjust_reason = (!empty($input['custom_reason']) ? $input['custom_reason'] : '');
        }else{
            $stockHistory->adjust_reason = (!empty($input['adjust_reason']) ? $input['adjust_reason'] : '');
        }
        if(!empty($input['custome_key']))
        {
            $custome_data = [];
            for($i = 0; $i < count($input['custome_key']); $i++)
            {
                if(!empty($input['custome_key'][$i]) && !empty($input['custome_value'][$i])){
                    $custome_data[$i] = array($input['custome_key'][$i] => $input['custome_value'][$i]);
                }
            }                
            $stockHistory->custome_field  =    json_encode($custome_data);
        }
        $stockHistory->stock_date = date("Y-m-d h:i:s");
        $requestData = $stockHistory->save();
        
        return $requestData;
    }

    /*adjustment_product_list*/
    public function adjustment_product_list($product_id)
    {
        $adjustmentProductList = ProductVariation::leftjoin('adjustment_items','product_variation.id','adjustment_items.variation_id');
        $adjustmentProductList->where('adjustment_items.product_id',$product_id);
        $adjustmentProductList->select('adjustment_items.*','product_variation.variation_name');
        $adjustmentProductList = $adjustmentProductList->get();

        return $adjustmentProductList;
    }
    /*adjustment_variation_list*/
    public function adjustment_variation_list($variation_id)
    {
        $adjustmentVariationList = ProductVariation::leftjoin('adjustment_items','product_variation.id','adjustment_items.variation_id');
        $adjustmentVariationList->where('adjustment_items.variation_id',$variation_id);
        $adjustmentVariationList->select('adjustment_items.*','product_variation.variation_name');
        $adjustmentVariationList = $adjustmentVariationList->get();

         return $adjustmentVariationList;
    }
    /*stock_history*/
    public function stock_history()
    {
        $stockHistoryList = StockHistory::leftjoin('product_services','stock_history.product_id','product_services.id');
        $stockHistoryList->leftjoin('venders','stock_history.vendor_id','venders.id');
        $stockHistoryList->select('stock_history.*','product_services.name as productName','venders.name as vender');
        $stockHistoryList = $stockHistoryList->get();

        return $stockHistoryList;
    }
}
