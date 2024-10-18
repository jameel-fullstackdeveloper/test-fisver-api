<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function trialBalance()
    {
        $accounts = ChartOfAccount::with(['debitEntries', 'creditEntries'])->get();
        $totalDebit = 0;
        $totalCredit = 0;

        foreach ($accounts as $account) {
            $totalDebit += $account->debit;  // Sum the debit attribute values
            $totalCredit += $account->credit;  // Sum the credit attribute values
        }

        return view('reports.trial-balance', compact('accounts', 'totalDebit', 'totalCredit'));
    }

    public function balanceSheet()
    {
        $date = now()->format('Y-m-d'); // You can allow users to select a date

        $assets = ChartOfAccount::where('type', 'Asset')
                    ->get();
        $liabilities = ChartOfAccount::where('type', 'Liability')
                    ->get();
        $equities = ChartOfAccount::where('type', 'Equity')
                    ->get();

        // Calculate totals for each category
        $totalAssets = $assets->sum(function($account) {
            return $account->debit - $account->credit; // Assuming a debit balance is positive for assets
        });
        $totalLiabilities = $liabilities->sum(function($account) {
            return $account->credit - $account->debit; // Assuming a credit balance is positive for liabilities
        });
        $totalEquities = $equities->sum(function($account) {
            return $account->credit - $account->debit; // Assuming a credit balance is positive for equities
        });

        return view('reports.balance-sheet', compact('assets', 'liabilities', 'equities', 'totalAssets', 'totalLiabilities', 'totalEquities', 'date'));
    }

     public function profitloss(Request $request){

        $startDate = $request->start_date ?? now()->startOfYear()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $revenues = ChartOfAccount::where('type', 'Revenue')
                 //   ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();
        $expenses = ChartOfAccount::where('type', 'Expense')
                 //   ->whereBetween('created_at', [$startDate, $endDate])
                    ->get();

        // Calculate totals
        $totalRevenues = $revenues->sum('credit') - $revenues->sum('debit');
        $totalExpenses = $expenses->sum('debit') - $expenses->sum('credit');
        $netIncome = $totalRevenues - $totalExpenses;

        return view('reports.profit-loss', compact('revenues', 'expenses', 'totalRevenues', 'totalExpenses', 'netIncome', 'startDate', 'endDate'));
    }
}



