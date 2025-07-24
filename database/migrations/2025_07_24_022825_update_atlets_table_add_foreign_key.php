<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atlets', function (Blueprint $table) {
            $table->dropColumn('cabor');
            
            $table->unsignedBigInteger('cabor_id')->nullable()->after('id');
            $table->foreign('cabor_id')->references('id')->on('cabang_olahragas');
        });
    }

    public function down(): void
    {
        Schema::table('atlets', function (Blueprint $table) {
            $table->dropForeign(['cabor_id']);
            $table->dropColumn('cabor_id');
            $table->string('cabor')->after('nama');
        });
    }
};