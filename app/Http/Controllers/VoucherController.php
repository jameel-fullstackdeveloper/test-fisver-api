<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with('account')->get();
        return view('vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::all();
        return view('vouchers.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'voucher_type' => 'required',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'account_id' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        Voucher::create($request->all());

        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully.');
    }

    public function edit(Voucher $voucher)
    {
        $accounts = ChartOfAccount::all();
        return view('vouchers.edit', compact('voucher', 'accounts'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'voucher_type' => 'required',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'account_id' => 'required|integer',
            'amount' => 'required|numeric'
        ]);

        $voucher->update($request->all());

        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully.');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')
                         ->with('success', 'Voucher deleted successfully.');
    }
}
