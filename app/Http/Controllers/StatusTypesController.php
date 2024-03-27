<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\StatusType;
use Illuminate\Http\Request;

class StatusTypesController extends Controller
{
    public function index()
    {
            $StatusTypes = StatusType::get();
            return view('statusTypes.index', compact('StatusTypes'));
    }

    public function create()
    {
        if(\Auth::user()->can('create constant unit'))
        {
            return view('statusTypes.create');
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

            $category             = new StatusType(); 
            $category->name       = $request->name;
            $category->save();

            return redirect()->route('status-types.index')->with('success', __('Status successfully created.'));
    }


    public function edit($id)
    {
        if($id)
        {
            $StatusEditType = StatusType::find($id);

            return view('statusTypes.edit', compact('StatusEditType'));
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
            $unit = StatusType::find($id);
            
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

                return redirect()->route('status-types.index')->with('success', __('Status successfully updated.'));
           
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $item = StatusType::find($id);
            $item->delete();

            return redirect()->route('status-types.index')->with('success', __('Status successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
