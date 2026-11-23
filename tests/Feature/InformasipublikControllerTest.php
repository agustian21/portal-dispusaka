<?php

namespace Tests\Feature;

use App\Http\Controllers\InformasipublikController;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class InformasipublikControllerTest extends TestCase
{
    public function test_it_groups_active_documents_with_the_requested_order(): void
    {
        // Hanya membuat fixture pada SQLite in-memory; tidak memakai database aplikasi.
        $previousConnection = config('database.default');
        config([
            'database.default' => 'ppid_ui_tests',
            'database.connections.ppid_ui_tests' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
                'foreign_key_constraints' => true,
            ],
        ]);

        try {
            Schema::connection('ppid_ui_tests')->create('katppid', function (Blueprint $table) {
                $table->id();
                $table->string('nm_ppid');
            });
            Schema::connection('ppid_ui_tests')->create('ppids', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('katppid_id');
                $table->string('judul');
                $table->text('file')->nullable();
                $table->string('tahun')->nullable();
                $table->unsignedInteger('status_id');
            });
            $connection = DB::connection('ppid_ui_tests');
            $connection->table('katppid')->insert([
                ['id' => 9, 'nm_ppid' => 'Kategori kedua'],
                ['id' => 2, 'nm_ppid' => 'Kategori pertama'],
                ['id' => 17, 'nm_ppid' => 'Kategori kosong'],
            ]);
            $connection->table('ppids')->insert([
                ['id' => 4, 'katppid_id' => 2, 'judul' => 'ID kecil tahun baru', 'tahun' => '2026', 'status_id' => 1],
                ['id' => 8, 'katppid_id' => 2, 'judul' => 'ID besar tahun lama', 'tahun' => '2021', 'status_id' => 1],
                ['id' => 99, 'katppid_id' => 2, 'judul' => 'Tidak dipublikasikan', 'tahun' => '2026', 'status_id' => 0],
                ['id' => 3, 'katppid_id' => 9, 'judul' => 'Kategori kedua', 'tahun' => '2024', 'status_id' => 1],
            ]);
            $connection->enableQueryLog();
            $connection->flushQueryLog();

            $view = app(InformasipublikController::class)->index();
            $data = $view->getData();
            $categories = $data['kategoriPpids'];

            $this->assertSame('home.publik', $view->name());
            $this->assertSame([2, 9, 17], $categories->modelKeys());
            $this->assertSame([8, 4], $categories[0]->ppids->modelKeys());
            $this->assertSame([3], $categories[1]->ppids->modelKeys());
            $this->assertTrue($categories[2]->ppids->isEmpty());
            $this->assertEquals(3, $data['totalDokumen']);
            $this->assertCount(2, $connection->getQueryLog());
        } finally {
            DB::purge('ppid_ui_tests');
            config(['database.default' => $previousConnection]);
        }
    }
}
