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
        Schema::table('transfers', function (Blueprint $table) {
            $table->string('slider_video')->nullable()->after('slider_image');
            $table->string('video_upload_status')->default('not_started')->after('slider_video');
            $table->integer('video_upload_progress')->default(0)->after('video_upload_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            Schema::dropColumns('slider_video', 'video_upload_status', 'video_upload_progress');
        });
    }
};
