<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staffs')->onDelete('cascade');
            $table->string('bulan_tahun'); // format YYYY-MM
            $table->integer('jumlah_hadir')->default(0);
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tunjangan', 15, 2)->default(0);
            $table->decimal('potongan', 15, 2)->default(0);
            $table->decimal('total_bersih', 15, 2)->default(0);
            $table->enum('status_pembayaran', ['belum dibayar', 'sudah dibayar'])->default('belum dibayar');
            $table->timestamps();

            $table->unique(['staff_id', 'bulan_tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
