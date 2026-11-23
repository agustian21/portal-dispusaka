<button type="button" class="a11y-fab" data-a11y-launcher aria-controls="accessibilityPanel" aria-expanded="false"
    aria-label="Buka Menu Aksesibilitas" title="Menu Aksesibilitas">
    <i class="fa-solid fa-universal-access" aria-hidden="true"></i>
</button>

<aside id="accessibilityPanel" class="a11y-panel" data-a11y-panel aria-labelledby="accessibilityTitle" hidden>
    <header class="a11y-panel__header">
        <div class="a11y-panel__brand" aria-hidden="true">
            <i class="fa-solid fa-universal-access"></i>
        </div>

        <div class="a11y-panel__heading">
            <span class="a11y-panel__eyebrow">Aksesibilitas</span>
            <h2 class="a11y-panel__title" id="accessibilityTitle">
                Menu Aksesibilitas
            </h2>
        </div>

        <button type="button" class="a11y-close" data-a11y-close aria-label="Tutup Menu Aksesibilitas">
            <i class="fa-solid fa-xmark" aria-hidden="true"></i>
        </button>
    </header>

    <p class="a11y-panel__intro">
        Sesuaikan tampilan, navigasi, dan pembacaan suara sesuai kebutuhan Anda.
        Pengaturan disimpan di perangkat ini.
    </p>

    <div class="a11y-panel__body">
        {{-- Tampilan --}}
        <section class="a11y-section" aria-labelledby="a11yVisionTitle">
            <div class="a11y-section__head">
                <span class="a11y-section__icon" aria-hidden="true">
                    <i class="fa-solid fa-eye"></i>
                </span>
                <div>
                    <h3 id="a11yVisionTitle">Tampilan & keterbacaan</h3>
                    <p>Atur teks dan kontras tanpa mengubah isi halaman.</p>
                </div>
            </div>

            <div class="a11y-segmented" role="group" aria-label="Ukuran teks">
                <button type="button" class="a11y-segmented__button" data-a11y-text="normal" aria-pressed="true">
                    A Normal
                </button>

                <button type="button" class="a11y-segmented__button" data-a11y-text="large" aria-pressed="false">
                    A Besar
                </button>

                <button type="button" class="a11y-segmented__button" data-a11y-text="xlarge" aria-pressed="false">
                    A+ Sangat Besar
                </button>
            </div>

            <div class="a11y-grid">
                <button type="button" class="a11y-toggle" data-a11y-toggle="contrast" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-circle-half-stroke"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Kontras tinggi</strong>
                        <small>Pertegas teks dan latar.</small>
                    </span>
                </button>

                <button type="button" class="a11y-toggle" data-a11y-toggle="links" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-link"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Garis bawah tautan</strong>
                        <small>Bedakan link dengan lebih jelas.</small>
                    </span>
                </button>

                <button type="button" class="a11y-toggle" data-a11y-toggle="font" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-font"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Font sederhana</strong>
                        <small>Gunakan font sistem yang familiar.</small>
                    </span>
                </button>

                <button type="button" class="a11y-toggle" data-a11y-toggle="grayscale" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-droplet-slash"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Monokrom</strong>
                        <small>Kurangi ketergantungan pada warna.</small>
                    </span>
                </button>
            </div>
        </section>

        {{-- Navigasi --}}
        <section class="a11y-section" aria-labelledby="a11yNavigationTitle">
            <div class="a11y-section__head">
                <span class="a11y-section__icon" aria-hidden="true">
                    <i class="fa-solid fa-keyboard"></i>
                </span>
                <div>
                    <h3 id="a11yNavigationTitle">Navigasi & gerakan</h3>
                    <p>Membantu penggunaan keyboard dan sensitivitas gerakan.</p>
                </div>
            </div>

            <div class="a11y-grid">
                <button type="button" class="a11y-toggle" data-a11y-toggle="focus" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-crosshairs"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Sorotan fokus</strong>
                        <small>Perjelas posisi saat memakai keyboard.</small>
                    </span>
                </button>

                <button type="button" class="a11y-toggle" data-a11y-toggle="motion" aria-pressed="false">
                    <span class="a11y-toggle__icon" aria-hidden="true">
                        <i class="fa-solid fa-person-walking-arrow-loop-left"></i>
                    </span>
                    <span class="a11y-toggle__copy">
                        <strong>Kurangi gerakan</strong>
                        <small>Batasi animasi dan transisi.</small>
                    </span>
                </button>
            </div>
        </section>

        {{-- Suara --}}
        <section class="a11y-section" aria-labelledby="a11yAudioTitle">
            <div class="a11y-section__head">
                <span class="a11y-section__icon" aria-hidden="true">
                    <i class="fa-solid fa-volume-high"></i>
                </span>
                <div>
                    <h3 id="a11yAudioTitle">Bacakan halaman</h3>
                    <p>Gunakan suara perangkat untuk membaca isi utama halaman.</p>
                </div>
            </div>

            <div class="a11y-audio">
                <div class="a11y-audio__top">
                    <span class="a11y-audio__icon" aria-hidden="true">
                        <i class="fa-solid fa-headphones"></i>
                    </span>
                    <span class="a11y-audio__copy">
                        <strong>Pembaca teks</strong>
                        <small>
                            Jika Anda menyeleksi teks, hanya teks tersebut yang dibacakan.
                        </small>
                    </span>
                </div>

                <div class="a11y-audio__actions" role="group" aria-label="Kontrol pembacaan suara">
                    <button type="button" class="a11y-audio__button a11y-audio__button--primary"
                        data-a11y-speech="read">
                        <i class="fa-solid fa-play" aria-hidden="true"></i>
                        <span>Bacakan</span>
                    </button>

                    <button type="button" class="a11y-audio__button" data-a11y-speech="pause" disabled>
                        <i class="fa-solid fa-pause" aria-hidden="true"></i>
                        <span>Jeda</span>
                    </button>

                    <button type="button" class="a11y-audio__button" data-a11y-speech="stop" disabled>
                        <i class="fa-solid fa-stop" aria-hidden="true"></i>
                        <span>Stop</span>
                    </button>
                </div>

                <div class="a11y-audio__settings">
                    <label for="a11ySpeechRate">Kecepatan suara</label>
                    <select id="a11ySpeechRate" data-a11y-rate>
                        <option value="0.8">0,8× Lambat</option>
                        <option value="1" selected>1× Normal</option>
                        <option value="1.2">1,2× Cepat</option>
                        <option value="1.4">1,4× Lebih cepat</option>
                    </select>
                </div>

                <p class="a11y-audio__notice" data-a11y-speech-notice>
                    Suara menggunakan Web Speech API dan suara Bahasa Indonesia
                    yang tersedia pada browser/perangkat. Fitur ini bukan pengganti
                    NVDA, JAWS, VoiceOver, atau TalkBack.
                </p>
            </div>
        </section>
    </div>

    <footer class="a11y-panel__footer">
        <button type="button" class="a11y-reset" data-a11y-reset>
            <i class="fa-solid fa-rotate-left" aria-hidden="true"></i>
            Reset semua pengaturan
        </button>

        <p class="a11y-status" data-a11y-status role="status" aria-live="polite" aria-atomic="true"></p>
    </footer>
</aside>