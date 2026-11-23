<?php

namespace App\Http\Controllers;

use App\Models\Faqlayanan;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class FaqdispusakaController extends Controller
{
    /**
     * Menampilkan FAQ layanan publik.
     */
    public function index(): View
    {
        // ==========================================
        // AMBIL DATA FAQ
        // ==========================================

        $faqs = Faqlayanan::query()
            ->aktif()
            ->select(['id', 'judul', 'isi'])
            ->orderBy('id', 'ASC')
            ->get();


        // ==========================================
        // SEO FAQ DISPUSAKA SULTENG
        // ==========================================

        $seoTitle = 'FAQ DISPUSAKA Sulawesi Tengah | Pertanyaan dan Informasi Layanan';

        $seoDescription = 'Temukan jawaban atas pertanyaan umum mengenai layanan DISPUSAKA Provinsi Sulawesi Tengah, informasi perpustakaan, keanggotaan, literasi, kearsipan, dan pelayanan publik.';

        $seoUrl = request()->url();

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
            'FAQ DISPUSAKA Sulawesi Tengah',
            'FAQ DISPUSAKA Sulteng',
            'Pertanyaan DISPUSAKA',
            'Informasi layanan DISPUSAKA',
            'Pertanyaan layanan perpustakaan',
            'Informasi perpustakaan Sulawesi Tengah',
            'Layanan kearsipan Sulteng',
            'Informasi keanggotaan perpustakaan',
            'Pelayanan publik Sulawesi Tengah',
            'Dinas Perpustakaan dan Kearsipan Sulteng'
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
        // JSON-LD FAQ STRUCTURED DATA
        // ==========================================

        $faqEntities = $faqs
            ->map(function ($faq) {
                $question = trim(
                    html_entity_decode(
                        strip_tags((string) $faq->judul),
                        ENT_QUOTES | ENT_HTML5,
                        'UTF-8'
                    )
                );

                $answer = trim(
                    html_entity_decode(
                        strip_tags((string) $faq->isi),
                        ENT_QUOTES | ENT_HTML5,
                        'UTF-8'
                    )
                );

                if ($question === '' || $answer === '') {
                    return null;
                }

                return [
                    '@type' => 'Question',
                    'name' => $question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $answer,
                    ],
                ];
            })
            ->filter()
            ->values()
            ->all();

        SEOTools::jsonLd()->setType(
            !empty($faqEntities) ? 'FAQPage' : 'WebPage'
        );

        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);

        if (!empty($faqEntities)) {
            SEOTools::jsonLd()->addValue(
                'mainEntity',
                $faqEntities
            );
        }


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('home.faq', [
            'faqs' => $faqs,
        ]);
    }
}
