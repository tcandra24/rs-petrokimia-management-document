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
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();
            $table->integer('counter');
            $table->unsignedBigInteger('memo_id')->nullable();
            $table->string('number_transaction')->unique();
            $table->enum('committee', ['medic', 'nursing', '-'])->nullable();
            $table->boolean('is_urgent')->nullable();
            $table->text('note')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['approve', 'reject', '']);
            $table->timestamps();

            $table->foreign('memo_id')->references('id')->on('memos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};
