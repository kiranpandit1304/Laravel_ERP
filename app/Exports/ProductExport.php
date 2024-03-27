<?php

namespace App\Exports;

use App\Models\ProductService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    public function __construct($request = '')
    {
        $this->request = $request;
    }
    public function collection()
    {
        $request = $this->request;        
        if(!empty($request) && $request['id'] != '')
        {
            $productList = ProductService::whereIn('product_services.id',$request['id']);
            //$productList->where('product_services.platform',$request['platform']);
            //$productList->where('product_services.guard',$request['guard']);
            $productList->where('product_services.business_id',$request['business_id']);
            $productList->where('product_services.is_group',0);
            $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
            $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
            $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
            $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
            $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productList->select('product_services.name as productName','product_variation.variation_name','product_variation.sku','product_variation.purchase_price','product_variation.sale_price','product_variation.tax_rate','product_variation.hsn','product_service_units.name as unitName');
            $data = $productList->get();          

        }else{
          
            $productList = ProductService::where('product_services.created_by',$request['user_id']);
            //$productList->where('product_services.platform',$request['platform']);
            //$productList->where('product_services.guard',$request['guard']);
            $productList->where('product_services.business_id',$request['business_id']);
            $productList->where('product_services.is_group',0);
            $productList->leftjoin('product_brands','product_services.brand_id','product_brands.id');
            $productList->leftjoin('product_service_categories','product_services.category_id','product_service_categories.id');
            $productList->leftjoin('adjustment_items','product_services.id','adjustment_items.product_id');
            $productList->leftjoin('product_variation','adjustment_items.variation_id','product_variation.id');
            $productList->leftjoin('product_service_units','product_variation.unit_id','product_service_units.id');
            $productList->select('product_services.name as productName','product_variation.variation_name','product_variation.sku','product_variation.purchase_price','product_variation.sale_price','product_variation.tax_rate','product_variation.hsn','product_service_units.name as unitName');
            $data = $productList->get();
        }

        foreach($data as $k => $products)
        {
            unset($products->id, $products->created_by,$products->unit_id, $products->created_at, $products->updated_at, $products->remember_token);
            $data[$k]["productName"]     = $products->productName ? $products->productName:'';
            $data[$k]["variation_name"]     = $products->variation_name ? $products->variation_name:'';
            $data[$k]["sku"]     = $products->sku ? $products->sku:'';
            $data[$k]["purchase_price"]     = $products->purchase_price ? $products->purchase_price:'';
            $data[$k]["sale_price"]     = $products->sale_price ? $products->sale_price:'';
            $data[$k]["tax_rate"]     = $products->tax_rate ? $products->tax_rate:'';
            $data[$k]["hsn"]     = $products->hsn ? $products->hsn:'';
            $data[$k]["unitName"]     = $products->unitName ? $products->unitName :'';
        }

    return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
            "Variation name",
            "SKU",
            "Purchase price",
            "Sale price",
            "Tax rate",
            "HSN",
            "Unit name",
        ];
    }
}
