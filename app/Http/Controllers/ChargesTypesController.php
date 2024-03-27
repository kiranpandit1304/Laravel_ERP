<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\TaxChargesType;
use Illuminate\Http\Request;

class ChargesTypesController extends Controller
{
    public function index()
    {
            $changesTypes = TaxChargesType::get();
            return view('taxChargesType.index', compact('changesTypes'));
    }

    public function create()
    {
        if(\Auth::user()->can('create constant unit'))
        {
            return view('taxChargesType.create');
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    public function store(Request $request)
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

            $category             = new TaxChargesType(); 
            $category->name       = $request->name;
            $category->slug       = $request->slug;
            $category->save();

            return redirect()->route('charges-types.index')->with('success', __('Charges successfully created.'));
    }


    public function edit($id)
    {
        if($id)
        {
            $changesType = TaxChargesType::find($id);

            return view('taxChargesType.edit', compact('changesType'));
        }
        else
        {
            return response()->json(['error' => __('Something went wrong.Please try later')], 401);
        }
    }


    public function update(Request $request, $id)
    {
        if($id)
        {
            $unit = TaxChargesType::find($id);
           
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
                $unit->slug = $request->slug;
                $unit->save();

                return redirect()->route('charges-types.index')->with('success', __('Charges successfully updated.'));
           
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if($id)
        {
                $item = TaxChargesType::find($id);
                $item->delete();

                return redirect()->route('charges-types.index')->with('success', __('Charges successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
