<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'head',
        'account',
        'balance',
        'balance_type',
    ];

    public function debitEntries()
    {
        return $this->hasMany(JournalEntry::class, 'debit_account_id');
    }

    public function creditEntries()
    {
        return $this->hasMany(JournalEntry::class, 'credit_account_id');
    }

    // Calculate the debit display value
    public function getDebitAttribute()
    {
        $debitTotal = $this->debitEntries->sum('amount');
        $creditTotal = $this->creditEntries->sum('amount');
        $netBalance = $this->balance + $debitTotal - $creditTotal;

        if ($this->type === 'Asset' || $this->type === 'Expense') {
            // Show positive balance as debit
            return $netBalance > 0 ? $netBalance : 0;

        } elseif ($this->type === 'Liability' || $this->type === 'Equity' || $this->type === 'Revenue') {
            // Show negative balance as debit (converted to positive)
            $netBalance = $this->balance - $debitTotal + $creditTotal;

            return $netBalance < 0 ? abs($netBalance) : 0;
        }

        return 0;
    }

    // Calculate the credit display value
    public function getCreditAttribute()
    {
        $debitTotal = $this->debitEntries->sum('amount');
        $creditTotal = $this->creditEntries->sum('amount');
        $netBalance = $this->balance - $debitTotal + $creditTotal;

        if ($this->type === 'Liability' || $this->type === 'Equity' || $this->type === 'Revenue') {
            // Show positive balance as credit
            return $netBalance > 0 ? $netBalance : 0;
        } elseif ($this->type === 'Asset' || $this->type === 'Expense') {
            $netBalance = $this->balance + $debitTotal - $creditTotal;
            return $netBalance < 0 ? abs($netBalance) : 0;
        }

        return 0;
    }


}
