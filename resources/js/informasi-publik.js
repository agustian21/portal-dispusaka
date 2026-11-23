/**
 * DISPUSAKA - Informasi Publik
 *
 * Progressive enhancement for:
 * - live document search
 * - year filtering
 * - accessible category accordions
 * - expand/collapse all
 * - keyboard category navigation
 * - Google Drive /view -> /preview normalization
 *
 * Core document content remains accessible without JavaScript.
 */

const initPublicInformation = () => {
    const page = document.querySelector(".ip-page");

    if (!page) {
        return;
    }

    const form = page.querySelector("#ipFilterForm");
    const searchInput = page.querySelector("#ipSearch");
    const searchClear = page.querySelector("#ipInputClear");
    const yearFilter = page.querySelector("#ipYearFilter");

    const resetButton = page.querySelector("#ipResetFilters");
    const noResultsReset = page.querySelector("#ipNoResultsReset");

    const toggleAllButton = page.querySelector("#ipToggleAll");

    const resultCount = page.querySelector("#ipResultCount");
    const resultStatus = page.querySelector("#ipResultStatus");
    const noResults = page.querySelector("#ipNoResults");
    const categoryList = page.querySelector("#ipCategoryList");

    const categories = Array.from(page.querySelectorAll(".ip-category"));

    const categoryButtons = categories
        .map((category) => category.querySelector(".ip-category-toggle"))
        .filter(Boolean);

    const documentRows = Array.from(
        page.querySelectorAll("[data-document-row]"),
    );

    const totalDocuments = documentRows.length;

    /**
     * Store category expansion state before filtering.
     * This lets us temporarily expand search results and restore
     * the user's previous state after filters are cleared.
     */
    const accordionStateBeforeFilter = new Map();

    let filterWasActive = false;
    let filterTimer = null;

    /**
     * Normalize text for forgiving search.
     * Handles case differences and common accented characters.
     */
    const normalizeText = (value = "") => {
        return value
            .toString()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLocaleLowerCase("id-ID")
            .trim();
    };

    /**
     * Only transform Google Drive URLs.
     *
     * Example:
     * /file/d/FILE_ID/view?usp=sharing
     * becomes:
     * /file/d/FILE_ID/preview?usp=sharing
     */
    const toDrivePreview = (href) => {
        if (typeof href !== "string" || !href.includes("drive.google.com")) {
            return href;
        }

        return href.replace(/\/view(?=\/|\?|#|$)/i, "/preview");
    };

    /**
     * Defense in depth.
     * Blade already performs this conversion.
     */
    page.querySelectorAll("[data-drive-link]").forEach((link) => {
        const href = link.getAttribute("href");

        if (!href) {
            return;
        }

        link.setAttribute("href", toDrivePreview(href));

        /*
         * Protect the opener context for target="_blank".
         */
        link.setAttribute("rel", "noopener noreferrer");
    });

    /**
     * Accordion helper.
     */
    const setCategoryExpanded = (category, expanded) => {
        const button = category.querySelector(".ip-category-toggle");

        if (!button) {
            return;
        }

        const panelId = button.getAttribute("aria-controls");
        const panel = panelId ? document.getElementById(panelId) : null;

        button.setAttribute("aria-expanded", String(expanded));

        category.classList.toggle("is-open", expanded);

        if (panel) {
            panel.hidden = !expanded;
        }
    };

    const isCategoryExpanded = (category) => {
        const button = category.querySelector(".ip-category-toggle");

        return button?.getAttribute("aria-expanded") === "true";
    };

    /**
     * Individual accordion controls.
     *
     * Because these are native buttons, Enter and Space
     * activate them automatically.
     */
    categoryButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const category = button.closest(".ip-category");

            if (!category) {
                return;
            }

            setCategoryExpanded(category, !isCategoryExpanded(category));

            updateToggleAllState();
        });
    });

    /**
     * Optional accordion keyboard navigation:
     *
     * ArrowDown -> next heading
     * ArrowUp   -> previous heading
     * Home      -> first heading
     * End       -> last heading
     *
     * Tab / Shift+Tab remain browser-native.
     */
    categoryButtons.forEach((button, index) => {
        button.addEventListener("keydown", (event) => {
            let nextIndex = null;

            switch (event.key) {
                case "ArrowDown":
                    nextIndex = (index + 1) % categoryButtons.length;
                    break;

                case "ArrowUp":
                    nextIndex =
                        (index - 1 + categoryButtons.length) %
                        categoryButtons.length;
                    break;

                case "Home":
                    nextIndex = 0;
                    break;

                case "End":
                    nextIndex = categoryButtons.length - 1;
                    break;

                default:
                    return;
            }

            event.preventDefault();

            categoryButtons[nextIndex]?.focus();
        });
    });

    /**
     * Expand/collapse-all control.
     */
    const updateToggleAllState = () => {
        if (!toggleAllButton) {
            return;
        }

        const visibleCategories = categories.filter(
            (category) => !category.hidden,
        );

        const allExpanded =
            visibleCategories.length > 0 &&
            visibleCategories.every(isCategoryExpanded);

        toggleAllButton.setAttribute("aria-expanded", String(allExpanded));

        const icon = toggleAllButton.querySelector("i");

        const label = toggleAllButton.querySelector("span");

        if (allExpanded) {
            if (label) {
                label.textContent = "Tutup semua";
            }

            if (icon) {
                icon.className = "fa-solid fa-angles-up";
            }
        } else {
            if (label) {
                label.textContent = "Buka semua";
            }

            if (icon) {
                icon.className = "fa-solid fa-angles-down";
            }
        }
    };

    toggleAllButton?.addEventListener("click", () => {
        const visibleCategories = categories.filter(
            (category) => !category.hidden,
        );

        const allExpanded =
            visibleCategories.length > 0 &&
            visibleCategories.every(isCategoryExpanded);

        visibleCategories.forEach((category) => {
            setCategoryExpanded(category, !allExpanded);
        });

        updateToggleAllState();
    });

    /**
     * Save current accordion state once when filtering begins.
     */
    const saveAccordionState = () => {
        accordionStateBeforeFilter.clear();

        categories.forEach((category) => {
            accordionStateBeforeFilter.set(
                category,
                isCategoryExpanded(category),
            );
        });
    };

    const restoreAccordionState = () => {
        categories.forEach((category) => {
            const stored = accordionStateBeforeFilter.get(category);

            if (typeof stored === "boolean") {
                setCategoryExpanded(category, stored);
            }
        });

        accordionStateBeforeFilter.clear();
    };

    /**
     * Update live-region text.
     */
    const updateResultMessage = (visibleCount, query, year) => {
        if (resultCount) {
            resultCount.textContent = visibleCount.toLocaleString("id-ID");
        }

        if (!resultStatus) {
            return;
        }

        let detail = "";

        if (query && year) {
            detail =
                ` untuk "${searchInput.value.trim()}" ` + `pada tahun ${year}`;
        } else if (query) {
            detail = ` untuk "${searchInput.value.trim()}"`;
        } else if (year) {
            detail = ` pada tahun ${year}`;
        }

        resultStatus.setAttribute(
            "aria-label",
            `${visibleCount} dokumen ditemukan${detail}`,
        );
    };

    /**
     * Main filter engine.
     */
    const applyFilters = () => {
        const rawQuery = searchInput?.value ?? "";

        const query = normalizeText(rawQuery);

        const selectedYear = yearFilter?.value ?? "";

        const filterIsActive = query.length > 0 || selectedYear.length > 0;

        /*
         * Save expansion state only when entering
         * filter mode for the first time.
         */
        if (filterIsActive && !filterWasActive) {
            saveAccordionState();
        }

        /*
         * Restore prior state when leaving filter mode.
         */
        if (!filterIsActive && filterWasActive) {
            restoreAccordionState();
        }

        filterWasActive = filterIsActive;

        let totalVisible = 0;

        categories.forEach((category) => {
            const rows = Array.from(
                category.querySelectorAll("[data-document-row]"),
            );

            let categoryVisible = 0;

            rows.forEach((row) => {
                const searchableText = normalizeText(
                    row.dataset.search ?? row.textContent ?? "",
                );

                const rowYear = String(row.dataset.year ?? "");

                const matchesText = !query || searchableText.includes(query);

                const matchesYear = !selectedYear || rowYear === selectedYear;

                const isMatch = matchesText && matchesYear;

                row.hidden = !isMatch;

                if (isMatch) {
                    categoryVisible += 1;
                    totalVisible += 1;
                }
            });

            const categoryCount = category.querySelector(
                "[data-category-count]",
            );

            if (categoryCount) {
                categoryCount.textContent =
                    categoryVisible.toLocaleString("id-ID");
            }

            const categoryNoMatch = category.querySelector(
                "[data-category-empty]",
            );

            /*
             * Categories containing no documents from the
             * server remain visible in the unfiltered state.
             */
            if (filterIsActive) {
                category.hidden = categoryVisible === 0;

                if (categoryVisible > 0) {
                    /*
                     * Search results should never be hidden
                     * inside a collapsed category.
                     */
                    setCategoryExpanded(category, true);
                }
            } else {
                category.hidden = false;
            }

            if (categoryNoMatch) {
                categoryNoMatch.hidden = categoryVisible > 0 || !filterIsActive;
            }
        });

        if (searchClear) {
            searchClear.hidden = rawQuery.length === 0;
        }

        if (resetButton) {
            resetButton.disabled = !filterIsActive;
        }

        if (noResults) {
            noResults.hidden = totalVisible > 0 || !filterIsActive;
        }

        if (categoryList) {
            categoryList.hidden = totalVisible === 0 && filterIsActive;
        }

        updateResultMessage(totalVisible, query, selectedYear);

        updateToggleAllState();
    };

    /**
     * Small debounce avoids unnecessary repeated layout work
     * during very fast typing while still feeling instant.
     */
    const scheduleFilter = () => {
        window.clearTimeout(filterTimer);

        filterTimer = window.setTimeout(applyFilters, 90);
    };

    searchInput?.addEventListener("input", scheduleFilter);

    yearFilter?.addEventListener("change", applyFilters);

    /**
     * This is a live-filter form.
     * Do not navigate on Enter.
     */
    form?.addEventListener("submit", (event) => {
        event.preventDefault();
        applyFilters();
    });

    /**
     * Clear only the search term.
     */
    searchClear?.addEventListener("click", () => {
        if (!searchInput) {
            return;
        }

        searchInput.value = "";
        applyFilters();
        searchInput.focus();
    });

    /**
     * Reset all filters.
     */
    const resetFilters = () => {
        if (searchInput) {
            searchInput.value = "";
        }

        if (yearFilter) {
            yearFilter.value = "";
        }

        applyFilters();

        searchInput?.focus();
    };

    resetButton?.addEventListener("click", resetFilters);

    noResultsReset?.addEventListener("click", resetFilters);

    /*
     * Preserve the server-rendered all-open state.
     * This gives users immediate access to every category and
     * keeps behavior predictable if JavaScript is unavailable.
     */
    updateToggleAllState();

    /*
     * Initialize counts and Drive links.
     */
    applyFilters();

    /*
     * Sanity guard for server / client count differences.
     */
    if (
        categoryList &&
        Number(categoryList.dataset.totalDocuments) !== totalDocuments
    ) {
        console.warn(
            "[Informasi Publik] Document count differs between server metadata and rendered rows.",
        );
    }
};

if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initPublicInformation, {
        once: true,
    });
} else {
    initPublicInformation();
}
