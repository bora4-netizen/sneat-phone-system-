<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loan_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->references('id')->on('loans')->cascadeOnDelete()->comment('loans.id');
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete()->comment('employees.id');
            $table->string('amount');
            $table->integer('payment_status')->default(1)->comment('1:Monthly, 2:Paying Off');
            $table->integer('payment_type')->default(1)->comment('1:CASH, 2:BANK, 3:OTHER');
            $table->date('date')->format('d/m/Y');
            $table->string('remain')->default(0)->nullable();
            $table->string('image')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_payments');
    }
};
