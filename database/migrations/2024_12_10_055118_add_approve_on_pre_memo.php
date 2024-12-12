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
        Schema::table('pre_memos', function (Blueprint $table) {
            $table->text('note')->nullable();
            $table->enum('status', ['approve', 'reject', '']);
            $table->string('approve_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_memos', function (Blueprint $table) {
            $table->dropColumn(['note', 'approve_by', 'status']);
        });
    }
};
