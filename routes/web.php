<?php

use App\Http\Controllers\IpussultengController;
use App\Http\Controllers\Otomasi\AkunController;
use App\Http\Controllers\otomasi\AlamatController;
use App\Http\Controllers\Otomasi\BerandaController;
use App\Http\Controllers\Otomasi\BeritaController;
use App\Http\Controllers\otomasi\CompanyController;
use App\Http\Controllers\Otomasi\DatabidangController;
use App\Http\Controllers\Otomasi\FaqlayananController;
use App\Http\Controllers\otomasi\HistoryController;
use App\Http\Controllers\Otomasi\KadisController;
use App\Http\Controllers\Otomasi\KatppidController;
use App\Http\Controllers\Otomasi\NamabidangController;
use App\Http\Controllers\Otomasi\PamfletController;
use App\Http\Controllers\Otomasi\Panel_Login;
use App\Http\Controllers\Otomasi\PejabatController;
use App\Http\Controllers\Otomasi\PpidController;
use App\Http\Controllers\Otomasi\SliderController;
use App\Http\Controllers\Otomasi\StatusConfirmationController;
use App\Http\Controllers\otomasi\StrukturController;
use App\Http\Controllers\otomasi\TugasController;
use App\Http\Controllers\otomasi\TugasppidController;
use App\Http\Controllers\Otomasi\UserController;
use App\Http\Controllers\Otomasi\VideoController;
use App\Http\Controllers\otomasi\VisimisippidController;
use App\Http\Controllers\Otomasi\VisitorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Route::get('/beranda', [App\Http\Controllers\HomeController::class, 'index'])->name('beranda');
Route::get('/sejarah-instansi', [App\Http\Controllers\HistoriesController::class, 'index'])->name('sejarah-instansi');
Route::get('/visi-dan-misi', [App\Http\Controllers\CompaniesController::class, 'index'])->name('visi-misi');
Route::get('/tugas-dan-fungsi', [App\Http\Controllers\TugasdinasController::class, 'index'])->name('tugas-dan-fungsi');
Route::get('/struktur-organisasi', [App\Http\Controllers\StrukturorganisasiController::class, 'index'])->name('struktur-organisasi');
Route::get('/berita-dispusaka', [App\Http\Controllers\NewsController::class, 'index'])->name('berita-dispusaka');
Route::get('/berita-dispusaka/{slug_judul}', [App\Http\Controllers\NewsController::class, 'show'])->name('berita-dispusaka.show');
Route::get('/koleksi-video', [App\Http\Controllers\MultimediaController::class, 'index'])->name('koleksi-video');
Route::get('/pamflet-dispusaka', [App\Http\Controllers\PamfletController::class, 'index'])->name('pamflet-dispusaka');
Route::get('/pamflet-dispusaka/{pamflet:slug_pamflet}', [App\Http\Controllers\PamfletController::class, 'show'])->name('pamflet-dispusaka.show');
Route::get('/faq-dispusaka', [App\Http\Controllers\FaqdispusakaController::class, 'index'])->name('faq-dispusaka');
Route::get('/informasi-publik', [App\Http\Controllers\InformasipublikController::class, 'index'])->name('informasi-publik');
Route::get('/ipussulteng', [IpussultengController::class, 'index'])->name('ipussulteng');
Route::get('/ppid/visi-misi', [App\Http\Controllers\VisiController::class, 'index'])->name('ppid.visi-misi');
Route::get('/ppid/tugas-dan-tanggungjawab', [App\Http\Controllers\TugasController::class, 'index'])->name('ppid.tugas');
Route::get('/ppid/alamat-instansi', [App\Http\Controllers\ALamatController::class, 'index'])->name('ppid.alamat');
Route::get('/koleksi-buku', [App\Http\Controllers\KoleksibukuController::class, 'index'])->name('koleksi-buku');


/*
|--------------------------------------------------------------------------
| Login Panel
|--------------------------------------------------------------------------
*/
Route::get('/panel-otomasi006', [Panel_Login::class, 'index'])->name('login');
Route::post('/panel-otomasi006', [Panel_Login::class, 'authenticate'])
    ->middleware('throttle:20,1')
    ->name('panel.login.store');

/*
|--------------------------------------------------------------------------
| Panel yang wajib login
|--------------------------------------------------------------------------
*/
Route::prefix('panel-otomasi006')
    ->name('panel.')
    ->middleware(['auth', 'panel.inactivity',])
    ->group(function () {
        Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');
        Route::post('/activity', [Panel_Login::class, 'heartbeat'])->name('activity');
        Route::post('/logout', [Panel_Login::class, 'logout'])->name('logout');

        //users
        Route::resource('users', UserController::class)->middleware('permission:users.manage');

        //akun saya
        Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
        Route::put('/akun', [AkunController::class, 'update'])
            ->middleware('throttle:10,1')->name('akun.update');

        //Informasi
        Route::get('/berita/export-pdf', [BeritaController::class, 'exportPdf'])
            ->name('berita.export-pdf')
            ->middleware('permission:berita.manage');
        Route::resource('berita', BeritaController::class)->middleware('permission:berita.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/berita-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('berita.status')->middleware('permission:berita.manage');
        Route::post('/berita-status/{id}', [BeritaController::class, 'status'])
            ->name('berita.status.submit')->middleware('permission:berita.manage');
        Route::resource('video', VideoController::class)->middleware('permission:video.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/video-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('video.status')->middleware('permission:video.manage');
        Route::post('/video-status/{id}', [VideoController::class, 'status'])
            ->name('video.status.submit')->middleware('permission:video.manage');
        Route::resource('pamflet', PamfletController::class)->middleware('permission:pamflet.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/pamflet-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('pamflet.status')->middleware('permission:pamflet.manage');
        Route::post('/pamflet-status/{id}', [PamfletController::class, 'status'])
            ->name('pamflet.status.submit')->middleware('permission:pamflet.manage');
        Route::resource('slider-website', SliderController::class)->middleware('permission:slider-website.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/slider-website-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('slider-website.status')->middleware('permission:slider-website.manage');
        Route::post('/slider-website-status/{id}', [SliderController::class, 'status'])
            ->name('slider-website.status.submit')->middleware('permission:slider-website.manage');
        Route::resource('databidang', DatabidangController::class)
            ->middleware('permission:databidang.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/databidang-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('databidang.status')->middleware('permission:databidang.manage');
        Route::post('/databidang-status/{id}', [DatabidangController::class, 'status'])
            ->name('databidang.status.submit')->middleware('permission:databidang.manage');


        //Profil
        Route::resource('sejarah-dinas', HistoryController::class)
            ->middleware('permission:sejarah-dinas.manage');
        Route::resource('visi-misi-instansi', CompanyController::class)
            ->middleware('permission:visi-misi-instansi.manage');
        Route::resource('tugas-fungsi', TugasController::class)
            ->middleware('permission:tugas-fungsi.manage');
        Route::resource('struktur-organisasi', StrukturController::class)
            ->middleware('permission:struktur-organisasi.manage');
        Route::resource('data-kadis', KadisController::class)->middleware('permission:data-kadis.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/data-kadis-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('data-kadis.status')->middleware('permission:data-kadis.manage');
        Route::post('/data-kadis-status/{id}', [KadisController::class, 'status'])
            ->name('data-kadis.status.submit')->middleware('permission:data-kadis.manage');
        Route::resource('data-pejabat', PejabatController::class)->middleware('permission:data-pejabat.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/data-pejabat-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('datapejabat.status')->middleware('permission:data-pejabat.manage');
        Route::post('/data-pejabat-status/{id}', [PejabatController::class, 'status'])
            ->name('datapejabat.status.submit')->middleware('permission:data-pejabat.manage');

        //PPID
        Route::resource('visimisippid', VisimisippidController::class)
            ->only(['index', 'store', 'update',])
            ->middleware('permission:visimisippid.manage');
        Route::resource('tugasppid', TugasppidController::class)
            ->only(['index', 'store', 'update',])
            ->middleware('permission:tugasppid.manage');
        Route::resource('alamat', AlamatController::class)
            ->only(['index', 'store', 'update',])
            ->middleware('permission:alamat.manage');
        Route::resource('ppid', PpidController::class)
            ->middleware('permission:ppid.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/ppid-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('ppid.status')->middleware('permission:ppid.manage');
        Route::post('/ppid-status/{id}', [PpidController::class, 'status'])
            ->name('ppid.status.submit')->middleware('permission:ppid.manage');

        //pengaturan
        Route::resource('faqlayanan', FaqlayananController::class)->middleware('permission:faq.manage');
        // GET hanya menampilkan konfirmasi, tidak pernah mengubah data.
        Route::get('/faqlayanan-status/{id}', [StatusConfirmationController::class, 'show'])
            ->name('faqlayanan.status')->middleware('permission:faq.manage');
        Route::post('/faqlayanan-status/{id}', [FaqlayananController::class, 'status'])
            ->name('faqlayanan.status.submit')->middleware('permission:faq.manage');
        Route::resource('namabidang', NamabidangController::class)->middleware('permission:settings.manage');
        Route::resource('katppid', KatppidController::class)
            ->only(['index', 'store', 'show', 'update', 'destroy',])
            ->middleware('permission:settings.manage');
        Route::resource('buku-tamu', VisitorController::class)
            ->middleware('permission:settings.manage');
    });
