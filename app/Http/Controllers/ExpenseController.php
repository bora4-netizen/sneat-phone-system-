<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','store']]);
        $this->middleware('permission:expense-create', ['only' => ['create','store']]);
        $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:expense-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query = Expense::query();
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $parameterNames = [];

        if ($request->search) {
            $filters = $request->only(['name', 'category', 'from_date', 'to_date']);

            if (!empty($filters['name'])) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
                $parameterNames['name'] = $filters['name'];
            }

            if (!empty($filters['category'])) {
                $query->where('category_id', $filters['category']);
                $parameterNames['category'] = $filters['category'];
            }

            if (!empty($filters['from_date']) && !empty($filters['to_date'])) {
                $query->whereBetween('date', [$filters['from_date'], $filters['to_date']]);
                $parameterNames['from_date'] = $filters['from_date'];
                $parameterNames['to_date'] = $filters['to_date'];
            } elseif (!empty($filters['from_date'])) {
                $query->where('date', '>=', $filters['from_date']);
                $parameterNames['from_date'] = $filters['from_date'];
            } elseif (!empty($filters['to_date'])) {
                $query->where('date', '<=', $filters['to_date']);
                $parameterNames['to_date'] = $filters['to_date'];
            }
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(20);
        return view('expenses.index', compact('expenses', 'expenseCategories', 'parameterNames'));
    }

    public function create()
    {
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $currentDate = Carbon::now()->format('Y-m-d');
        return view('expenses.create', compact('expenseCategories', 'currentDate'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date'        => 'required|date',
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:expense_categories,id',
            'amount'      => 'required|numeric',
        ]);

        Expense::create([
            'date'        => $validatedData['date'],
            'name'        => $validatedData['name'],
            'category_id' => $validatedData['category_id'],
            'amount'      => $validatedData['amount'],
            'note'        => $request->note ?? '',
            'employee_id' => Auth::user()->id,
        ]);

        return redirect()->route('expenses.index', withLang())
            ->with('success', 'Expense added successfully');
    }

    public function edit(Expense $expense)
    {
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        return view('expenses.edit', compact('expense', 'expenseCategories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validatedData = $request->validate([
            'date'        => 'required|date',
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:expense_categories,id',
            'amount'      => 'required|numeric',
        ]);
        $validatedData['note'] = $request->note ?? '';

        $expense->update($validatedData);

        return redirect()->route('expenses.index', withLang())
            ->with('success', 'Expense updated successfully');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index', withLang())
            ->with('success', 'Expense deleted successfully');
    }
}