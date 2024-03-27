<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\ExpensePos;
use App\Models\Utility;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ExpenseCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::user()->can('manage expense')) {
            $expenseCategories = ExpenseCategory::get();

            return view('expense_category.index', compact('expenseCategories'));
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
        return view('expense_category.create');
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
                    'name' => 'required|max:120',
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $post = $request->all();
            $post['created_by'] = $usr->id;
            $expenseCategory = ExpenseCategory::create($post);
            if ($expenseCategory) {
                return redirect()->back()->with('success', __('Expense category created successfully.'));
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
        $expenseCategory = ExpenseCategory::find($id);
        if (\Auth::user()->can('edit expense')) {
            return view('expense_category.edit', compact('expenseCategory'));
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
            $expenseCategory = ExpenseCategory::find($id);

            $expenseCategory->name   = @$request->name;
            $expenseCategory->description   = @$request->description;
            $expenseCategory->save();

            return redirect()->route('expense-category.index')->with('success', __('Expense category updated manually.'));
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
    public function destroy($expense_category_id)
    {
        if (\Auth::user()->can('delete expense')) {
            $expense = ExpensePos::where('expense_category_id', $expense_category_id)->first();
           
            if (!empty($expense) && count((array)$expense) > 0) {
               
                return redirect()->back()->with('error', __('Cloud not be deleted beacuse This category is assigned to expense.'));

            } 
            
            $ExpenseCategory = ExpenseCategory::find($expense_category_id);
            $ExpenseCategory->delete();

            return redirect()->back()->with('success', __('Expense Deleted successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
}
