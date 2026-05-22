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
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->references('id')->on('loans')->cascadeOnDelete()->comment('loans.id');
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete()->comment('products.id');
            $table->foreignId('customer_id')->references('id')->on('customers')->cascadeOnDelete()->comment('customers.id');
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete()->comment('employees.id');
            $table->integer('status')->default(1)->comment('1:Pending, 2:Approved, 3:Rejected');
            $table->string('amount');
            $table->string('first_amount');
            $table->string('interest');
            $table->string('duration');
            $table->date('date')->format('d/m/Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_details');
    }
};
