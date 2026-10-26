<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->boolean('is_folder')->default(false)->after('parent_id');
            $table->string('modul')->nullable()->after('is_folder');
        });

        // Tandai data lama: semua root dan semua entri yang punya anak dianggap folder
        $parentIds = DB::table('lpj')->whereNotNull('parent_id')->distinct()->pluck('parent_id');
        DB::table('lpj')
            ->whereNull('parent_id')
            ->orWhereIn('id', $parentIds)
            ->update(['is_folder' => true]);

        // Bidang yang tampil di menu Bidang Bidang
        $bidangIcons = [
            1 => 'fa-solid fa-shield-virus',
            2 => 'fa-solid fa-people-group',
            3 => 'fa-solid fa-stethoscope',
            4 => 'fa-solid fa-user-doctor',
        ];
        foreach ($bidangIcons as $id => $icon) {
            DB::table('lpj')->where('id', $id)->whereNull('parent_id')->update(['modul' => 'bidang', 'icon' => $icon]);
        }

        DB::table('lpj')->whereNull('parent_id')->where('nama_program', 'Sekretariat')->update(['modul' => 'sekretariat']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpj', function (Blueprint $table) {
            $table->dropColumn(['is_folder', 'modul']);
        });
    }
};
