<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pamflet;
use App\Models\Pejabat;
use App\Models\Slider;
use App\Models\Video;
use App\Models\VisitorDaily;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

// use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $title = 'DISPUSAKA Sulawesi Tengah | Perpustakaan & Kearsipan';

        $description = 'Portal resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah. Temukan layanan OPAC, keanggotaan perpustakaan, literasi, berita, informasi, dan layanan kearsipan.';

        $url = url('/');

        $image = asset('images/logo-dispusaka.png');

        // ==========================================
        // BASIC SEO
        // ==========================================

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);
        SEOMeta::setRobots('index,follow');

        SEOMeta::addMeta(
            'author',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        SEOMeta::setKeywords([
            'DISPUSAKA Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan Sulawesi Tengah',
            'Perpustakaan Sulawesi Tengah',
            'Kearsipan Sulawesi Tengah',
            'OPAC Sulteng',
            'Perpustakaan Digital Sulteng',
            'Literasi Sulawesi Tengah',
            'Layanan Perpustakaan',
            'Arsip Daerah Sulawesi Tengah',
            'Berita DISPUSAKA'
        ]);

        // ==========================================
        // OPEN GRAPH
        // ==========================================

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($url);
        OpenGraph::setSiteName(
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');

        if ($image) {
            OpenGraph::addImage($image);
        }

        // ==========================================
        // TWITTER CARD
        // ==========================================

        TwitterCard::setType(
            $image ? 'summary_large_image' : 'summary'
        );

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl($url);

        if ($image) {
            TwitterCard::setImage($image);
        }

        // ==========================================
        // JSON-LD STRUCTURED DATA
        // ==========================================

        JsonLd::setType('WebSite');
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::setUrl($url);

        JsonLd::setSite(
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        if ($image) {
            JsonLd::addImage($image);
        }

        //slider
        $sliders = Slider::query()
            ->where('status_id', 1)
            ->select(['nm_slide', 'gambar'])
            ->get();

        // Data Berita terbaru
        $beritas = Berita::query()
            ->where('status_id', 1)
            ->select(['judul', 'slug_judul', 'tgl', 'isi', 'gambar', 'description', 'dibaca',])
            ->orderByDesc('tgl')
            ->limit(9)
            ->get();

        //video
        $videos = Video::query()
            ->where('status_id', 1)
            ->select(['linkvideo', 'judul', 'tglupload'])
            ->orderByDesc('tglupload')
            ->limit(4)
            ->get();

        //Pamflet
        $pamflets = Pamflet::query()
            ->where('status_id', 1)
            ->select(['nm_pamflet', 'slug_pamflet', 'gambar', 'created_at'])
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        // Pejabat
        $pejabats = Pejabat::query()
            ->where('status_id', 1)
            ->with('namabidang')
            ->get();


        // Kelompok pejabat
        $kepalaDinas = $pejabats->filter(function ($item) {
            return stripos($item->jabatan, 'Kepala Dinas') !== false;
        });


        $sekretaris = $pejabats->filter(function ($item) {
            return stripos($item->jabatan, 'Sekretaris') !== false;
        });


        $kepalaBidang = $pejabats->filter(function ($item) {
            return stripos($item->jabatan, 'Kepala Bidang') !== false;
        });


        $kasubag = $pejabats->filter(function ($item) {
            return stripos($item->jabatan, 'Kepala Sub.Bagian') !== false;
        });

        $today = today();
        $currentIp = request()->ip();

        // Total pengunjung hari ini
        $totalVisitorsToday = VisitorDaily::whereDate(
            'visit_date',
            $today
        )->count();

        // Total IP unik sepanjang waktu
        $totalVisitorsAllTime = VisitorDaily::count();

        // Antisipasi pengunjung yang belum dicatat middleware
        if ($currentIp) {

            $alreadyVisitedToday = VisitorDaily::where(
                'ip_address',
                $currentIp
            )->whereDate('visit_date', $today)->exists();

            if (!$alreadyVisitedToday) {
                $totalVisitorsToday++;
            }

            $alreadyVisitedEver = VisitorDaily::where(
                'ip_address',
                $currentIp
            )->exists();

            if (!$alreadyVisitedEver) {
                $totalVisitorsAllTime++;
            }
        }

        return view('home.home', compact('sliders', 'beritas', 'videos', 'pamflets', 'kepalaDinas', 'sekretaris', 'kepalaBidang', 'kasubag', 'totalVisitorsToday', 'totalVisitorsAllTime'));
    }
}
