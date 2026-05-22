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
        Schema::create('loan_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->references('id')->on('loans')->cascadeOnDelete()->comment('loans.id');
            $table->integer('customer_id_card')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->integer('customer_family_book')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->integer('customer_birth_certificate')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->string('customer_other')->nullable();
            $table->integer('guarantor_id_card')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->integer('guarantor_family_book')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->integer('guarantor_birth_certificate')->default(1)->comment('0:none, 1:Original, 2:Copy');
            $table->string('guarantor_other')->nullable();
            $table->string('file')->nullable();
            $table->string('file_password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_documents');
    }
};
