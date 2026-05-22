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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete()->comment('users.id');
            $table->foreignId('position_id')->references('id')->on('roles')->cascadeOnDelete()->comment('roles.id');
            $table->string('id_card_no')->nullable();
            $table->string('name')->comment('Khmer Name');
            $table->string('latin_name')->comment('English Name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->integer('gender')->default(1)->comment('1:Male, 2:Femail');
            $table->integer('nationality')->default(0)->comment('0:Cambodia, 1:Foreigner');
            $table->date('dob')->format('d/m/Y')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('profile', 500)->nullable();
            $table->integer('status')->default(1)->comment('1:Probationary Period, 2:Part Time, 3:Full Time, 4:Resign');
            $table->date('start_working_date')->format('d/m/Y')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
