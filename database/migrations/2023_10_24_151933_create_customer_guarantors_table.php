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
        Schema::create('customer_guarantors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->references('id')->on('customers')->cascadeOnDelete()->comment('customers.id');
            $table->string('id_card_number')->nullable();
            $table->string('name');
            $table->string('latin_name')->nullable();
            $table->integer('gender')->default(1)->comment('1:Male, 2:Femal');
            $table->integer('customer_relation_type')->default(1)->comment('1:family, 2:parents, 3:relatives, 4:frient');
            $table->integer('nationality')->default(1)->comment('1:Cambodia, 2:Foreigner');
            $table->integer('family_status')->default(1)->comment('1:Single, 2:Married');
            $table->date('dob')->nullable();
            $table->string('house_number')->nullable();
            $table->string('street_number')->nullable();
            $table->string('group_number')->nullable();
            $table->string('village')->nullable();
            $table->string('commune')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();
            $table->integer('housing_ownership_type')->default(1)->comment('1:personal, 2:parents, 3:relatives, 4:rent, 5;other');
            $table->string('phone');
            $table->string('mobile')->nullable();
            $table->string('facebook')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_guarantors');
    }
};
