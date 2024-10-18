<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type'); // Payment or Receipt
            $table->date('date');
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('account_id')->constrained('chart_of_accounts');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
