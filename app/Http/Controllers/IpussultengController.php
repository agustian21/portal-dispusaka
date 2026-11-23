<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

/**
 * Landing page layanan iPusSulteng.
 * SEO ditetapkan di controller agar metadata konsisten untuk hasil pencarian,
 * pratinjau tautan media sosial, dan data terstruktur.
 */
class IpussultengController extends Controller
{
    public function index(): View
    {
        // Semua tautan eksternal disimpan di satu tempat, bukan diduplikasi dalam Blade.
        $ipusAndroidUrl = 'https://play.google.com/store/apps/details?id=com.eperpus.saas.otomasi123';
        $ipusIosUrl = 'https://smartlib.gramedia.com/download/otomasi123';
        $ipusRegistrationUrl = 'https://tinyurl.com/FormIPusSulteng';
        $ipusGuideUrl = 'https://tinyurl.com/PanduanIPusSulteng';
        $ipusWhatsAppUrl = 'https://wa.me/6282320222290';

        // --------------------------------------------------
        // 1. META SEO DASAR
        // --------------------------------------------------
        $seoTitle = 'iPusSulteng - Perpustakaan Digital Sulawesi Tengah | DISPUSAKA';
        $seoDescription = 'Kenali iPusSulteng, inovasi perpustakaan digital DISPUSAKA Sulawesi Tengah. Unduh aplikasi Android atau iOS, daftar akun, dan nikmati akses bacaan digital.';
        // Canonical URL stabil dan tidak memuat parameter query.
        $seoUrl = route('ipussulteng');
        $seoImage = asset('assets/images/ipussulteng-og.png');

        SEOMeta::setTitle($seoTitle);
        SEOMeta::setDescription($seoDescription);
        SEOMeta::setCanonical($seoUrl);
        SEOMeta::setRobots('index,follow');
        SEOMeta::addMeta('author', 'Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah');
        SEOMeta::addMeta('language', 'id-ID');
        SEOMeta::addKeyword([
            'iPusSulteng',
            'iPus Sulteng',
            'perpustakaan digital Sulawesi Tengah',
            'aplikasi perpustakaan digital Sulteng',
            'download iPusSulteng',
            'daftar akun iPusSulteng',
            'buku digital Sulawesi Tengah',
            'DISPUSAKA Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan Sulteng',
        ]);

        // --------------------------------------------------
        // 2. OPEN GRAPH: WhatsApp, Facebook, LinkedIn
        // --------------------------------------------------
        SEOTools::opengraph()->setTitle($seoTitle);
        SEOTools::opengraph()->setDescription($seoDescription);
        SEOTools::opengraph()->setUrl($seoUrl);
        SEOTools::opengraph()->addProperty('type', 'website');
        SEOTools::opengraph()->addProperty('locale', 'id_ID');
        SEOTools::opengraph()->addProperty('site_name', 'DISPUSAKA Provinsi Sulawesi Tengah');
        SEOTools::opengraph()->addImage($seoImage, [
            'width' => 1200,
            'height' => 630,
            'alt' => 'iPusSulteng - Inovasi Perpustakaan Digital Sulawesi Tengah',
        ]);

        // --------------------------------------------------
        // 3. X (TWITTER) CARD
        // --------------------------------------------------
        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setTitle($seoTitle);
        SEOTools::twitter()->setDescription($seoDescription);
        SEOTools::twitter()->setUrl($seoUrl);
        SEOTools::twitter()->setImage($seoImage);

        // --------------------------------------------------
        // 4. JSON-LD SCHEMA: halaman layanan
        // --------------------------------------------------
        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);

        // Breadcrumb + aplikasi: JSON-LD tambahan di-render aman pada <head>
        // via @stack('styles') yang sudah ada dalam home.layouts.app.
        // Tidak menambahkan rating, harga, atau angka koleksi yang belum diverifikasi.
        $ipusStructuredData = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => $seoUrl . '#breadcrumb',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Beranda',
                            'item' => route('beranda'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'iPusSulteng',
                            'item' => $seoUrl,
                        ],
                    ],
                ],
                [
                    '@type' => 'MobileApplication',
                    '@id' => $seoUrl . '#application',
                    'name' => 'iPusSulteng',
                    'alternateName' => 'I Perpustakaan Sulteng',
                    'description' => 'Layanan aplikasi perpustakaan digital Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah.',
                    'url' => $seoUrl,
                    'applicationCategory' => 'Books & Reference',
                    'operatingSystem' => 'Android, iOS',
                    'downloadUrl' => $ipusAndroidUrl,
                    'image' => $seoImage,
                ],
            ],
        ];

        return view('home.ipussulteng', compact(
            'ipusAndroidUrl',
            'ipusIosUrl',
            'ipusRegistrationUrl',
            'ipusGuideUrl',
            'ipusWhatsAppUrl',
            'ipusStructuredData'
        ));
    }
}
