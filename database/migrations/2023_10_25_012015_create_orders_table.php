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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers')->cascadeOnDelete()->comment('customers.id');
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete()->comment('employees.id');
            $table->string('total_amount');
            $table->integer('status')->default(1)->comment('1:ACTIVE, 2:INACTIVE');
            $table->integer('payment_status')->default(1)->comment('1:PAID, 2:UNPAID');
            $table->integer('payment_type')->default(1)->comment('1:CASH, 2:BANK, 3:OTHER');
            $table->timestamp('order_date')->useCurrent();
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
        Schema::dropIfExists('orders');
    }
};
