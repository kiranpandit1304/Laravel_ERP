<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpensePos;
use App\Models\Utility;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ExpensePOSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage expense')) {
            $expenses = ExpensePos::get();

            return view('expenses_pos.index', compact('expenses'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $warehouse     = warehouse::get()->pluck('name', 'id');
        $expenseCategory     = ExpenseCategory::get()->pluck('name', 'id');
        return view('expenses_pos.create', compact('warehouse', 'expenseCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (\Auth::user()->can('create expense')) {
            $usr       = \Auth::user();
            $validator = Validator::make(
                $request->all(),
                [
                    'title' => 'required|max:120',
                    'warehouse_id' => 'required|max:120',
                    'expense_category_id' => 'required|max:120',
                    'amount' => 'required|max:120',
                    'payment_status' => 'required|max:120',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $post = $request->all();
            $post['created_by'] = $usr->id;
            $expense = ExpensePos::create($post);
            if ($expense) {
                $input['reference_code'] = 'EX_11'.$expense->id;
                $expense->update($input);
                return redirect()->back()->with('success', __('Expense created successfully.'));
            } else {

                return redirect()->back()->with('error', __('Could not created'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * show
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     *  edit
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (\Auth::user()->can('edit expense')) 
        {

        $expense = ExpensePos::find($id);
        $warehouse     = warehouse::get()->pluck('name', 'id');
        $expenseCategory     = ExpenseCategory::get()->pluck('name', 'id');

            return view('expenses_pos.edit', compact('expense','warehouse', 'expenseCategory'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * update
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('edit product & service')) {
            $expense = ExpensePos::find($id);

            $expense->title   = @$request->title;
            $expense->date   =  @$request->date;
            $expense->warehouse_id   = @$request->warehouse_id;
            $expense->expense_category_id   = @$request->expense_category_id;
            $expense->amount   = @$request->amount;
            $expense->payment_status   = @$request->payment_status;
            $expense->payment_type   = @$request->payment_type;
            $expense->details   = @$request->details;
            $expense->save();

            return redirect()->route('expense.index')->with('success', __('Expense  updated manually.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($expenses_pos_id)
    {
        if (\Auth::user()->can('delete expense')) {
            
                $expense = ExpensePos::find($expenses_pos_id);
                $expense->delete();
                return redirect()->back()->with('success', __('Expense Deleted successfully.'));
           
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
