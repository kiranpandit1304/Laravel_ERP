<?php

namespace App\Exports;

use App\Models\ProductBrand;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandExport implements FromCollection, WithHeadings
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
            $data = ProductBrand::where('id',$request['id'])
                    ->where('platform',$request['platform'])
                    ->where('guard',$request['guard'])
                    ->get();

        }else{
          
            $data = ProductBrand::where('created_by',$request)
                    ->where('platform',$request['platform'])
                    ->where('guard',$request['guard'])
                    ->get();
        }
       

        foreach($data as $k => $brand)
        {
            unset($brand->id,$brand->created_by, $brand->created_at, $brand->updated_at,$brand->url);
            $data[$k]["name"]     = $brand->name;
        }
       
        return $data;
    }

    public function headings(): array
    {
        return [
            "Name",
        ];
    }
}
