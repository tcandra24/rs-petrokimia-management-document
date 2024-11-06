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
        Schema::create('sub_division_dispositions', function (Blueprint $table) {
            $table->unsignedBigInteger('disposition_id');
            $table->unsignedBigInteger('sub_division_id');

            $table->foreign('disposition_id')->references('id')->on('dispositions');
            $table->foreign('sub_division_id')->references('id')->on('sub_divisions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('division_dispositions');
    }
};
