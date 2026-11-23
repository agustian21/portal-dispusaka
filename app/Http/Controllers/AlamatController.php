<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\View\View;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Str;

class AlamatController extends Controller
{
    /**
     * Menampilkan informasi alamat instansi.
     */
    public function index(): View
    {
        // ==========================================
        // AMBIL DATA ALAMAT INSTANSI
        // ==========================================

        $alamat = Alamat::query()
            ->select(['nama', 'singkatan', 'alamat', 'email', 'telepon', 'link_maps', 'facebook', 'instagram', 'updated_at',])
            ->first();


        // ==========================================
        // KONTAK DAN LINK EKSTERNAL
        // ==========================================

        $contactLinks = [
            'maps' => $this->safeHttpUrl($alamat?->link_maps),
            'facebook' => $this->safeHttpUrl($alamat?->facebook),
            'instagram' => $this->safeHttpUrl($alamat?->instagram),
            'email' => $this->emailLink($alamat?->email),
            'phone' => $this->phoneLink($alamat?->telepon),
        ];


        // ==========================================
        // SEO ALAMAT DISPUSAKA SULTENG
        // ==========================================

        $seoTitle = 'Alamat dan Kontak DISPUSAKA Sulawesi Tengah | Lokasi Kantor';

        // Ambil informasi instansi dari database
        $namaInstansi = trim(strip_tags(
            (string) ($alamat?->nama ?? '')
        ));

        $singkatan = trim(strip_tags(
            (string) ($alamat?->singkatan ?? '')
        ));

        $alamatInstansi = trim(strip_tags(
            (string) ($alamat?->alamat ?? '')
        ));

        // Susun deskripsi SEO dinamis
        $seoContent = collect([
            $namaInstansi,
            $singkatan,
            $alamatInstansi,
        ])
            ->filter()
            ->implode(' ');

        $seoDescription = $seoContent !== ''
            ? Str::limit(
                'Temukan alamat dan informasi kontak '
                    . $seoContent
                    . '. Lihat lokasi kantor, email, telepon, dan media sosial resmi DISPUSAKA.',
                155,
                '...'
            )
            : 'Temukan alamat kantor, lokasi, email, nomor telepon, dan informasi kontak resmi Dinas Perpustakaan dan Kearsipan Provinsi Sulawesi Tengah.';

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
            'Alamat DISPUSAKA Sulawesi Tengah',
            'Kontak DISPUSAKA Sulteng',
            'Lokasi Kantor DISPUSAKA',
            'Alamat Dinas Perpustakaan Sulawesi Tengah',
            'Alamat Dinas Kearsipan Sulteng',
            'Email DISPUSAKA Sulawesi Tengah',
            'Nomor Telepon DISPUSAKA',
            'Kontak Dinas Perpustakaan dan Kearsipan',
            'Lokasi Perpustakaan Provinsi Sulawesi Tengah',
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

        SEOTools::jsonLd()->setType('WebPage');
        SEOTools::jsonLd()->setTitle($seoTitle);
        SEOTools::jsonLd()->setDescription($seoDescription);
        SEOTools::jsonLd()->setUrl($seoUrl);
        SEOTools::jsonLd()->addImage($seoImage);


        // ==========================================
        // RETURN VIEW
        // ==========================================

        return view('home.ppid.alamat', [
            'alamat' => $alamat,
            'contactLinks' => $contactLinks,
        ]);
    }

    /**
     * Hanya mengizinkan URL http atau https.
     */
    private function safeHttpUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return in_array($scheme, ['http', 'https'], true)
            ? $url
            : null;
    }

    /**
     * Membuat link mailto jika alamat email valid.
     */
    private function emailLink(?string $email): ?string
    {
        if (blank($email)) {
            return null;
        }

        $email = trim($email);

        return filter_var($email, FILTER_VALIDATE_EMAIL)
            ? 'mailto:' . $email
            : null;
    }

    /**
     * Membuat link tel dari nomor telepon.
     */
    private function phoneLink(?string $phone): ?string
    {
        if (blank($phone)) {
            return null;
        }

        $normalized = preg_replace('/[^\d+]/', '', trim($phone));

        if (blank($normalized) || $normalized === '+') {
            return null;
        }

        return 'tel:' . $normalized;
    }
}
