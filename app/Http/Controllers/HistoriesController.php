<?php

namespace App\Http\Controllers;

use App\Models\History;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
// use Illuminate\Http\Request;

class HistoriesController extends Controller
{
    public function index()
    {
        $seoTitle = 'Sejarah DISPUSAKA Sulawesi Tengah | Profil Instansi';

        $seoDescription = 'Kenali sejarah dan perjalanan Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah, profil kelembagaan, bidang perpustakaan, serta pengelolaan kearsipan daerah.';

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
            'Sejarah DISPUSAKA Sulawesi Tengah',
            'Sejarah Dinas Perpustakaan Sulawesi Tengah',
            'Sejarah Dinas Kearsipan Sulteng',
            'Profil DISPUSAKA Sulteng',
            'Dinas Perpustakaan dan Kearsipan',
            'Perpustakaan Provinsi Sulawesi Tengah',
            'Kearsipan Provinsi Sulawesi Tengah',
            'Profil instansi pemerintah Sulteng',
            'Organisasi DISPUSAKA',
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

        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);

        // ==========================================
        // JSON-LD STRUCTURED DATA
        // ==========================================

        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);

        $history = History::latest()->first();

        $historyParagraphs = [];

        if ($history && $history->sejarah_instansi) {
            $historyParagraphs = preg_split(
                "/\r\n|\n|\r/",
                trim($history->sejarah_instansi)
            );
        }

        return view('home.sejarah_instansi', compact('history', 'historyParagraphs'));
    }
}
