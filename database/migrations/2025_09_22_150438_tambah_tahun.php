<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            if (!Schema::hasColumn('lpj', 'year')) {
                $table->integer('year')->nullable()->index()->after('keterangan_tambahan');
            }
        });

        // Backfill year from created_at if null
        try {
            DB::statement('UPDATE lpj SET year = YEAR(created_at) WHERE year IS NULL');
        } catch (\Throwable $e) {
            // Ignore if database driver does not support YEAR() function
        }
    }

    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            if (Schema::hasColumn('lpj', 'year')) {
                $table->dropColumn('year');
            }
        });
    }
};
