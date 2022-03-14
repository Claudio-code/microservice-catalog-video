<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->string('thumb_file')->nullable();
            $table->string('banner_file')->nullable();
            $table->string('trailer_file')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('thumb_file');
            $table->dropColumn('banner_file');
            $table->dropColumn('trailer_file');
        });
    }
};
