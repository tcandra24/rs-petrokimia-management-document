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
        Schema::table('dispositions', function (Blueprint $table) {
            $table->string('qr_code_file')->nullable();
            $table->timestamp('approve_datetime')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispositions', function (Blueprint $table) {
            $table->dropColumn(['qr_code_file', 'approve_datetime']);
        });
    }
};
