<?php

namespace App\Http\Controllers;

use App\Models\Katppid;
use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class InformasipublikController extends Controller
{
    public function index(): View
    {
        // ==========================================
        // AMBIL DATA INFORMASI PUBLIK
        // ==========================================

        $kategoriPpids = Katppid::query()
            ->select(['id', 'nm_ppid'])
            ->with(['ppids' => function ($query): void {
                $query
                    ->select([
                        'id',
                        'katppid_id',
                        'judul',
                        'file',
                        'tahun'
                    ])
                    ->where('status_id', 1)
                    ->orderBy('id', 'desc');
            }])
            ->orderBy('id', 'asc')
            ->get();

        $totalDokumen = $kategoriPpids->sum(
            fn(Katppid $kategori): int => $kategori->ppids->count()
        );

        $totalKategori = $kategoriPpids->count();

        $lastUpdate = $kategoriPpids
            ->flatMap(fn(Katppid $kategori) => $kategori->ppids)
            ->pluck('tahun')
            ->filter()
            ->max();


        // ==========================================
        // SEO INFORMASI PUBLIK DISPUSAKA SULTENG
        // ==========================================

        $seoTitle = 'Informasi Publik DISPUSAKA Sulawesi Tengah | Dokumen PPID';

        $seoDescription = 'Akses informasi publik DISPUSAKA Provinsi Sulawesi Tengah melalui dokumen PPID yang dikelompokkan berdasarkan kategori. Temukan dokumen resmi, informasi kelembagaan, dan arsip publik.';

        $seoUrl = url()->current();

        $seoImage = asset('assets/images/Logo-Sulteng.png');


        // ==========================================
        // BASIC SEO
        // ==========================================

        SEOMeta::setTitle($seoTitle);
        SEOMeta::setDescription($seoDescription);
        SEOMeta::setCanonical($seoUrl);
        SEOMeta::setRobots('index,follow');

        SEOMeta::addMeta(
            'author',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        SEOMeta::addKeyword([
            'Informasi Publik DISPUSAKA Sulawesi Tengah',
            'Informasi Publik DISPUSAKA Sulteng',
            'PPID DISPUSAKA Sulawesi Tengah',
            'Dokumen PPID Sulteng',
            'Keterbukaan Informasi Publik',
            'Informasi Publik Pemerintah Daerah',
            'Dokumen Resmi DISPUSAKA',
            'Arsip Informasi Publik',
            'Transparansi Informasi Pemerintah',
            'Dokumen Dinas Perpustakaan dan Kearsipan',
            'Pemerintah Provinsi Sulawesi Tengah'
        ]);


        // ==========================================
        // OPEN GRAPH
        // ==========================================

        SEOTools::opengraph()->setTitle($seoTitle);
        SEOTools::opengraph()->setDescription($seoDescription);
        SEOTools::opengraph()->setUrl($seoUrl);

        SEOTools::opengraph()->addProperty(
            'type',
            'website'
        );

        SEOTools::opengraph()->addProperty(
            'locale',
            'id_ID'
        );

        SEOTools::opengraph()->addProperty(
            'site_name',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        SEOTools::opengraph()->addImage($seoImage);


        // ==========================================
        // TWITTER CARD
        // ==========================================

        SEOTools::twitter()->setType('summary');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);


        // ==========================================
        // JSON-LD STRUCTURED DATA
        // ==========================================

        SEOTools::jsonLd()->setType('CollectionPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('home.publik', compact(
            'kategoriPpids',
            'totalDokumen',
            'totalKategori',
            'lastUpdate'
        ));
    }
}
