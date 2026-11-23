<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berita_views', function (Blueprint $table) {
            $table->id();

            $table->foreignId('berita_id')
                ->constrained('berita')
                ->cascadeOnDelete();

            // SHA-256 menghasilkan representasi hex sepanjang 64 karakter.
            $table->char('ip_hash', 64);

            // Hari kunjungan berdasarkan zona waktu aplikasi.
            $table->date('viewed_on');

            $table->timestamps();

            /*
             * Satu IP hanya boleh tercatat sekali untuk
             * berita yang sama pada tanggal yang sama.
             */
            $table->unique(
                ['berita_id', 'ip_hash', 'viewed_on'],
                'berita_views_daily_unique'
            );

            $table->index(
                ['viewed_on', 'berita_id'],
                'berita_views_date_news_index'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita_views');
    }
};
