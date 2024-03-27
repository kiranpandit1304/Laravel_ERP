<?php

namespace App\Exports;

use App\Models\ProductServiceCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
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
            $data = ProductServiceCategory::where('id',$request['id'])
                    ->where('platform',$request['platform'])
                    ->where('guard',$request['guard'])
                    ->get();

        }else{
          
            $data = ProductServiceCategory::where('created_by',$request)
                    ->where('platform',$request['platform'])
                    ->where('guard',$request['guard'])
                    ->get();
        }
       

        foreach($data as $k => $category)
        {
            unset($category->id,$category->created_by, $category->created_at, $category->updated_at,$category->parent_id,$category->type,$category->color);
            $data[$k]["name"]     = $category->name;
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
