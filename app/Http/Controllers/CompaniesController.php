<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

// use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(): View
    {
        $seoTitle = 'Visi dan Misi DISPUSAKA Sulawesi Tengah | Profil Instansi';

        $seoDescription = 'Informasi visi Gubernur dan Wakil Gubernur Sulawesi Tengah serta misi dan arah strategis organisasi dalam penyelenggaraan layanan perpustakaan, kearsipan, dan pelayanan publik.';

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
            'Visi dan Misi DISPUSAKA Sulawesi Tengah',
            'Visi DISPUSAKA Sulteng',
            'Misi DISPUSAKA Sulteng',
            'Visi Misi Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan',
            'Profil DISPUSAKA Sulawesi Tengah',
            'Tujuan organisasi DISPUSAKA',
            'Strategi DISPUSAKA Sulteng',
            'Perpustakaan Sulawesi Tengah',
            'Kearsipan Sulawesi Tengah',
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

        $data = Company::query()->first();
        return view('home.company', compact('data'));
    }
}
