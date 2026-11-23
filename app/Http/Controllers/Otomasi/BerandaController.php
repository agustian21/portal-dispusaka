<?php

namespace App\Http\Controllers\Otomasi;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Visitor;
use App\Models\Video;
use App\Models\Ppid;
use Carbon\Carbon;
use App\Models\VisitorDaily;

class BerandaController extends Controller
{

    /**
     * Menghitung persentase perubahan
     */
    private function hitungTrend($sekarang, $sebelumnya)
    {
        if ($sebelumnya == 0) {

            return $sekarang > 0 ? 100 : 0;
        }

        return round(
            (($sekarang - $sebelumnya) / $sebelumnya) * 100
        );
    }



    /**
     * Dashboard Beranda Admin
     */
    public function index()
    {

        /*
        |--------------------------------------------------------------------------
        | Statistik Utama
        |--------------------------------------------------------------------------
        */

        $jumlahBerita = Berita::count();

        $jumlahVisitor = VisitorDaily::whereMonth(
            'visit_date',
            Carbon::now()->month
        )
            ->whereYear(
                'visit_date',
                Carbon::now()->year
            )
            ->count();



        $jumlahVideo = Video::count();


        $jumlahPpid = Ppid::count();



        /*
        |--------------------------------------------------------------------------
        | Trend Statistik Bulan Ini vs Bulan Lalu
        |--------------------------------------------------------------------------
        */


        $bulanIni = Carbon::now();

        $bulanLalu = Carbon::now()
            ->subMonth();



        // -----------------
        // BERITA
        // -----------------

        $beritaSekarang = Berita::whereMonth(
            'created_at',
            $bulanIni->month
        )
            ->whereYear(
                'created_at',
                $bulanIni->year
            )
            ->count();


        $beritaLalu = Berita::whereMonth(
            'created_at',
            $bulanLalu->month
        )
            ->whereYear(
                'created_at',
                $bulanLalu->year
            )
            ->count();



        $trendBerita = $this->hitungTrend(
            $beritaSekarang,
            $beritaLalu
        );





        // -----------------
        // VISITOR
        // -----------------

        $visitorSekarang = VisitorDaily::whereMonth(
            'visit_date',
            $bulanIni->month
        )
            ->whereYear(
                'visit_date',
                $bulanIni->year
            )
            ->count();



        $visitorLalu = VisitorDaily::whereMonth(
            'visit_date',
            $bulanLalu->month
        )
            ->whereYear(
                'visit_date',
                $bulanLalu->year
            )
            ->count();



        $trendVisitor = $this->hitungTrend(
            $visitorSekarang,
            $visitorLalu
        );






        // -----------------
        // VIDEO
        // -----------------

        $videoSekarang = Video::whereMonth(
            'created_at',
            $bulanIni->month
        )
            ->whereYear(
                'created_at',
                $bulanIni->year
            )
            ->count();



        $videoLalu = Video::whereMonth(
            'created_at',
            $bulanLalu->month
        )
            ->whereYear(
                'created_at',
                $bulanLalu->year
            )
            ->count();



        $trendVideo = $this->hitungTrend(
            $videoSekarang,
            $videoLalu
        );






        // -----------------
        // PPID
        // -----------------

        $ppidSekarang = Ppid::whereMonth(
            'created_at',
            $bulanIni->month
        )
            ->whereYear(
                'created_at',
                $bulanIni->year
            )
            ->count();



        $ppidLalu = Ppid::whereMonth(
            'created_at',
            $bulanLalu->month
        )
            ->whereYear(
                'created_at',
                $bulanLalu->year
            )
            ->count();



        $trendPpid = $this->hitungTrend(
            $ppidSekarang,
            $ppidLalu
        );






        /*
        |--------------------------------------------------------------------------
        | Grafik Visitor 12 Bulan
        |--------------------------------------------------------------------------
        */


        $visitorChart = Visitor::selectRaw("
                DATE_FORMAT(date,'%Y-%m') as periode,
                COUNT(*) as total
            ")
            ->whereBetween('date', [

                Carbon::now()
                    ->subMonths(11)
                    ->startOfMonth(),

                Carbon::now()
                    ->endOfMonth()

            ])
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();



        $bulan = [];

        $jumlahKunjungan = [];



        for ($i = 11; $i >= 0; $i--) {


            $tanggal = Carbon::now()
                ->startOfMonth()
                ->subMonths($i);



            $periode = $tanggal->format('Y-m');



            $bulan[] = $tanggal->format('M Y');



            $data = $visitorChart
                ->where('periode', $periode)
                ->first();



            $jumlahKunjungan[] = $data
                ? $data->total
                : 0;
        }






        /*
        |--------------------------------------------------------------------------
        | Aktivitas Terbaru
        |--------------------------------------------------------------------------
        */


        $aktivitasBerita = Berita::select(
            'judul',
            'created_at',
            'created_by'
        )
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {

                return [

                    'icon' => 'fa-newspaper',

                    'judul' => $item->judul,

                    'user' => $item->created_by,

                    'waktu' => $item->created_at
                        ->diffForHumans()

                ];
            });




        $aktivitasPpid = Ppid::select(
            'judul',
            'created_at',
            'created_by'
        )
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {

                return [

                    'icon' => 'fa-file-arrow-up',

                    'judul' => $item->judul,

                    'user' => $item->created_by,

                    'waktu' => $item->created_at
                        ->diffForHumans()

                ];
            });





        $aktivitasVideo = Video::select(
            'judul',
            'created_at',
            'created_by'
        )
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($item) {

                return [

                    'icon' => 'fa-video',

                    'judul' => $item->judul,

                    'user' => $item->created_by,

                    'waktu' => $item->created_at
                        ->diffForHumans()

                ];
            });





        $aktivitas = collect()

            ->merge($aktivitasBerita)

            ->merge($aktivitasPpid)

            ->merge($aktivitasVideo)

            ->take(4);







        return view(

            'administrator.beranda',

            compact(

                'jumlahBerita',

                'jumlahVisitor',

                'jumlahVideo',

                'jumlahPpid',


                'trendBerita',

                'trendVisitor',

                'trendVideo',

                'trendPpid',


                'bulan',

                'jumlahKunjungan',

                'aktivitas'

            )

        );
    }
}
