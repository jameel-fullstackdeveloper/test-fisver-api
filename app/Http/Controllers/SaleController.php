<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\ChartofAccount;
use App\Models\JournalEntry;
use DB;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        $customers = ChartofAccount::where('head', 'Accounts Receivable')->get();
        return view('sales.index', compact('sales','customers'));
    }

    public function create()
    {
        $customers = ChartofAccount::where('head', 'Accounts Receivable')->get(); // Get all customers to select from
        return view('sales.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|unique:sales',
            'date' => 'required|date',
            'customer_id' => 'required|integer',
            'total_amount' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {

            $sale = Sale::create($request->all());

            // Record the debit entry (Customer/Accounts Receivable)
            JournalEntry::create([
                'date' => $sale->date,
                'description' => "Sale Invoice #" . $sale->invoice_number,
                'debit_account_id' => $sale->customer_id,  // Assuming customer_id links to an account
                'credit_account_id' => 4,
                'amount' => $sale->total_amount,
            ]);

            DB::commit();
            return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error: ' . $e->getMessage());
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

    }

    public function edit(Sale $sale)
    {
        $customers = Customer::all();
        return view('sales.edit', compact('sale', 'customers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'invoice_number' => 'required|unique:sales,invoice_number,' . $sale->id,
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'total_amount' => 'required|numeric'
        ]);

        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
