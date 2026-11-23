(() => {
    "use strict";

    const modal = document.getElementById("videoModal");

    if (!modal) {
        return;
    }

    const host = document.getElementById("youtubePlayerHost");
    const modalTitle = document.getElementById("videoModalTitle");
    const closeButton = modal.querySelector("[data-modal-close]");
    const backdrop = modal.querySelector("[data-modal-backdrop]");
    const autoplayNotice = document.getElementById("videoAutoplayNotice");

    let player = null;
    let lastTrigger = null;
    let currentVideo = null;
    let youtubeApiPromise = null;

    /**
     * Analytics adapter.
     * Hindari mengirim data pribadi.
     */
    function trackEvent(eventName, params = {}) {
        const payload = {
            ...params,
            page_path: window.location.pathname + window.location.search,
        };

        if (typeof window.gtag === "function") {
            window.gtag("event", eventName, payload);
            return;
        }

        if (Array.isArray(window.dataLayer)) {
            window.dataLayer.push({
                event: eventName,
                ...payload,
            });
            return;
        }

        // Tetap tersedia untuk listener internal aplikasi.
        window.dispatchEvent(
            new CustomEvent("dispusaka:analytics", {
                detail: {
                    event: eventName,
                    ...payload,
                },
            }),
        );
    }

    /**
     * Load YouTube IFrame API hanya ketika dibutuhkan.
     */
    function loadYouTubeApi() {
        if (window.YT?.Player) {
            return Promise.resolve(window.YT);
        }

        if (youtubeApiPromise) {
            return youtubeApiPromise;
        }

        youtubeApiPromise = new Promise((resolve, reject) => {
            const previousCallback = window.onYouTubeIframeAPIReady;

            window.onYouTubeIframeAPIReady = () => {
                if (typeof previousCallback === "function") {
                    previousCallback();
                }

                if (window.YT?.Player) {
                    resolve(window.YT);
                } else {
                    reject(new Error("YouTube IFrame API tidak tersedia."));
                }
            };

            const existingScript = document.querySelector(
                "script[data-youtube-iframe-api]",
            );

            if (existingScript) {
                return;
            }

            const script = document.createElement("script");

            script.src = "https://www.youtube.com/iframe_api";
            script.async = true;
            script.dataset.youtubeIframeApi = "true";

            script.addEventListener("error", () => {
                reject(new Error("Gagal memuat YouTube IFrame API."));
            });

            document.head.appendChild(script);
        });

        return youtubeApiPromise;
    }

    /**
     * Defense in depth di frontend.
     * Server tetap menjadi validator utama.
     */
    function isValidYoutubeId(value) {
        return /^[A-Za-z0-9_-]{11}$/.test(value);
    }

    function buildPlayerUrl(videoId) {
        const params = new URLSearchParams({
            autoplay: "1",
            playsinline: "1",
            enablejsapi: "1",
            rel: "0",

            // Opsional, baik untuk konten pemerintah
            // jika video memiliki captions Indonesia.
            cc_load_policy: "1",
            cc_lang_pref: "id",

            origin: window.location.origin,
        });

        return (
            `https://www.youtube-nocookie.com/embed/` +
            `${encodeURIComponent(videoId)}?${params.toString()}`
        );
    }

    function createPlayerIframe(videoId, title) {
        const iframe = document.createElement("iframe");

        iframe.id = "dispusakaYoutubeFrame";
        iframe.title = title || "Video DISPUSAKA";

        iframe.src = buildPlayerUrl(videoId);

        iframe.width = "960";
        iframe.height = "540";

        iframe.allow =
            "accelerometer; autoplay; clipboard-write; " +
            "encrypted-media; gyroscope; picture-in-picture; web-share";

        iframe.allowFullscreen = true;

        // Jangan gunakan "no-referrer".
        iframe.referrerPolicy = "strict-origin-when-cross-origin";

        host.replaceChildren(iframe);

        return iframe;
    }

    function getFocusableElements() {
        return [
            ...modal.querySelectorAll(
                [
                    "a[href]",
                    "button:not([disabled])",
                    "input:not([disabled])",
                    "select:not([disabled])",
                    "textarea:not([disabled])",
                    "iframe",
                    '[tabindex]:not([tabindex="-1"])',
                ].join(","),
            ),
        ].filter((element) => {
            return !element.hasAttribute("hidden");
        });
    }

    function handleFocusTrap(event) {
        if (event.key === "Escape") {
            event.preventDefault();
            closeModal("escape");
            return;
        }

        if (event.key !== "Tab") {
            return;
        }

        const focusable = getFocusableElements();

        if (!focusable.length) {
            event.preventDefault();
            closeButton.focus();
            return;
        }

        const first = focusable[0];
        const last = focusable[focusable.length - 1];

        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    function handlePlayerState(event) {
        if (!window.YT || !currentVideo) {
            return;
        }

        const base = {
            video_id: currentVideo.id,
            video_title: currentVideo.title,
        };

        switch (event.data) {
            case window.YT.PlayerState.PLAYING:
                trackEvent("video_play", base);
                break;

            case window.YT.PlayerState.PAUSED:
                trackEvent("video_pause", base);
                break;

            case window.YT.PlayerState.ENDED:
                trackEvent("video_complete", base);
                break;

            default:
                break;
        }
    }

    async function openModal(trigger) {
        const videoId = trigger.dataset.videoId;
        const title = trigger.dataset.videoTitle?.trim() || "Video DISPUSAKA";

        if (!isValidYoutubeId(videoId)) {
            console.error("YouTube video ID tidak valid.");
            return;
        }

        lastTrigger = trigger;

        currentVideo = {
            id: videoId,
            title,
        };

        modalTitle.textContent = title;
        autoplayNotice.hidden = true;

        modal.hidden = false;

        // Trigger transition pada frame berikutnya.
        requestAnimationFrame(() => {
            modal.classList.add("is-open");
        });

        document.body.classList.add("video-modal-open");

        closeButton.focus();

        trackEvent("video_open", {
            video_id: videoId,
            video_title: title,
        });

        const iframe = createPlayerIframe(videoId, title);

        try {
            const YT = await loadYouTubeApi();

            // Pengguna mungkin sudah menutup modal
            // sebelum API selesai dimuat.
            if (modal.hidden || !currentVideo || currentVideo.id !== videoId) {
                return;
            }

            player = new YT.Player(iframe, {
                events: {
                    onReady: (event) => {
                        try {
                            event.target.playVideo();
                        } catch (error) {
                            console.warn(
                                "Autoplay tidak dapat dimulai.",
                                error,
                            );
                        }
                    },

                    onStateChange: handlePlayerState,

                    onAutoplayBlocked: () => {
                        autoplayNotice.hidden = false;

                        trackEvent("video_autoplay_blocked", {
                            video_id: videoId,
                            video_title: title,
                        });
                    },

                    onError: (event) => {
                        trackEvent("video_error", {
                            video_id: videoId,
                            video_title: title,
                            error_code: event.data,
                        });
                    },
                },
            });
        } catch (error) {
            console.error(error);

            // Iframe standar tetap dapat digunakan
            // meski wrapper IFrame API gagal.
        }
    }

    function closeModal(reason = "button") {
        if (modal.hidden) {
            return;
        }

        const closingVideo = currentVideo;

        try {
            if (player && typeof player.stopVideo === "function") {
                player.stopVideo();
            }
        } catch (error) {
            console.warn("Player gagal dihentikan dengan API.", error);
        }

        try {
            if (player && typeof player.destroy === "function") {
                player.destroy();
            }
        } catch (error) {
            console.warn("Player gagal dihancurkan.", error);
        }

        player = null;

        // Sangat penting:
        // iframe benar-benar dikeluarkan dari DOM.
        host.replaceChildren();

        modal.classList.remove("is-open");
        document.body.classList.remove("video-modal-open");

        modal.hidden = true;

        autoplayNotice.hidden = true;

        if (closingVideo) {
            trackEvent("video_close", {
                video_id: closingVideo.id,
                video_title: closingVideo.title,
                close_reason: reason,
            });
        }

        currentVideo = null;

        if (lastTrigger && document.contains(lastTrigger)) {
            lastTrigger.focus();
        }

        lastTrigger = null;
    }

    document.addEventListener("click", (event) => {
        const trigger = event.target.closest("[data-video-trigger]");

        if (trigger) {
            openModal(trigger);
        }
    });

    closeButton.addEventListener("click", () => {
        closeModal("button");
    });

    backdrop.addEventListener("click", () => {
        closeModal("backdrop");
    });

    modal.addEventListener("keydown", handleFocusTrap);

    document.querySelectorAll("[data-pagination-direction]").forEach((link) => {
        link.addEventListener("click", () => {
            trackEvent("video_pagination", {
                direction: link.dataset.paginationDirection,
            });
        });
    });
})();
