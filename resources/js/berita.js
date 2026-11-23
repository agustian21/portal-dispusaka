document.documentElement.classList.add("news-js");

document.addEventListener("DOMContentLoaded", () => {
    const reduceMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)",
    ).matches;

    /*
     * Reveal animation.
     * Tetap aman jika IntersectionObserver tidak tersedia.
     */
    const revealElements = [...document.querySelectorAll("[data-reveal]")];

    if (reduceMotion || !("IntersectionObserver" in window)) {
        revealElements.forEach((element) => {
            element.classList.add("is-visible");
        });
    } else {
        const revealObserver = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                });
            },
            {
                threshold: 0.12,
                rootMargin: "0px 0px -35px 0px",
            },
        );

        revealElements.forEach((element) => {
            revealObserver.observe(element);
        });
    }

    /*
     * Reading progress untuk halaman detail.
     */
    const article = document.querySelector("[data-article]");
    const progressBar = document.getElementById("readingProgress");

    if (article && progressBar) {
        let ticking = false;

        const updateReadingProgress = () => {
            const articleRect = article.getBoundingClientRect();

            const articleTop = articleRect.top + window.scrollY;

            const articleHeight = article.offsetHeight;

            const viewportReference = window.innerHeight * 0.22;

            const currentPosition =
                window.scrollY - articleTop + viewportReference;

            const readableDistance = Math.max(
                articleHeight - window.innerHeight * 0.45,
                1,
            );

            const progress = Math.min(
                Math.max(currentPosition / readableDistance, 0),
                1,
            );

            progressBar.style.width = `${Math.round(progress * 100)}%`;

            ticking = false;
        };

        const requestProgressUpdate = () => {
            if (ticking) {
                return;
            }

            ticking = true;

            window.requestAnimationFrame(updateReadingProgress);
        };

        updateReadingProgress();

        window.addEventListener("scroll", requestProgressUpdate, {
            passive: true,
        });

        window.addEventListener("resize", requestProgressUpdate);
    }

    /*
     * Toast.
     */
    const toast = document.querySelector("[data-share-toast]");

    let toastTimer = null;

    const showToast = (message) => {
        if (!toast) {
            return;
        }

        window.clearTimeout(toastTimer);

        toast.textContent = message;
        toast.classList.add("is-visible");

        toastTimer = window.setTimeout(() => {
            toast.classList.remove("is-visible");
        }, 2400);
    };

    /*
     * Copy URL.
     */
    const fallbackCopy = (text) => {
        const textarea = document.createElement("textarea");

        textarea.value = text;
        textarea.setAttribute("readonly", "");
        textarea.style.position = "fixed";
        textarea.style.opacity = "0";
        textarea.style.pointerEvents = "none";

        document.body.appendChild(textarea);

        textarea.select();
        textarea.setSelectionRange(0, textarea.value.length);

        let success = false;

        try {
            success = document.execCommand("copy");
        } catch (error) {
            success = false;
        }

        textarea.remove();

        return success;
    };

    const copyCurrentUrl = async () => {
        const url = window.location.href;

        try {
            if (
                navigator.clipboard &&
                typeof navigator.clipboard.writeText === "function"
            ) {
                await navigator.clipboard.writeText(url);

                showToast("Tautan berita berhasil disalin.");
                return;
            }

            const success = fallbackCopy(url);

            showToast(
                success
                    ? "Tautan berita berhasil disalin."
                    : "Tautan belum dapat disalin.",
            );
        } catch (error) {
            const success = fallbackCopy(url);

            showToast(
                success
                    ? "Tautan berita berhasil disalin."
                    : "Tautan belum dapat disalin.",
            );
        }
    };

    /*
     * Tombol copy link.
     */
    document.querySelectorAll("[data-copy-link]").forEach((button) => {
        button.addEventListener("click", copyCurrentUrl);
    });

    /*
     * Native share.
     * Jika browser tidak mendukung navigator.share,
     * otomatis salin tautan.
     */
    document.querySelectorAll("[data-share-native]").forEach((button) => {
        button.addEventListener("click", async () => {
            const shareData = {
                title: document.title,
                url: window.location.href,
            };

            if (typeof navigator.share !== "function") {
                await copyCurrentUrl();
                return;
            }

            try {
                await navigator.share(shareData);
            } catch (error) {
                /*
                 * AbortError berarti pengguna sendiri
                 * menutup share sheet.
                 */
                if (error?.name === "AbortError") {
                    return;
                }

                await copyCurrentUrl();
            }
        });
    });
});
