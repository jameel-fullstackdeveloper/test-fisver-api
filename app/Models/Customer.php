<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'email', 'contact_number', 'address'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}

