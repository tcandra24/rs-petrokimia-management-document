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
        Schema::create('pre_memos', function (Blueprint $table) {
            $table->id();
            $table->integer('counter');
            $table->string('number_transaction')->unique()->nullable();
            $table->unsignedBigInteger('from_user_id');
            $table->unsignedBigInteger('to_user_id');
            $table->string('regarding', 100);
            $table->text('content');
            $table->string('file')->nullable();
            $table->string('qr_code_file')->nullable();
            $table->timestamp('approve_datetime')->nullable();
            $table->timestamps();

            $table->foreign('from_user_id')->references('id')->on('users');
            $table->foreign('to_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_memos');
    }
};
