<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class MultimediaController extends Controller
{
    public function index(): View
    {
        $video = Video::query()
            ->select(['linkvideo', 'judul', 'tglupload', 'status_id',])
            ->where('status_id', 1)
            ->orderByDesc('id')
            ->simplePaginate(9)
            ->withQueryString()
            ->fragment('koleksi-video');

        // ==========================================
        // SEO MULTIMEDIA DISPUSAKA SULTENG
        // ==========================================

        $currentPage = (int) $video->currentPage();

        $seoTitle = 'Video Kegiatan DISPUSAKA Sulawesi Tengah | Dokumentasi Resmi';

        if ($currentPage > 1) {
            $seoTitle .= ' - Halaman ' . $currentPage;
        }

        $seoDescription = 'Tonton dokumentasi video kegiatan DISPUSAKA Provinsi Sulawesi Tengah, meliputi aktivitas perpustakaan, gerakan literasi, pengelolaan kearsipan, dan berbagai kegiatan pelayanan publik.';

        $seoUrl = request()->url();

        // Canonical mengikuti halaman pagination
        if ($currentPage > 1) {
            $seoUrl .= '?page=' . $currentPage;
        }


        // ==========================================
        // GAMBAR SEO DARI VIDEO YOUTUBE
        // ==========================================

        $firstVideo = $video->getCollection()->first();

        $youtubeId = null;

        if ($firstVideo && $firstVideo->linkvideo) {
            preg_match(
                '/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([^&?\/]+)/',
                $firstVideo->linkvideo,
                $matches
            );

            $youtubeId = $matches[1] ?? null;
        }

        $seoImage = $youtubeId
            ? 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg'
            : asset('assets/images/Logo-Sulteng.png');


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
            'Video DISPUSAKA Sulawesi Tengah',
            'Video Kegiatan DISPUSAKA',
            'Multimedia DISPUSAKA Sulteng',
            'Dokumentasi Kegiatan DISPUSAKA',
            'Video Perpustakaan Sulawesi Tengah',
            'Video Kearsipan Sulawesi Tengah',
            'Video Literasi Sulteng',
            'Dokumentasi Perpustakaan Daerah',
            'Dokumentasi Kegiatan Pemerintah',
            'Dinas Perpustakaan dan Kearsipan Sulteng',
            'Informasi Pemerintah Provinsi Sulawesi Tengah'
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

        SEOTools::twitter()->setType('summary_large_image');
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

        return view('home.multimedia', compact('video'));
    }
}
