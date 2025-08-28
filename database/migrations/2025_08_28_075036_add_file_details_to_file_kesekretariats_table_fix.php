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
        Schema::table('file_kesekretariats', function (Blueprint $table) {
            $table->string('file_extension', 20)->after('dokumen_file')->nullable()->comment('File extension, e.g., pdf, docx');
            $table->unsignedBigInteger('file_size')->after('file_extension')->nullable()->comment('File size in bytes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('file_kesekretariats', function (Blueprint $table) {
            $table->dropColumn(['file_extension', 'file_size']);
        });
    }
};