<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\ProductBrand;
use App\Models\baseUnit;
use Illuminate\Http\Request;

class ProductBrandController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage constant unit'))
        {
            $brands = ProductBrand::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('productBrand.index', compact('brands'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create constant unit'))
        {
            return view('productBrand.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->can('create constant unit'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $unit             = new ProductBrand(); 
            $unit->name       = $request->name;
            $unit->created_by = \Auth::user()->creatorId();
            $unit->save();

            return redirect()->route('product-brand.index')->with('success', __('Brand successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {


            $brand = ProductBrand::find($id);
           
            return view('productBrand.edit', compact('brand'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function update(Request $request, $id)
    {
        if(\Auth::user()->can('edit constant unit'))
        {
            $unit = ProductBrand::find($id);
            if($unit->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                
                $unit->name = $request->name;
                $unit->save();

                return redirect()->route('product-brand.index')->with('success', __('Brand successfully updated.'));
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

    public function destroy($id)
    {
        if(\Auth::user()->can('delete constant unit'))
        {
            $brand = ProductBrand::find($id);
            if($brand->created_by == \Auth::user()->creatorId())
            {
                $if_exist = ProductService::where('brand_id', $brand->id)->first();
                if(!empty($if_exist))
                {
                    return redirect()->back()->with('error', __('this brand is already assign so please move or remove this unit related data.'));
                }
                $brand->delete();

                return redirect()->route('product-brand.index')->with('success', __('Unit successfully deleted.'));
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
}
