<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;

class NewsController extends Controller
{
    public function index(): View
    {

        $berita = Berita::query()
            ->select(['id', 'judul', 'slug_judul', 'tgl', 'gambar', 'description', 'dibaca',])
            ->where('status_id', 1)
            ->orderByDesc('tgl')
            ->orderByDesc('id')
            ->simplePaginate(12)
            ->withQueryString();

        // ==========================================
        // SEO BERITA DISPUSAKA SULTENG
        // ==========================================

        $currentPage = (int) $berita->currentPage();

        $seoTitle = 'Berita DISPUSAKA Sulawesi Tengah | Kegiatan & Informasi Resmi';

        if ($currentPage > 1) {
            $seoTitle .= ' - Halaman ' . $currentPage;
        }

        $seoDescription = 'Baca berita terbaru DISPUSAKA Provinsi Sulawesi Tengah mengenai kegiatan instansi, gerakan literasi, layanan perpustakaan, pengelolaan kearsipan, dan informasi pelayanan publik.';

        $seoUrl = request()->url();

        if ($currentPage > 1) {
            $seoUrl .= '?page=' . $currentPage;
        }

        // Ambil berita pertama pada halaman aktif
        $firstNews = $berita->getCollection()->first();

        // Gambar SEO otomatis dari berita pertama
        $seoImage = ($firstNews && $firstNews->gambar)
            ? asset('uploads_files/berita/' . $firstNews->gambar)
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
            'Berita DISPUSAKA Sulawesi Tengah',
            'Berita DISPUSAKA Sulteng',
            'Berita Perpustakaan Sulawesi Tengah',
            'Berita Kearsipan Sulawesi Tengah',
            'Kegiatan DISPUSAKA',
            'Informasi DISPUSAKA Sulteng',
            'Berita literasi Sulawesi Tengah',
            'Kegiatan perpustakaan daerah',
            'Kegiatan kearsipan daerah',
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

        return view('home.berita.index', compact('berita'));
    }

    public function show(string $slug_judul): View
    {


        $berita = Berita::query()
            ->where('slug_judul', $slug_judul)
            ->where('status_id', 1)
            ->firstOrFail();

        // ==========================================
        // SEO DETAIL BERITA
        // ==========================================

        $articleTitle = $berita->judul . ' | DISPUSAKA Sulawesi Tengah';

        $articleContent = trim(
            preg_replace(
                '/\s+/',
                ' ',
                strip_tags((string) ($berita->description ?? ''))
            )
        );

        $articleDescription = $articleContent !== ''
            ? \Illuminate\Support\Str::limit($articleContent, 155, '...')
            : 'Baca informasi dan berita resmi DISPUSAKA Provinsi Sulawesi Tengah: ' . $berita->judul;

        $articleUrl = route(
            'berita-dispusaka.show',
            $berita->slug_judul
        );

        $articleImage = $berita->gambar
            ? asset('uploads_files/berita/' . $berita->gambar)
            : asset('assets/images/Logo-Sulteng.png');


        // BASIC SEO

        SEOMeta::setTitle($articleTitle);
        SEOMeta::setDescription($articleDescription);
        SEOMeta::setCanonical($articleUrl);
        SEOMeta::setRobots('index,follow');

        SEOMeta::addKeyword([
            $berita->judul,
            'Berita DISPUSAKA',
            'DISPUSAKA Sulawesi Tengah',
            'Berita perpustakaan Sulteng',
            'Berita kearsipan Sulteng'
        ]);


        // OPEN GRAPH

        SEOTools::opengraph()->setTitle($articleTitle);
        SEOTools::opengraph()->setDescription($articleDescription);
        SEOTools::opengraph()->setUrl($articleUrl);

        SEOTools::opengraph()->addProperty(
            'type',
            'article'
        );

        SEOTools::opengraph()->addProperty(
            'locale',
            'id_ID'
        );

        SEOTools::opengraph()->addProperty(
            'site_name',
            'DISPUSAKA Provinsi Sulawesi Tengah'
        );

        if ($berita->tgl) {
            SEOTools::opengraph()->addProperty(
                'article:published_time',
                $berita->tgl->toIso8601String()
            );
        }

        SEOTools::opengraph()->addImage($articleImage);


        // TWITTER CARD

        SEOTools::twitter()->setType('summary_large_image');
        SEOTools::twitter()->setTitle($articleTitle);
        SEOTools::twitter()->setDescription($articleDescription);
        SEOTools::twitter()->setUrl($articleUrl);
        SEOTools::twitter()->setImage($articleImage);


        // JSON-LD

        SEOTools::jsonLd()->setType('NewsArticle');
        SEOTools::jsonLd()->setTitle($articleTitle);
        SEOTools::jsonLd()->setDescription($articleDescription);
        SEOTools::jsonLd()->setUrl($articleUrl);
        SEOTools::jsonLd()->addImage($articleImage);

        /*
         * Cegah penambahan view berulang dalam session yang sama.
         */
        $sessionKey = 'berita_viewed_' . $berita->id;

        if (! session()->has($sessionKey)) {
            $berita->increment('dibaca');
            session()->put($sessionKey, true);

            /*
             * Pastikan nilai dibaca yang tampil adalah nilai terbaru.
             */
            $berita->refresh();
        }

        /*
         * Berita sebelumnya berarti berita yang lebih lama.
         */
        $beritaSebelumnya = Berita::query()
            ->select(['id', 'judul', 'slug_judul', 'tgl', 'gambar',])
            ->where('status_id', 1)
            ->where(function (Builder $query) use ($berita) {
                $query
                    ->where('tgl', '<', $berita->tgl)
                    ->orWhere(function (Builder $query) use ($berita) {
                        $query
                            ->where('tgl', $berita->tgl)
                            ->where('id', '<', $berita->id);
                    });
            })
            ->orderByDesc('tgl')
            ->orderByDesc('id')
            ->first();

        /*
         * Berita selanjutnya berarti berita yang lebih baru.
         */
        $beritaSelanjutnya = Berita::query()
            ->select(['id', 'judul', 'slug_judul', 'tgl', 'gambar',])
            ->where('status_id', 1)
            ->where(function (Builder $query) use ($berita) {
                $query
                    ->where('tgl', '>', $berita->tgl)
                    ->orWhere(function (Builder $query) use ($berita) {
                        $query
                            ->where('tgl', $berita->tgl)
                            ->where('id', '>', $berita->id);
                    });
            })
            ->orderBy('tgl')
            ->orderBy('id')
            ->first();

        /*
         * Artikel lain untuk mempertahankan eksplorasi pengunjung.
         */
        $beritaLainnya = Berita::query()
            ->select(['id', 'judul', 'slug_judul', 'tgl', 'gambar', 'dibaca',])
            ->where('status_id', 1)
            ->where('id', '!=', $berita->id)
            ->orderByDesc('tgl')
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        return view('home.berita.show', compact(
            'berita',
            'beritaSebelumnya',
            'beritaSelanjutnya',
            'beritaLainnya'
        ));
    }
}
