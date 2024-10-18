<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Asset, Liability, Equity, Revenue, Expense
            $table->string('head'); // Example: Current Assets, Long-term Liabilities, etc.
            $table->string('account'); // Specific account name
            $table->decimal('balance', 15, 2)->default(0.00); // Initial balance
            $table->string('balance_type')->default('DR');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chart_of_accounts');
    }
};

