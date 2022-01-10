<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToVideosTable extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('video_file')->nullable();
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('video_file');
        });
    }
}
