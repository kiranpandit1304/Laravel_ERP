<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\BaseUnit;
use Illuminate\Http\Request;

class BaseUnitController extends Controller
{
    public function index()
    {
        if(\Auth::user()->can('manage constant unit'))
        {
            $units = BaseUnit::get();

            return view('productBaseUnit.index', compact('units'));
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
            return view('productBaseUnit.create');
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

            $category             = new BaseUnit(); 
            $category->name       = $request->name;
            $category->short_name       = $request->short_name;
            $category->created_by = \Auth::user()->creatorId();
            $category->save();

            return redirect()->route('base-unit.index')->with('success', __('Unit successfully created.'));
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
            $unit = BaseUnit::find($id);

            return view('productBaseUnit.edit', compact('unit'));
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
            $unit = BaseUnit::find($id);
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
                $unit->short_name = $request->short_name;
                $unit->save();

                return redirect()->route('base-unit.index')->with('success', __('Unit successfully updated.'));
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
            $unit = BaseUnit::find($id);
            if($unit->created_by == \Auth::user()->creatorId())
            {
                $units = ProductService::where('id', $unit->id)->first();
                if(!empty($units))
                {
                    return redirect()->back()->with('error', __('this unit is already assign so please move or remove this unit related data.'));
                }
                $unit->delete();

                return redirect()->route('base-unit.index')->with('success', __('Unit successfully deleted.'));
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
