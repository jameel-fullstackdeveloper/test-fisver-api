<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'date', 'customer_id', 'total_amount'];

    // Casts 'date' as a Carbon instance
    protected $casts = [
        'date' => 'datetime',
    ];


}

