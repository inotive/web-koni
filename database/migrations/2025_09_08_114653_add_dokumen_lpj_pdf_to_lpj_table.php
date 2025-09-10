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
        Schema::table('lpj', function (Blueprint $table) {
            if (!Schema::hasColumn('lpj', 'dokumen_lpj_pdf')) {
                $table->json('dokumen_lpj_pdf')->nullable()->after('dokumen_lpj');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            if (Schema::hasColumn('lpj', 'dokumen_lpj_pdf')) {
                $table->dropColumn('dokumen_lpj_pdf');
            }
        });
    }
};
