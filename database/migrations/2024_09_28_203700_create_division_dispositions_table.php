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
        Schema::create('division_dispositions', function (Blueprint $table) {
            $table->unsignedBigInteger('disposition_id');
            $table->unsignedBigInteger('division_id');

            $table->foreign('disposition_id')->references('id')->on('dispositions');
            $table->foreign('division_id')->references('id')->on('divisions');
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
