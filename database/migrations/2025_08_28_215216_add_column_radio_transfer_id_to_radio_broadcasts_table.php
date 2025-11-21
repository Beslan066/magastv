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
        Schema::table('radio_broadcasts', function (Blueprint $table) {
            $table->foreignId('radio_transfer_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('radio_broadcasts', function (Blueprint $table) {
            Schema::dropColumn('radio_transfer_id');
        });
    }
};
