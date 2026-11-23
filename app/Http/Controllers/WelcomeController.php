<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class WelcomeController extends Controller
{
    public function index()
    {
        $siteName = 'DISPUSAKA Provinsi Sulawesi Tengah';
        $title = 'DISPUSAKA Sulawesi Tengah | Dinas Perpustakaan dan Kearsipan';
        $description = 'Portal resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah. Akses informasi layanan perpustakaan, literasi, kearsipan, dan informasi publik.';
        // Canonical URL menggunakan APP_URL dari .env
        $url = rtrim(config('app.url'), '/') . '/';

        // Gunakan logo yang sudah tersedia
        $image = asset('assets/images/Logo-Sulteng.png');


        // ==========================================
        // SEO META TAGS
        // ==========================================

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);
        SEOMeta::setRobots('index,follow');
        SEOMeta::addMeta(
            'author',
            'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah'
        );
        SEOMeta::setKeywords([
            'DISPUSAKA Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah',
            'Perpustakaan Provinsi Sulawesi Tengah',
            'Layanan Perpustakaan Sulawesi Tengah',
            'Perpustakaan Digital Sulawesi Tengah',
            'Literasi Sulawesi Tengah',
            'Kearsipan Daerah Sulawesi Tengah',
            'Arsip Daerah Sulawesi Tengah',
            'Informasi Perpustakaan Sulawesi Tengah',
            'Berita DISPUSAKA Sulawesi Tengah',
        ]);


        // ==========================================
        // OPEN GRAPH
        // ==========================================
        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl($url);
        OpenGraph::setSiteName($siteName);
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'id_ID');
        OpenGraph::addImage($image);

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
        JsonLd::setSite($siteName);
        JsonLd::addImage($image);
        JsonLd::addValue('inLanguage', 'id-ID');
        JsonLd::addValue('publisher', [
            '@type' => 'GovernmentOrganization',
            'name' => 'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah',
            'url' => $url,
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $image,
            ],
        ]);

        return view('welcome');
    }
}
