<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama_menu');
            $table->json('daftar_lauk')->nullable();
            $table->integer('kalori')->default(0);
            $table->integer('karbohidrat')->default(0);
            $table->integer('protein')->default(0);
            $table->foreignId('chef_id')->nullable()->constrained('staffs')->nullOnDelete();
            $table->foreignId('supir_id')->nullable()->constrained('staffs')->nullOnDelete();
            $table->enum('status', ['aktif', 'selesai', 'dibatalkan'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
