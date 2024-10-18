<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;

class LedgerController extends Controller
{
    public function index()
    {
        $accounts = ChartOfAccount::all();
        return view('ledger.index', compact('accounts'));
    }

    public function show(Request $request)
    {
        $account = ChartOfAccount::with(['debitEntries', 'creditEntries'])->findOrFail($request->account_id);
        $transactions = JournalEntry::where('debit_account_id', $account->id)
                            ->orWhere('credit_account_id', $account->id)
                            ->orderBy('date', 'asc')
                            ->get();

        // Start with the opening balance
        $balance = $account->balance;
        $ledger = [];

        // Create an initial ledger entry for the opening balance
        $initialBalance = $this->formatBalance($account, $balance);
        $ledger[] = [
            'date' => $account->created_at->format('Y-m-d'),  // or another appropriate start date
            'description' => 'Opening Balance',
            'debit' => $account->type == 'Dr.' ? $account->balance : 0,
            'credit' => $account->type == 'Cr.' ? $account->balance : 0,
            'balance' => $initialBalance
        ];

        foreach ($transactions as $transaction) {
            $debit = $transaction->debit_account_id == $account->id ? $transaction->amount : 0;
            $credit = $transaction->credit_account_id == $account->id ? $transaction->amount : 0;

            if (in_array($account->type, ['Asset', 'Expense'])) {
                $balance += $debit - $credit;
            } else {
                $balance += $credit - $debit;
            }

            $ledger[] = [
                'date' => $transaction->date,
                'description' => $transaction->description,
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $this->formatBalance($account, $balance)
            ];
        }

        return view('ledger.show', compact('ledger', 'account'));
    }

    private function formatBalance($account, $balance)
    {
        $formattedBalance = number_format(abs($balance), 2); // Format the balance to 2 decimal places
        $typeIndicator = '';

        if (in_array($account->type, ['Asset', 'Expense'])) {
            $typeIndicator = $balance >= 0 ? 'Dr.' : 'Cr.';
        } else {
            $typeIndicator = $balance >= 0 ? 'Cr.' : 'Dr.';
        }

        return $formattedBalance . ' ' . $typeIndicator;
    }

}


