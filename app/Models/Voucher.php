<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_type',
        'date',
        'reference',
        'description',
        'account_id',
        'amount',
    ];

    protected $dates = [
        'date',  // Ensuring 'date' is treated as a Carbon instance
    ];

    // If you are using Laravel 7 or higher, you can also use the $casts attribute like this:
    protected $casts = [
        'date' => 'datetime:Y-m-d', // Ensures date is cast to datetime with the specified format
    ];

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }
}

