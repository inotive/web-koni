<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
{
    // Cek dulu apakah kolom sudah ada
    if (!Schema::hasColumn('atlets', 'foto_atlet')) {
        Schema::table('atlets', function (Blueprint $table) {
            $table->string('foto_atlet')->nullable()->after('email');
        });
    }
}

public function down()
{
    Schema::table('atlets', function (Blueprint $table) {
        $table->dropColumn('foto_atlet');
    });
}

};
