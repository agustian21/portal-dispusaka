<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_dailies', function (Blueprint $table) {
            $table->id();

            $table->string('ip_address', 45);
            $table->date('visit_date');

            // Informasi lokasi
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Daftar halaman yang dikunjungi
            $table->json('visited_routes')->nullable();

            // Timestamp
            $table->timestamps(6);

            // Satu IP hanya satu record per hari
            $table->unique(
                ['ip_address', 'visit_date'],
                'unique_daily_ip'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_dailies');
    }
};
