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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code')->nullable();
            $table->string('product_name');
            $table->string('product_imei');
            $table->foreignId('brand_id')->references('id')->on('brands')->cascadeOnDelete()->comment('brands.id');
            $table->foreignId('series_id')->references('id')->on('series')->cascadeOnDelete()->comment('series.id');
            $table->foreignId('color_id')->references('id')->on('colors')->cascadeOnDelete()->comment('colors.id');
            $table->foreignId('model_type_id')->references('id')->on('model_types')->cascadeOnDelete()->comment('model_types.id');
            $table->integer('condition')->default(1)->comment('1:Used, 2:New');
            $table->foreignId('storage_id')->references('id')->on('storages')->cascadeOnDelete()->comment('storages.id');
            $table->integer('type_of_machine')->default(1)->comment('1:iCloud, 2:Unlock, 2:Original');
            $table->foreignId('network_id')->default(0)->nullable()->references('id')->on('networks')->cascadeOnDelete()->comment('networks.id');
            $table->string('battery_percentage')->nullable();
            $table->string('percentage')->nullable();
            $table->string('purchase_price');
            $table->string('selling_price')->nullable();
            $table->foreignId('employee_id')->references('id')->on('employees')->cascadeOnDelete()->comment('employees.id');
            $table->date('purchase_date')->format('d/m/Y')->nullable();
            $table->integer('status')->default(1)->comment('1:Available, 2:Sold, 3:Reserved, 4:Pre-order');
            $table->string('image', 500)->nullable();
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
        Schema::dropIfExists('products');
    }
};
