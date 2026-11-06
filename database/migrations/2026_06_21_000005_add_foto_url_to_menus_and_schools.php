<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('foto_url')->nullable()->after('nama_menu');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->string('foto_url')->nullable()->after('nama_sekolah');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('foto_url');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('foto_url');
        });
    }
};
