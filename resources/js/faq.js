document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const root = document.querySelector("[data-faq-page]");

    if (!root) {
        return;
    }

    const searchInput = root.querySelector("[data-faq-search]");
    const clearButton = root.querySelector("[data-faq-clear]");
    const resetButton = root.querySelector("[data-faq-reset]");
    const resultCount = root.querySelector("[data-faq-result-count]");
    const noResults = root.querySelector("[data-faq-no-results]");
    const expandAllButton = root.querySelector("[data-faq-expand-all]");
    const expandAllLabel = root.querySelector("[data-faq-expand-label]");
    const expandAllIcon = root.querySelector("[data-faq-expand-icon]");

    const items = Array.from(root.querySelectorAll("[data-faq-item]"));

    /**
     * Normalisasi string agar pencarian lebih konsisten.
     */
    const normalize = (value = "") => {
        return value.toLocaleLowerCase("id-ID").replace(/\s+/g, " ").trim();
    };

    /**
     * Ambil elemen penting dari satu FAQ item.
     */
    const getParts = (item) => {
        return {
            trigger: item.querySelector("[data-faq-trigger]"),
            panel: item.querySelector("[data-faq-panel]"),
        };
    };

    /**
     * Periksa apakah FAQ sedang terbuka.
     */
    const isOpen = (item) => {
        const { trigger } = getParts(item);

        return trigger?.getAttribute("aria-expanded") === "true";
    };

    /**
     * Membuka / menutup satu FAQ.
     */
    const setOpen = (item, open) => {
        const { trigger, panel } = getParts(item);

        if (!trigger || !panel) {
            return;
        }

        trigger.setAttribute("aria-expanded", open ? "true" : "false");

        panel.hidden = !open;

        item.classList.toggle("is-open", open);
    };

    /**
     * Hanya FAQ yang tidak sedang difilter.
     */
    const getVisibleItems = () => {
        return items.filter((item) => !item.hidden);
    };

    /**
     * Sinkronkan label tombol Buka/Tutup semua.
     */
    const syncExpandAllButton = () => {
        if (!expandAllButton) {
            return;
        }

        const visibleItems = getVisibleItems();

        if (visibleItems.length === 0) {
            expandAllButton.disabled = true;
            return;
        }

        expandAllButton.disabled = false;

        const allOpen = visibleItems.every((item) => isOpen(item));

        if (expandAllLabel) {
            expandAllLabel.textContent = allOpen ? "Tutup semua" : "Buka semua";
        }

        if (expandAllIcon) {
            expandAllIcon.className = allOpen
                ? "fa-solid fa-angles-up"
                : "fa-solid fa-angles-down";
        }
    };

    /**
     * Update jumlah hasil.
     */
    const updateResultCount = (visibleCount, term) => {
        if (!resultCount) {
            return;
        }

        if (term) {
            resultCount.textContent = `${visibleCount} hasil ditemukan`;
        } else {
            resultCount.textContent = `${visibleCount} pertanyaan tersedia`;
        }
    };

    /**
     * Filtering FAQ di browser.
     *
     * textContent sengaja dipakai supaya pencarian membaca:
     * - judul
     * - jawaban
     */
    const runSearch = () => {
        if (!searchInput) {
            return;
        }

        const term = normalize(searchInput.value);

        let visibleCount = 0;

        items.forEach((item) => {
            const searchableText = normalize(item.textContent);

            const matched = term.length === 0 || searchableText.includes(term);

            item.hidden = !matched;

            if (matched) {
                visibleCount += 1;
            }
        });

        if (clearButton) {
            clearButton.hidden = term.length === 0;
        }

        if (noResults) {
            noResults.hidden = visibleCount !== 0;
        }

        updateResultCount(visibleCount, term);

        syncExpandAllButton();
    };

    /**
     * Reset pencarian.
     */
    const resetSearch = ({ focus = true } = {}) => {
        if (!searchInput) {
            return;
        }

        searchInput.value = "";

        runSearch();

        if (focus) {
            searchInput.focus();
        }
    };

    /**
     * Event delegation untuk accordion.
     */
    root.addEventListener("click", (event) => {
        const trigger = event.target.closest("[data-faq-trigger]");

        if (!trigger || !root.contains(trigger)) {
            return;
        }

        const item = trigger.closest("[data-faq-item]");

        if (!item) {
            return;
        }

        setOpen(item, !isOpen(item));

        syncExpandAllButton();
    });

    /**
     * Live search.
     */
    searchInput?.addEventListener("input", runSearch);

    /**
     * ESC di field pencarian = hapus query.
     */
    searchInput?.addEventListener("keydown", (event) => {
        if (event.key === "Escape" && searchInput.value) {
            resetSearch();
        }
    });

    clearButton?.addEventListener("click", () => {
        resetSearch();
    });

    resetButton?.addEventListener("click", () => {
        resetSearch();

        document.querySelector("#faqList")?.scrollIntoView({
            behavior: window.matchMedia("(prefers-reduced-motion: reduce)")
                .matches
                ? "auto"
                : "smooth",
            block: "start",
        });
    });

    /**
     * Buka / tutup semua FAQ yang sedang terlihat.
     *
     * FAQ yang tersembunyi akibat search tidak ikut berubah.
     */
    expandAllButton?.addEventListener("click", () => {
        const visibleItems = getVisibleItems();

        if (visibleItems.length === 0) {
            return;
        }

        const shouldOpen = !visibleItems.every((item) => isOpen(item));

        visibleItems.forEach((item) => {
            setOpen(item, shouldOpen);
        });

        syncExpandAllButton();
    });

    /**
     * Mendukung deep-link:
     * /faq#faq-item-10
     */
    const openItemFromHash = () => {
        if (!window.location.hash) {
            return;
        }

        let id;

        try {
            id = decodeURIComponent(window.location.hash.slice(1));
        } catch {
            return;
        }

        const item = document.getElementById(id);

        if (!item || !item.matches("[data-faq-item]")) {
            return;
        }

        setOpen(item, true);

        syncExpandAllButton();
    };

    /**
     * Initial state.
     */
    runSearch();
    openItemFromHash();

    window.addEventListener("hashchange", openItemFromHash);
});
