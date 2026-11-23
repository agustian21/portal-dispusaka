(() => {
    "use strict";

    const STORAGE_KEY = "dispusaka:a11y:v2";

    const DEFAULTS = {
        text: "normal",
        contrast: false,
        links: false,
        font: false,
        motion: false,
        focus: false,
        grayscale: false,
        rate: 1,
    };

    const root = document.documentElement;
    const launcher = document.querySelector("[data-a11y-launcher]");
    const panel = document.querySelector("[data-a11y-panel]");
    const closeButton = document.querySelector("[data-a11y-close]");
    const resetButton = document.querySelector("[data-a11y-reset]");
    const liveStatus = document.querySelector("[data-a11y-status]");

    if (!launcher || !panel) return;

    let state = loadState();
    let lastFocusedElement = null;

    /* ----------------------------------------------------------------------
       Speech synthesis state
       ---------------------------------------------------------------------- */
    const speechSupported =
        "speechSynthesis" in window && "SpeechSynthesisUtterance" in window;

    const synth = speechSupported ? window.speechSynthesis : null;
    const readButton = panel.querySelector('[data-a11y-speech="read"]');
    const pauseButton = panel.querySelector('[data-a11y-speech="pause"]');
    const stopButton = panel.querySelector('[data-a11y-speech="stop"]');
    const rateSelect = panel.querySelector("[data-a11y-rate]");
    const speechNotice = panel.querySelector("[data-a11y-speech-notice]");

    let speechChunks = [];
    let speechIndex = 0;
    let isReading = false;
    let isPaused = false;
    let preferredVoice = null;

    init();

    function init() {
        applyState();
        bindPanel();
        bindControls();
        initSpeech();
        syncUI();
    }

    /* ----------------------------------------------------------------------
       Storage
       ---------------------------------------------------------------------- */
    function loadState() {
        try {
            const saved = JSON.parse(localStorage.getItem(STORAGE_KEY) || "{}");
            return { ...DEFAULTS, ...saved };
        } catch {
            return { ...DEFAULTS };
        }
    }

    function saveState() {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
        } catch {
            // Website tetap bekerja ketika storage diblokir browser.
        }
    }

    /* ----------------------------------------------------------------------
       Panel
       ---------------------------------------------------------------------- */
    function bindPanel() {
        launcher.addEventListener("click", togglePanel);

        closeButton?.addEventListener("click", closePanel);

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && !panel.hidden) {
                closePanel();
            }
        });

        // Klik di luar menutup panel, tetapi perubahan preferensi tetap tersimpan.
        document.addEventListener("pointerdown", (event) => {
            if (
                panel.hidden ||
                panel.contains(event.target) ||
                launcher.contains(event.target)
            ) {
                return;
            }

            closePanel({ restoreFocus: false });
        });
    }

    function togglePanel() {
        panel.hidden ? openPanel() : closePanel();
    }

    function openPanel() {
        lastFocusedElement = document.activeElement;

        panel.hidden = false;
        launcher.setAttribute("aria-expanded", "true");

        const firstControl = panel.querySelector(
            "button:not(:disabled), select:not(:disabled), input:not(:disabled)",
        );

        window.requestAnimationFrame(() => firstControl?.focus());
    }

    function closePanel(options = { restoreFocus: true }) {
        panel.hidden = true;
        launcher.setAttribute("aria-expanded", "false");

        if (options.restoreFocus !== false) {
            const focusTarget =
                lastFocusedElement instanceof HTMLElement
                    ? lastFocusedElement
                    : launcher;

            focusTarget.focus();
        }
    }

    /* ----------------------------------------------------------------------
       Preference controls
       ---------------------------------------------------------------------- */
    function bindControls() {
        panel.querySelectorAll("[data-a11y-text]").forEach((button) => {
            button.addEventListener("click", () => {
                state.text = button.dataset.a11yText || "normal";
                commit("Ukuran teks diperbarui.");
            });
        });

        panel.querySelectorAll("[data-a11y-toggle]").forEach((button) => {
            button.addEventListener("click", () => {
                const key = button.dataset.a11yToggle;

                if (!Object.prototype.hasOwnProperty.call(state, key)) return;

                state[key] = !state[key];

                const labels = {
                    contrast: "Kontras tinggi",
                    links: "Garis bawah tautan",
                    font: "Font mudah dibaca",
                    motion: "Kurangi gerakan",
                    focus: "Sorotan fokus",
                    grayscale: "Mode monokrom",
                };

                commit(
                    `${labels[key] || "Pengaturan"} ${state[key] ? "diaktifkan" : "dinonaktifkan"}.`,
                );
            });
        });

        resetButton?.addEventListener("click", () => {
            stopSpeech();

            state = { ...DEFAULTS };
            commit("Semua pengaturan aksesibilitas dikembalikan ke awal.");

            if (rateSelect) rateSelect.value = String(DEFAULTS.rate);
        });

        rateSelect?.addEventListener("change", () => {
            const rate = Number(rateSelect.value);
            state.rate = Number.isFinite(rate) ? rate : 1;
            saveState();
            announce(`Kecepatan suara ${state.rate} kali.`);
        });
    }

    function commit(message) {
        applyState();
        saveState();
        syncUI();
        announce(message);
    }

    function applyState() {
        root.dataset.a11yText = state.text;
        root.dataset.a11yContrast = String(Boolean(state.contrast));
        root.dataset.a11yLinks = String(Boolean(state.links));
        root.dataset.a11yFont = String(Boolean(state.font));
        root.dataset.a11yMotion = String(Boolean(state.motion));
        root.dataset.a11yFocus = String(Boolean(state.focus));
        root.dataset.a11yGrayscale = String(Boolean(state.grayscale));
    }

    function syncUI() {
        panel.querySelectorAll("[data-a11y-text]").forEach((button) => {
            button.setAttribute(
                "aria-pressed",
                String(button.dataset.a11yText === state.text),
            );
        });

        panel.querySelectorAll("[data-a11y-toggle]").forEach((button) => {
            const key = button.dataset.a11yToggle;
            button.setAttribute("aria-pressed", String(Boolean(state[key])));
        });

        if (rateSelect) {
            rateSelect.value = String(state.rate || 1);
        }
    }

    function announce(message) {
        if (!liveStatus) return;

        // Mengosongkan lebih dulu membuat perubahan yang identik tetap diumumkan.
        liveStatus.textContent = "";
        window.requestAnimationFrame(() => {
            liveStatus.textContent = message;
        });
    }

    /* ----------------------------------------------------------------------
       Text-to-Speech
       ---------------------------------------------------------------------- */
    function initSpeech() {
        if (!readButton || !pauseButton || !stopButton) return;

        if (!speechSupported) {
            readButton.disabled = true;
            pauseButton.disabled = true;
            stopButton.disabled = true;

            if (speechNotice) {
                speechNotice.textContent =
                    "Fitur suara tidak didukung oleh browser/perangkat ini. Gunakan screen reader perangkat bila diperlukan.";
            }
            return;
        }

        chooseVoice();
        window.speechSynthesis.onvoiceschanged = chooseVoice;

        readButton.addEventListener("click", startReading);
        pauseButton.addEventListener("click", togglePause);
        stopButton.addEventListener("click", stopSpeech);

        updateSpeechButtons();
    }

    function chooseVoice() {
        if (!synth) return;

        const voices = synth.getVoices();

        preferredVoice =
            voices.find((voice) =>
                String(voice.lang || "")
                    .toLowerCase()
                    .startsWith("id"),
            ) ||
            voices.find((voice) =>
                String(voice.lang || "")
                    .toLowerCase()
                    .startsWith("ms"),
            ) ||
            voices[0] ||
            null;
    }

    function startReading() {
        if (!synth) return;

        stopSpeech(false);

        const selectedText = String(
            window.getSelection()?.toString() || "",
        ).trim();
        const source = selectedText || getReadablePageText();

        if (!source) {
            announce("Tidak ada teks utama yang dapat dibacakan.");
            return;
        }

        speechChunks = chunkText(source);
        speechIndex = 0;
        isReading = true;
        isPaused = false;

        announce(
            selectedText
                ? "Membacakan teks yang dipilih."
                : "Mulai membacakan isi utama halaman.",
        );

        speakNextChunk();
        updateSpeechButtons();
    }

    function getReadablePageText() {
        const main =
            document.querySelector("main article") ||
            document.querySelector("main");

        if (!main) return "";

        // clone agar kita dapat membuang elemen yang tidak perlu tanpa mengubah halaman.
        const clone = main.cloneNode(true);

        clone
            .querySelectorAll(
                [
                    "script",
                    "style",
                    "noscript",
                    "svg",
                    "iframe",
                    "video",
                    "audio",
                    "form",
                    "button",
                    "[hidden]",
                    '[aria-hidden="true"]',
                    ".a11y-panel",
                    ".youtube-modal",
                    ".video-modal",
                ].join(","),
            )
            .forEach((element) => element.remove());

        return String(clone.innerText || clone.textContent || "")
            .replace(/\s+/g, " ")
            .trim();
    }

    function chunkText(text) {
        const normalized = text
            .replace(/\s+/g, " ")
            .replace(/\s([,.;!?])/g, "$1")
            .trim();

        if (!normalized) return [];

        const sentences = normalized.match(/[^.!?]+[.!?]+|[^.!?]+$/g) || [
            normalized,
        ];

        const chunks = [];
        let current = "";

        for (const sentence of sentences) {
            const cleanSentence = sentence.trim();

            if ((current + " " + cleanSentence).trim().length <= 220) {
                current = (current + " " + cleanSentence).trim();
                continue;
            }

            if (current) chunks.push(current);

            if (cleanSentence.length <= 220) {
                current = cleanSentence;
                continue;
            }

            // Fallback untuk kalimat sangat panjang.
            const words = cleanSentence.split(/\s+/);
            current = "";

            for (const word of words) {
                if ((current + " " + word).trim().length > 220) {
                    if (current) chunks.push(current);
                    current = word;
                } else {
                    current = (current + " " + word).trim();
                }
            }
        }

        if (current) chunks.push(current);

        return chunks;
    }

    function speakNextChunk() {
        if (!synth || !isReading || speechIndex >= speechChunks.length) {
            finishSpeech();
            return;
        }

        const utterance = new SpeechSynthesisUtterance(
            speechChunks[speechIndex],
        );

        utterance.lang = preferredVoice?.lang || "id-ID";
        utterance.voice = preferredVoice || null;
        utterance.rate = Number(state.rate) || 1;
        utterance.pitch = 1;
        utterance.volume = 1;

        utterance.onend = () => {
            if (!isReading) return;
            speechIndex += 1;
            speakNextChunk();
        };

        utterance.onerror = (event) => {
            // "interrupted" normal terjadi ketika pengguna menekan stop.
            if (
                event.error &&
                event.error !== "interrupted" &&
                event.error !== "canceled"
            ) {
                announce("Pembacaan suara mengalami masalah pada browser.");
            }

            if (event.error !== "interrupted" && event.error !== "canceled") {
                finishSpeech();
            }
        };

        synth.speak(utterance);
    }

    function togglePause() {
        if (!synth || !isReading) return;

        if (synth.paused || isPaused) {
            synth.resume();
            isPaused = false;
            announce("Pembacaan dilanjutkan.");
        } else {
            synth.pause();
            isPaused = true;
            announce("Pembacaan dijeda.");
        }

        updateSpeechButtons();
    }

    function stopSpeech(announceStop = true) {
        if (!synth) return;

        synth.cancel();

        const wasReading = isReading;

        isReading = false;
        isPaused = false;
        speechChunks = [];
        speechIndex = 0;

        updateSpeechButtons();

        if (announceStop && wasReading) {
            announce("Pembacaan dihentikan.");
        }
    }

    function finishSpeech() {
        isReading = false;
        isPaused = false;
        speechChunks = [];
        speechIndex = 0;

        updateSpeechButtons();
        announce("Pembacaan halaman selesai.");
    }

    function updateSpeechButtons() {
        if (!speechSupported || !readButton || !pauseButton || !stopButton) {
            return;
        }

        pauseButton.disabled = !isReading;
        stopButton.disabled = !isReading;

        pauseButton.innerHTML = isPaused
            ? '<i class="fa-solid fa-play" aria-hidden="true"></i><span>Lanjut</span>'
            : '<i class="fa-solid fa-pause" aria-hidden="true"></i><span>Jeda</span>';
    }

    /* ----------------------------------------------------------------------
       Cleanup
       ---------------------------------------------------------------------- */
    window.addEventListener("pagehide", () => {
        if (synth) synth.cancel();
    });
})();
