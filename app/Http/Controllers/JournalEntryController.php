<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function index()
    {
        $entries = JournalEntry::with(['debitAccount', 'creditAccount'])->get();
        return view('journal-entries.index', compact('entries'));
    }

    public function create()
    {
        $accounts = ChartOfAccount::all();
        return view('journal-entries.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'debit_account_id' => 'required|exists:chart_of_accounts,id',
            'credit_account_id' => 'required|exists:chart_of_accounts,id',
            'amount' => 'required|numeric|min:0',
        ]);

        JournalEntry::create($request->all());

        return redirect()->route('journal-entries.index')
                         ->with('success', 'Journal Entry created successfully.');
    }

    public function edit(JournalEntry $journalEntry)
    {
        $accounts = ChartOfAccount::all();
        return view('journal-entries.edit', compact('journalEntry', 'accounts'));
    }

    public function update(Request $request, JournalEntry $journalEntry)
    {
        $request->validate([
            'date' => 'required|date',
            'debit_account_id' => 'required|exists:chart_of_accounts,id',
            'credit_account_id' => 'required|exists:chart_of_accounts,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $journalEntry->update($request->all());

        return redirect()->route('journal-entries.index')
                         ->with('success', 'Journal Entry updated successfully.');
    }

    public function destroy(JournalEntry $journalEntry)
    {
        $journalEntry->delete();
        return redirect()->route('journal-entries.index')
                         ->with('success', 'Journal Entry deleted successfully.');
    }
}
