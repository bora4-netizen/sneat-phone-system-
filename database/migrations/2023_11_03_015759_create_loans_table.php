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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->cascadeOnDelete()->comment('products.id');
            $table->foreignId('customer_id')->references('id')->on('customers')->cascadeOnDelete()->comment('customers.id');
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete()->comment('employees.id');
            $table->integer('status')->default(1)->comment('1:Pending, 2:Approved, 3:Rejected');
            $table->string('amount');
            $table->string('first_amount');
            $table->string('interest');
            $table->tinyInteger('payment_type')->nullable()->default(2)->comment('1:Daily, 2:Monthly, 3:Yearly');
            $table->string('duration');
            $table->string('amount_principal');
            $table->string('amount_interest');
            $table->string('payable_amount');
            $table->string('remain')->default(0)->nullable();
            $table->date('date')->format('d/m/Y');
            $table->date('next_payment_date')->format('d/m/Y')->nullable();
            $table->string('file')->nullable();
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
        Schema::dropIfExists('loans');
    }
};
