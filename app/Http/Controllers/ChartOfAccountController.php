<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::all();
        return view('chart-of-accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('chart-of-accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'head' => 'required',
            'account' => 'required',
            'balance' => 'required',
            'balance_type' => 'required',
        ]);

        ChartOfAccount::create($request->all());

        return redirect()->route('chart-of-accounts.index')
                         ->with('success', 'Account created successfully.');
    }

    public function edit(ChartOfAccount $chartOfAccount)
    {
        return view('chart-of-accounts.edit', compact('chartOfAccount'));
    }

    public function update(Request $request, ChartOfAccount $chartOfAccount)
    {
        $request->validate([
            'type' => 'required',
            'head' => 'required',
            'account' => 'required',
            'balance_type' => 'required',
        ]);

        $chartOfAccount->update($request->all());

        return redirect()->route('chart-of-accounts.index')
                         ->with('success', 'Account updated successfully.');
    }

    public function destroy(ChartOfAccount $chartOfAccount)
    {
        $chartOfAccount->delete();
        return redirect()->route('chart-of-accounts.index')
                         ->with('success', 'Account deleted successfully.');
    }
}

