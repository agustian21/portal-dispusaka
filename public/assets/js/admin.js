(function () {
    "use strict";

    const qs = (selector, root = document) => root.querySelector(selector);
    const qsa = (selector, root = document) =>
        Array.from(root.querySelectorAll(selector));

    /*
  |--------------------------------------------------------------------------
  | SweetAlert / Notification
  |--------------------------------------------------------------------------
  */

    function notify(options) {
        if (window.Swal) {
            return window.Swal.fire({
                confirmButtonColor: "#155cc0",
                cancelButtonColor: "#718096",
                customClass: {
                    popup: "swal-poppins",
                },
                ...options,
            });
        }

        if (options.showCancelButton) {
            return Promise.resolve({
                isConfirmed: window.confirm(
                    options.text || options.title || "Lanjutkan?",
                ),
            });
        }

        window.alert(options.text || options.title || "Berhasil");

        return Promise.resolve({
            isConfirmed: true,
        });
    }

    function toast(title, icon = "success") {
        if (!window.Swal) {
            return notify({
                title,
                icon,
            });
        }

        return window.Swal.fire({
            toast: true,
            position: "top-end",
            icon,
            title,
            showConfirmButton: false,
            timer: 2400,
            timerProgressBar: true,
            customClass: {
                popup: "swal-poppins",
            },
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Sidebar, User Menu & Logout
  |--------------------------------------------------------------------------
  */

    function setupShell() {
        const sidebar = qs("#sidebar");
        const overlay = qs("#overlay");
        const menuButton = qs("#menuButton");
        const closeButton = qs("#sidebarClose");

        const desktopQuery = window.matchMedia("(min-width: 861px)");

        const setMenuLabel = () => {
            if (!menuButton) return;

            if (desktopQuery.matches) {
                const collapsed =
                    document.body.classList.contains("sidebar-collapsed");

                menuButton.setAttribute(
                    "aria-label",
                    collapsed ? "Perluas navigasi" : "Ringkas navigasi",
                );

                menuButton.setAttribute("aria-expanded", String(!collapsed));
            } else {
                const open = sidebar?.classList.contains("open");

                menuButton.setAttribute(
                    "aria-label",
                    open ? "Tutup navigasi" : "Buka navigasi",
                );

                menuButton.setAttribute("aria-expanded", String(Boolean(open)));
            }
        };

        const closeSidebar = (restoreFocus = false) => {
            if (!sidebar) return;

            sidebar.classList.remove("open");
            overlay?.classList.remove("show");

            if (!qs(".modal.open")) {
                document.body.classList.remove("locked");
            }

            setMenuLabel();

            if (restoreFocus) {
                menuButton?.focus();
            }
        };

        const openSidebar = () => {
            if (!sidebar) return;

            sidebar.classList.add("open");
            overlay?.classList.add("show");
            document.body.classList.add("locked");

            setMenuLabel();

            window.setTimeout(() => {
                closeButton?.focus();
            }, 50);
        };

        const toggleDesktopSidebar = () => {
            const collapsed =
                document.body.classList.toggle("sidebar-collapsed");

            try {
                localStorage.setItem(
                    "dispusardaSidebarCollapsed",
                    collapsed ? "1" : "0",
                );
            } catch (_) {
                //
            }

            setMenuLabel();
        };

        if (desktopQuery.matches) {
            try {
                document.body.classList.toggle(
                    "sidebar-collapsed",
                    localStorage.getItem("dispusardaSidebarCollapsed") === "1",
                );
            } catch (_) {
                //
            }
        }

        menuButton?.addEventListener("click", () => {
            if (desktopQuery.matches) {
                toggleDesktopSidebar();
            } else if (sidebar?.classList.contains("open")) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        closeButton?.addEventListener("click", () => closeSidebar(true));

        overlay?.addEventListener("click", () => closeSidebar(true));

        /*
    |--------------------------------------------------------------------------
    | Sidebar submenu
    |--------------------------------------------------------------------------
    */

        qsa("[data-nav-toggle]").forEach((button) => {
            const target = qs(`#${button.dataset.navToggle}`);

            button.setAttribute("aria-controls", button.dataset.navToggle);

            button.addEventListener("click", () => {
                if (
                    desktopQuery.matches &&
                    document.body.classList.contains("sidebar-collapsed")
                ) {
                    document.body.classList.remove("sidebar-collapsed");

                    try {
                        localStorage.setItem("dispusardaSidebarCollapsed", "0");
                    } catch (_) {
                        //
                    }

                    setMenuLabel();
                }

                const expanded =
                    button.getAttribute("aria-expanded") === "true";

                button.setAttribute("aria-expanded", String(!expanded));

                target?.classList.toggle("open", !expanded);
            });
        });

        qsa(".nav-sub a.active").forEach((activeLink) => {
            const sub = activeLink.closest(".nav-sub");

            if (!sub) return;

            sub.classList.add("open");

            const toggle = qs(`[data-nav-toggle="${sub.id}"]`);

            toggle?.classList.add("active");

            toggle?.setAttribute("aria-expanded", "true");
        });

        /*
    |--------------------------------------------------------------------------
    | User Dropdown
    |--------------------------------------------------------------------------
    */

        const userTrigger = qs("#userTrigger");

        const userDropdown = qs("#userDropdown");

        const closeUserMenu = () => {
            userDropdown?.classList.remove("open");

            userTrigger?.setAttribute("aria-expanded", "false");
        };

        userTrigger?.addEventListener("click", (event) => {
            event.stopPropagation();

            const open = userDropdown?.classList.toggle("open");

            userTrigger.setAttribute("aria-expanded", String(Boolean(open)));
        });

        document.addEventListener("click", (event) => {
            if (!event.target.closest(".user-menu")) {
                closeUserMenu();
            }
        });

        /*
    |--------------------------------------------------------------------------
    | LOGOUT LARAVEL
    |--------------------------------------------------------------------------
    |
    | Tidak lagi redirect ke login.html.
    | Submit form POST Laravel agar session
    | dihapus di server.
    |
    */

        qs("[data-logout]")?.addEventListener("click", () => {
            notify({
                title: "Keluar dari aplikasi?",
                text: "Sesi administrator akan diakhiri dengan aman.",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Ya, keluar",
                cancelButtonText: "Batal",
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                const logoutForm = qs("#panelLogoutForm");

                if (!logoutForm) {
                    console.error("Form #panelLogoutForm tidak ditemukan.");

                    notify({
                        title: "Logout gagal",
                        text: "Form logout tidak ditemukan pada halaman.",
                        icon: "error",
                        confirmButtonText: "Tutup",
                    });

                    return;
                }

                logoutForm.requestSubmit();
            });
        });

        /*
    |--------------------------------------------------------------------------
    | Keyboard
    |--------------------------------------------------------------------------
    */

        document.addEventListener("keydown", (event) => {
            if (event.key !== "Escape") {
                return;
            }

            if (!desktopQuery.matches && sidebar?.classList.contains("open")) {
                closeSidebar(true);
                return;
            }

            if (userDropdown?.classList.contains("open")) {
                closeUserMenu();
                userTrigger?.focus();
            }
        });

        const syncResponsiveState = () => {
            if (desktopQuery.matches) {
                closeSidebar();

                try {
                    document.body.classList.toggle(
                        "sidebar-collapsed",
                        localStorage.getItem("dispusardaSidebarCollapsed") ===
                            "1",
                    );
                } catch (_) {
                    //
                }
            } else {
                document.body.classList.remove("sidebar-collapsed");

                closeSidebar();
            }

            setMenuLabel();
        };

        window.addEventListener("resize", syncResponsiveState);

        setMenuLabel();
    }

    /*
  |--------------------------------------------------------------------------
  | Login Laravel
  |--------------------------------------------------------------------------
  |
  | PENTING:
  | Tidak menggunakan preventDefault().
  | Tidak redirect manual ke index.html.
  |
  | Setelah submit, browser akan POST ke:
  |
  | route('panel.login.store')
  |
  | Kemudian Controller Laravel menentukan
  | redirect ke panel.beranda.
  |
  */

    function setupLogin() {
        const form = qs("#loginForm");

        const forgot = qs("[data-forgot-password]");

        forgot?.addEventListener("click", (event) => {
            event.preventDefault();

            notify({
                title: "Lupa password?",
                text: "Silakan hubungi administrator sistem untuk melakukan pengaturan ulang password.",
                icon: "info",
                confirmButtonText: "Mengerti",
            });
        });

        if (!form) return;

        form.addEventListener("submit", () => {
            const submit = qs('button[type="submit"]', form);

            if (!submit) return;

            /*
             * Jangan gunakan preventDefault().
             *
             * Form harus tetap dikirim
             * ke Laravel Controller.
             */

            submit.disabled = true;

            submit.innerHTML =
                '<i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i> Memeriksa akun';
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Password Toggle
  |--------------------------------------------------------------------------
  */

    function setupPasswordToggles() {
        qsa("[data-password-toggle]").forEach((button) => {
            button.addEventListener("click", () => {
                const input = qs(`#${button.dataset.passwordToggle}`);

                if (!input) return;

                const visible = input.type === "text";

                input.type = visible ? "password" : "text";

                button.innerHTML = `<i class="fa-solid ${
                    visible ? "fa-eye" : "fa-eye-slash"
                }" aria-hidden="true"></i>`;

                button.setAttribute(
                    "aria-label",
                    visible ? "Tampilkan password" : "Sembunyikan password",
                );
            });
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Helpers
  |--------------------------------------------------------------------------
  */

    function parseValue(text, type) {
        const value = String(text || "").trim();

        if (type === "number") {
            return Number(value.replace(/[^0-9.-]/g, "")) || 0;
        }

        if (type === "date") {
            const parts = value.split(/[\s/-]/).filter(Boolean);

            if (parts.length === 3 && parts[0].length <= 2) {
                return (
                    new Date(`${parts[2]}-${parts[1]}-${parts[0]}`).getTime() ||
                    0
                );
            }

            return new Date(value).getTime() || 0;
        }

        return value.toLocaleLowerCase("id-ID");
    }

    /*
  |--------------------------------------------------------------------------
  | Local Tables
  |--------------------------------------------------------------------------
  */

    function getTableControls(table) {
        const wrapper =
            table.closest("[data-table-wrapper]") || table.parentElement;

        return {
            wrapper,
            search: qs("[data-table-search]", wrapper || document),
            rowsSelect: qs("[data-table-rows]", wrapper || document),
            info: qs("[data-table-info]", wrapper || document),
            pagination: qs("[data-table-pagination]", wrapper || document),
            empty: qs("[data-table-empty]", wrapper || document),
            tbody: qs("tbody", table),
        };
    }

    function debounce(callback, wait = 300) {
        let timer = null;

        return (...args) => {
            window.clearTimeout(timer);
            timer = window.setTimeout(() => callback(...args), wait);
        };
    }

    /*
     * Pagination O(1).
     * Tidak melakukan loop dari halaman 1 sampai jutaan halaman.
     */
    function renderCompactPagination(pagination, page, pageCount, onChange) {
        if (!pagination) return;

        pagination.innerHTML = "";

        if (pageCount < 1) return;

        const makeButton = (label, target, options = {}) => {
            const button = document.createElement("button");

            button.type = "button";
            button.className = `page-btn${options.active ? " active" : ""}`;
            button.innerHTML = label;
            button.disabled = Boolean(options.disabled);
            button.setAttribute(
                "aria-label",
                options.aria || `Halaman ${target}`,
            );

            if (options.active) {
                button.setAttribute("aria-current", "page");
            }

            button.addEventListener("click", () => {
                if (!options.disabled && target !== page) {
                    onChange(target);
                }
            });

            pagination.appendChild(button);
        };

        makeButton(
            '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
            Math.max(1, page - 1),
            {
                disabled: page <= 1,
                aria: "Halaman sebelumnya",
            },
        );

        const pages = Array.from(
            new Set([1, pageCount, page - 1, page, page + 1]),
        )
            .filter((number) => number >= 1 && number <= pageCount)
            .sort((a, b) => a - b);

        let previous = 0;

        pages.forEach((number) => {
            if (previous && number - previous > 1) {
                const dots = document.createElement("span");
                dots.textContent = "…";
                dots.style.padding = "0 3px";
                pagination.appendChild(dots);
            }

            makeButton(String(number), number, {
                active: number === page,
            });

            previous = number;
        });

        makeButton(
            '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
            Math.min(pageCount, page + 1),
            {
                disabled: page >= pageCount,
                aria: "Halaman berikutnya",
            },
        );
    }

    function syncTableStatusButtons(table) {
        const headers = qsa("thead th", table);
        const statusIndex = headers.findIndex(
            (item) =>
                item.textContent.trim().toLocaleLowerCase("id-ID") === "status",
        );

        if (statusIndex < 0) return;

        qsa("tbody tr", table).forEach((row) => {
            const badge = qs(
                "[data-status-badge], .badge",
                row.cells[statusIndex],
            );
            const button = qs("[data-toggle-status]", row);

            if (!badge || !button) return;

            const active = badge.classList.contains("badge-active");
            const icon = qs("i", button);

            if (icon) {
                icon.classList.toggle("fa-toggle-on", active);
                icon.classList.toggle("fa-toggle-off", !active);
            }

            button.setAttribute(
                "aria-label",
                `Ubah status, saat ini ${badge.textContent.trim()}`,
            );
        });
    }

    function setupTableActions(table, wrapper, onRowChanged = null) {
        wrapper?.addEventListener("click", (event) => {
            const deleteButton = event.target.closest("[data-delete]");

            if (deleteButton) {
                const form = deleteButton.closest(".delete-form");

                notify({
                    title: "Hapus data ini?",
                    text: "Data akan dihapus secara permanen.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#dc3e53",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form?.submit();
                    }
                });

                return;
            }

            const statusButton = event.target.closest("[data-toggle-status]");

            if (!statusButton) return;

            const row = statusButton.closest("tr");
            const headers = qsa("thead th", table);
            const statusIndex = headers.findIndex(
                (item) =>
                    item.textContent.trim().toLocaleLowerCase("id-ID") ===
                    "status",
            );

            const badge =
                statusIndex >= 0
                    ? qs("[data-status-badge], .badge", row?.cells[statusIndex])
                    : null;

            if (!badge) {
                toast(
                    "Kolom status tidak ditemukan pada tabel ini.",
                    "warning",
                );
                return;
            }

            const isActive = badge.classList.contains("badge-active");

            badge.classList.remove(
                "badge-active",
                "badge-draft",
                "badge-inactive",
            );
            badge.classList.add(isActive ? "badge-inactive" : "badge-active");
            badge.textContent = isActive ? "Nonaktif" : "Aktif";

            const toggleIcon = qs("i", statusButton);

            if (toggleIcon) {
                toggleIcon.classList.toggle("fa-toggle-on", !isActive);
                toggleIcon.classList.toggle("fa-toggle-off", isActive);
            }

            statusButton.setAttribute(
                "aria-label",
                `Ubah status, saat ini ${badge.textContent}`,
            );

            onRowChanged?.(row);
            toast(`Status diubah menjadi ${badge.textContent}.`, "success");
        });
    }

    /*
     * MODE LOKAL
     * Cocok untuk data kecil/menengah yang memang sudah ada di DOM.
     * Search text dicache dan render hanya menyentuh row halaman aktif.
     */
    function setupLocalTable(table) {
        const { wrapper, search, rowsSelect, info, pagination, empty, tbody } =
            getTableControls(table);

        if (!tbody) return;

        let allRows = qsa("tr", tbody);
        let query = "";
        let page = 1;
        let perPage = Math.max(1, Number(rowsSelect?.value || 5));
        let sortIndex = -1;
        let sortDirection = "ascending";
        let visibleRows = [];

        const searchCache = new WeakMap();

        const indexRow = (row) => {
            searchCache.set(row, row.textContent.toLocaleLowerCase("id-ID"));
        };

        allRows.forEach((row) => {
            indexRow(row);
            row.hidden = true;
        });

        const filteredRows = () => {
            if (!query) return allRows;

            return allRows.filter((row) =>
                (searchCache.get(row) || "").includes(query),
            );
        };

        function render() {
            const filtered = filteredRows();
            const pageCount = Math.ceil(filtered.length / perPage);

            if (pageCount > 0 && page > pageCount) page = pageCount;
            if (pageCount === 0) page = 1;

            visibleRows.forEach((row) => {
                row.hidden = true;
            });

            const start = (page - 1) * perPage;
            visibleRows = filtered.slice(start, start + perPage);

            visibleRows.forEach((row) => {
                row.hidden = false;
            });

            if (info) {
                info.textContent = filtered.length
                    ? `Menampilkan ${start + 1}–${Math.min(
                          start + perPage,
                          filtered.length,
                      )} dari ${filtered.length.toLocaleString("id-ID")} data`
                    : "Tidak ada data yang cocok";
            }

            empty?.classList.toggle("show", filtered.length === 0);
            table.style.display = filtered.length ? "" : "none";

            renderCompactPagination(
                pagination,
                page,
                pageCount,
                (targetPage) => {
                    page = targetPage;
                    render();
                },
            );
        }

        const runSearch = debounce(() => {
            query = search?.value.trim().toLocaleLowerCase("id-ID") || "";
            page = 1;
            render();
        }, 180);

        search?.addEventListener("input", runSearch);

        rowsSelect?.addEventListener("change", () => {
            perPage = Math.max(1, Number(rowsSelect.value || 5));
            page = 1;
            render();
        });

        qsa("th[data-sort]", table).forEach((header) => {
            header.setAttribute("tabindex", "0");
            header.setAttribute("role", "button");

            const sort = () => {
                const columnIndex = header.cellIndex;

                sortDirection =
                    sortIndex === columnIndex && sortDirection === "ascending"
                        ? "descending"
                        : "ascending";
                sortIndex = columnIndex;

                qsa("th[data-sort]", table).forEach((item) =>
                    item.removeAttribute("aria-sort"),
                );
                header.setAttribute("aria-sort", sortDirection);

                const type = header.dataset.sort || "text";

                allRows.sort((a, b) => {
                    const aCell = a.cells[columnIndex];
                    const bCell = b.cells[columnIndex];
                    const aValue = parseValue(
                        aCell?.dataset.sortValue || aCell?.textContent,
                        type,
                    );
                    const bValue = parseValue(
                        bCell?.dataset.sortValue || bCell?.textContent,
                        type,
                    );

                    if (aValue < bValue) {
                        return sortDirection === "ascending" ? -1 : 1;
                    }
                    if (aValue > bValue) {
                        return sortDirection === "ascending" ? 1 : -1;
                    }
                    return 0;
                });

                // Reorder DOM hanya saat user benar-benar melakukan sort.
                const fragment = document.createDocumentFragment();
                allRows.forEach((row) => fragment.appendChild(row));
                tbody.appendChild(fragment);

                page = 1;
                render();
            };

            header.addEventListener("click", sort);
            header.addEventListener("keydown", (event) => {
                if (event.key === "Enter" || event.key === " ") {
                    event.preventDefault();
                    sort();
                }
            });
        });

        setupTableActions(table, wrapper, indexRow);
        syncTableStatusButtons(table);
        render();
    }

    /*
     * MODE SERVER / BIG DATA
     * Wajib dipakai untuk ratusan ribu, jutaan, bahkan miliaran record.
     * Browser hanya menerima baris untuk halaman yang sedang dilihat.
     *
     * Aktifkan dengan:
     *   <table data-table data-table-endpoint="/panel/data/table">
     *
     * Response JSON endpoint minimal:
     * {
     *   "rows_html": "<tr>...</tr>",
     *   "total": 12500000,
     *   "page": 1,
     *   "per_page": 25,
     *   "last_page": 500000
     * }
     *
     * Untuk sort server gunakan:
     *   <th data-sort-key="nama">Nama</th>
     */
    function setupServerTable(table, endpoint) {
        const { wrapper, search, rowsSelect, info, pagination, empty, tbody } =
            getTableControls(table);

        if (!tbody || !endpoint) return;

        const paginationMode =
            table.dataset.tablePaginationMode ||
            wrapper?.dataset.tablePaginationMode ||
            "page";

        let page = 1;
        let cursor = "";
        let cursorPage = 1;
        let perPage = Math.max(1, Number(rowsSelect?.value || 25));
        let query = search?.value.trim() || "";
        let sortKey = "";
        let sortDirection = "asc";
        let controller = null;
        let requestId = 0;

        const resetPosition = () => {
            page = 1;
            cursor = "";
            cursorPage = 1;
        };

        const setLoading = (loading) => {
            wrapper?.classList.toggle("is-loading", loading);
            table.setAttribute("aria-busy", String(loading));

            if (search)
                search.disabled = loading && tbody.children.length === 0;
            if (rowsSelect) {
                rowsSelect.disabled = loading && tbody.children.length === 0;
            }
        };

        const normalizePayload = (payload) => {
            const meta = payload.meta || payload.pagination || payload;

            let rowsHtml =
                payload.rows_html ?? payload.tbody_html ?? payload.html ?? null;

            if (rowsHtml == null && Array.isArray(payload.data)) {
                if (payload.data.every((item) => typeof item === "string")) {
                    rowsHtml = payload.data.join("");
                } else if (
                    payload.data.every(
                        (item) => item && typeof item.row_html === "string",
                    )
                ) {
                    rowsHtml = payload.data
                        .map((item) => item.row_html)
                        .join("");
                }
            }

            if (rowsHtml == null) {
                throw new Error(
                    "Endpoint tabel harus mengirim rows_html/html atau data[].row_html.",
                );
            }

            const totalRaw = meta.total ?? payload.total ?? null;
            const total =
                totalRaw == null ? null : Math.max(0, Number(totalRaw) || 0);
            const currentPage = Math.max(
                1,
                Number(
                    meta.current_page ??
                        meta.page ??
                        payload.current_page ??
                        payload.page ??
                        page,
                ),
            );
            const responsePerPage = Math.max(
                1,
                Number(meta.per_page ?? payload.per_page ?? perPage),
            );
            const lastPage = Math.max(
                1,
                Number(
                    meta.last_page ??
                        payload.last_page ??
                        (total == null
                            ? currentPage
                            : Math.ceil(total / responsePerPage) || 1),
                ),
            );
            const nextCursor =
                meta.next_cursor ??
                payload.next_cursor ??
                payload.nextCursor ??
                null;
            const prevCursor =
                meta.prev_cursor ??
                payload.prev_cursor ??
                payload.prevCursor ??
                null;

            return {
                rowsHtml,
                total,
                currentPage,
                responsePerPage,
                lastPage,
                nextCursor,
                prevCursor,
            };
        };

        const renderCursorPagination = (result) => {
            if (!pagination) return;

            pagination.innerHTML = "";

            const makeButton = (label, disabled, onClick, aria) => {
                const button = document.createElement("button");
                button.type = "button";
                button.className = "page-btn";
                button.innerHTML = label;
                button.disabled = disabled;
                button.setAttribute("aria-label", aria);
                button.addEventListener("click", onClick);
                pagination.appendChild(button);
            };

            makeButton(
                '<i class="fa-solid fa-chevron-left" aria-hidden="true"></i>',
                !result.prevCursor,
                () => {
                    if (!result.prevCursor) return;
                    cursor = result.prevCursor;
                    cursorPage = Math.max(1, cursorPage - 1);
                    load();
                },
                "Halaman sebelumnya",
            );

            const current = document.createElement("span");
            current.className = "page-btn active";
            current.setAttribute("aria-current", "page");
            current.textContent = cursorPage.toLocaleString("id-ID");
            pagination.appendChild(current);

            makeButton(
                '<i class="fa-solid fa-chevron-right" aria-hidden="true"></i>',
                !result.nextCursor,
                () => {
                    if (!result.nextCursor) return;
                    cursor = result.nextCursor;
                    cursorPage += 1;
                    load();
                },
                "Halaman berikutnya",
            );
        };

        const load = async () => {
            requestId += 1;
            const thisRequest = requestId;

            controller?.abort();
            controller = new AbortController();

            const url = new URL(endpoint, window.location.href);
            url.searchParams.set("per_page", String(perPage));

            if (paginationMode === "cursor") {
                if (cursor) url.searchParams.set("cursor", cursor);
            } else {
                url.searchParams.set("page", String(page));
            }

            if (query) url.searchParams.set("search", query);
            if (sortKey) {
                url.searchParams.set("sort", sortKey);
                url.searchParams.set("direction", sortDirection);
            }

            setLoading(true);

            try {
                const response = await fetch(url.toString(), {
                    method: "GET",
                    headers: {
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    signal: controller.signal,
                    credentials: "same-origin",
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }

                const payload = await response.json();

                if (thisRequest !== requestId) return;

                const result = normalizePayload(payload);

                page = result.currentPage;
                perPage = result.responsePerPage;
                tbody.innerHTML = result.rowsHtml;

                const rowCount = tbody.children.length;
                const hasRows = rowCount > 0;

                if (info) {
                    if (!hasRows) {
                        info.textContent = "Tidak ada data yang cocok";
                    } else if (
                        result.total != null &&
                        paginationMode !== "cursor"
                    ) {
                        const start = (page - 1) * perPage + 1;
                        const end = Math.min(
                            start + rowCount - 1,
                            result.total,
                        );

                        info.textContent = `Menampilkan ${start.toLocaleString(
                            "id-ID",
                        )}–${end.toLocaleString("id-ID")} dari ${result.total.toLocaleString(
                            "id-ID",
                        )} data`;
                    } else {
                        info.textContent = `Menampilkan ${rowCount.toLocaleString(
                            "id-ID",
                        )} data • Halaman ${cursorPage.toLocaleString("id-ID")}`;
                    }
                }

                empty?.classList.toggle("show", !hasRows);
                table.style.display = hasRows ? "" : "none";

                if (paginationMode === "cursor") {
                    renderCursorPagination(result);
                } else {
                    renderCompactPagination(
                        pagination,
                        page,
                        result.lastPage,
                        (targetPage) => {
                            page = targetPage;
                            load();
                        },
                    );
                }

                syncTableStatusButtons(table);
            } catch (error) {
                if (error?.name === "AbortError") return;

                console.error("Gagal memuat tabel server:", error);

                if (info) {
                    info.textContent = "Gagal memuat data. Silakan coba lagi.";
                }

                toast("Gagal memuat data tabel.", "error");
            } finally {
                if (thisRequest === requestId) setLoading(false);
            }
        };

        const runSearch = debounce(() => {
            query = search?.value.trim() || "";
            resetPosition();
            load();
        }, 320);

        search?.addEventListener("input", runSearch);

        rowsSelect?.addEventListener("change", () => {
            perPage = Math.max(1, Number(rowsSelect.value || 25));
            resetPosition();
            load();
        });

        qsa("th[data-sort-key], th[data-sort-field]", table).forEach(
            (header) => {
                header.setAttribute("tabindex", "0");
                header.setAttribute("role", "button");

                const sort = () => {
                    const nextKey =
                        header.dataset.sortKey ||
                        header.dataset.sortField ||
                        "";

                    if (!nextKey) return;

                    if (sortKey === nextKey) {
                        sortDirection =
                            sortDirection === "asc" ? "desc" : "asc";
                    } else {
                        sortKey = nextKey;
                        sortDirection = "asc";
                    }

                    qsa(
                        "th[data-sort-key], th[data-sort-field]",
                        table,
                    ).forEach((item) => item.removeAttribute("aria-sort"));
                    header.setAttribute(
                        "aria-sort",
                        sortDirection === "asc" ? "ascending" : "descending",
                    );

                    resetPosition();
                    load();
                };

                header.addEventListener("click", sort);
                header.addEventListener("keydown", (event) => {
                    if (event.key === "Enter" || event.key === " ") {
                        event.preventDefault();
                        sort();
                    }
                });
            },
        );

        setupTableActions(table, wrapper);
        load();
    }

    function setupTables() {
        qsa("[data-table]").forEach((table) => {
            const wrapper =
                table.closest("[data-table-wrapper]") || table.parentElement;
            const endpoint =
                table.dataset.tableEndpoint ||
                wrapper?.dataset.tableEndpoint ||
                "";

            if (endpoint) {
                setupServerTable(table, endpoint);
            } else {
                setupLocalTable(table);
            }
        });

        qsa("[data-export-pdf]").forEach((button) => {
            button.addEventListener("click", () => {
                notify({
                    title: "Siapkan dokumen PDF?",
                    text: "Dialog cetak browser akan dibuka. Pilih “Simpan sebagai PDF”.",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonText: "Lanjutkan",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.print();
                    }
                });
            });
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Slug
  |--------------------------------------------------------------------------
  */

    function slugify(value) {
        return value
            .toString()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, "")
            .replace(/[\s_-]+/g, "-")
            .replace(/^-+|-+$/g, "");
    }

    /*
  |--------------------------------------------------------------------------
  | Google Drive Preview
  |--------------------------------------------------------------------------
  */

    function getGoogleDrivePreviewUrl(value) {
        const raw = String(value || "").trim();

        if (!raw) return null;

        let url;

        try {
            url = new URL(raw);
        } catch (_) {
            return null;
        }

        const host = url.hostname.toLowerCase();

        const isDriveHost =
            host === "drive.google.com" || host.endsWith(".drive.google.com");

        const isDocsHost =
            host === "docs.google.com" || host.endsWith(".docs.google.com");

        if (!isDriveHost && !isDocsHost) {
            return null;
        }

        const path = url.pathname;

        const fileMatch = path.match(/\/file\/d\/([^/]+)/i);

        const docsMatch = path.match(
            /\/(?:document|spreadsheets|presentation|forms)\/d\/([^/]+)/i,
        );

        const genericDMatch = path.match(/\/d\/([^/]+)/i);

        const folderMatch = path.match(/\/(?:drive\/)?folders\/([^/]+)/i);

        const id =
            url.searchParams.get("id") ||
            fileMatch?.[1] ||
            docsMatch?.[1] ||
            genericDMatch?.[1];

        if (folderMatch?.[1]) {
            return (
                "https://drive.google.com/embeddedfolderview?id=" +
                encodeURIComponent(folderMatch[1]) +
                "#grid"
            );
        }

        if (!id) return null;

        if (isDocsHost && /\/document\/d\//i.test(path)) {
            return (
                "https://docs.google.com/document/d/" +
                encodeURIComponent(id) +
                "/preview"
            );
        }

        if (isDocsHost && /\/spreadsheets\/d\//i.test(path)) {
            return (
                "https://docs.google.com/spreadsheets/d/" +
                encodeURIComponent(id) +
                "/preview"
            );
        }

        if (isDocsHost && /\/presentation\/d\//i.test(path)) {
            return (
                "https://docs.google.com/presentation/d/" +
                encodeURIComponent(id) +
                "/preview"
            );
        }

        return (
            "https://drive.google.com/file/d/" +
            encodeURIComponent(id) +
            "/preview"
        );
    }

    function setupGoogleDrivePreview() {
        const input = qs("#link_google_drive");

        const preview = qs("#drivePreview");

        const frame = qs("#drivePreviewFrame");

        const open = qs("#drivePreviewOpen");

        const message = qs("#drivePreviewMessage");

        if (!input || !preview || !frame || !open) {
            return;
        }

        let timer;

        const render = () => {
            const raw = input.value.trim();

            if (!raw) {
                preview.classList.remove("is-visible", "is-error");

                frame.removeAttribute("src");

                open.setAttribute("href", "#");

                return;
            }

            const previewUrl = getGoogleDrivePreviewUrl(raw);

            preview.classList.add("is-visible");

            open.href = raw;

            if (!previewUrl) {
                preview.classList.add("is-error");

                frame.removeAttribute("src");

                if (message) {
                    message.textContent =
                        "Tautan belum dikenali sebagai Link Google Drive. Gunakan link file/folder dari Google Drive.";
                }

                return;
            }

            preview.classList.remove("is-error");

            frame.src = previewUrl;
        };

        input.addEventListener("input", () => {
            window.clearTimeout(timer);

            timer = window.setTimeout(render, 280);
        });

        input.addEventListener("change", render);

        render();
    }

    /*
  |--------------------------------------------------------------------------
  | Forms
  |--------------------------------------------------------------------------
  */

    function setupForms() {
        setupGoogleDrivePreview();

        const title = qs("[data-slug-source]");

        const slug = qs("[data-slug-target]");

        title?.addEventListener("input", () => {
            if (slug && !slug.dataset.touched) {
                slug.value = slugify(title.value);
            }
        });

        slug?.addEventListener("input", () => {
            slug.dataset.touched = "true";
        });

        qsa("[data-upload]").forEach((input) => {
            input.addEventListener("change", () => {
                const box = input.closest(".upload-box");

                const preview = qs(".upload-preview", box);

                const file = input.files?.[0];

                if (!file || !preview) {
                    return;
                }

                if (file.type && !file.type.startsWith("image/")) {
                    return;
                }

                const reader = new FileReader();

                reader.onload = (event) => {
                    preview.src = event.target.result;

                    box.classList.add("has-preview");

                    preview.alt = `Pratinjau ${file.name}`;
                };

                reader.readAsDataURL(file);
            });
        });

        qsa('input[name="konfirmasi_password"]').forEach((confirmInput) => {
            const form = confirmInput.closest("form");

            const passwordInput = qs('input[name="password_baru"]', form);

            if (!passwordInput) {
                return;
            }

            const validateMatch = () => {
                const mismatch =
                    confirmInput.value &&
                    confirmInput.value !== passwordInput.value;

                confirmInput.setCustomValidity(
                    mismatch ? "Konfirmasi password tidak sama." : "",
                );
            };

            passwordInput.addEventListener("input", validateMatch);

            confirmInput.addEventListener("input", validateMatch);
        });

        const params = new URLSearchParams(window.location.search);

        if (params.get("mode") === "edit") {
            const form = qs("form[data-demo-form]");

            const password = qs('input[name="password_baru"]', form);

            const confirmPassword = qs(
                'input[name="konfirmasi_password"]',
                form,
            );

            if (
                password &&
                confirmPassword &&
                /users$/i.test(form?.dataset.endpoint || "")
            ) {
                password.required = false;

                confirmPassword.required = false;

                [password, confirmPassword].forEach((input) => {
                    const label = qs(`label[for="${input.id}"]`, form);

                    label?.querySelector(".required")?.remove();
                });

                password.placeholder = "Kosongkan jika tidak diubah";

                confirmPassword.placeholder =
                    "Ulangi hanya jika password diubah";

                const badge = qs(".form-card .card-head .badge");

                if (badge) {
                    badge.className = "badge badge-active";

                    badge.textContent = "Mode edit";
                }
            }
        }

        /*
         * Form demo tetap dipertahankan.
         * Login tidak menggunakan data-demo-form.
         */

        qsa("form[data-demo-form]").forEach((form) => {
            form.addEventListener("submit", (event) => {
                event.preventDefault();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const submit = qs('button[type="submit"]', form);

                const original = submit?.innerHTML;

                if (submit) {
                    submit.disabled = true;

                    submit.innerHTML =
                        '<i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i> Menyimpan';
                }

                window.setTimeout(() => {
                    if (submit) {
                        submit.disabled = false;

                        submit.innerHTML = original;
                    }

                    notify({
                        title: "Data berhasil disimpan",
                        text: "Tampilan ini menggunakan data simulasi. Sambungkan action formulir ke endpoint backend Anda.",
                        icon: "success",
                        confirmButtonText: "Selesai",
                    });
                }, 550);
            });
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Modals
  |--------------------------------------------------------------------------
  */

    function setupModals() {
        let opener = null;

        const focusable = (modal) =>
            qsa(
                'button:not(:disabled), [href], input:not(:disabled), select:not(:disabled), textarea:not(:disabled), [tabindex]:not([tabindex="-1"])',
                modal,
            ).filter((item) => item.offsetParent !== null);

        const close = (modal, restoreFocus = true) => {
            if (!modal) return;

            modal.classList.remove("open");

            modal.setAttribute("aria-hidden", "true");

            if (!qs("#sidebar.open") || window.innerWidth > 860) {
                document.body.classList.remove("locked");
            }

            if (restoreFocus) {
                opener?.focus();
            }

            opener = null;
        };

        qsa("[data-modal-open]").forEach((button) => {
            button.setAttribute("aria-haspopup", "dialog");

            button.addEventListener("click", () => {
                const modal = qs(`#${button.dataset.modalOpen}`);

                if (!modal) return;

                opener = button;

                const mode = button.dataset.modalMode || "create";

                const modalTitle = qs("[data-modal-title]", modal);

                if (modalTitle) {
                    modalTitle.textContent =
                        mode === "edit"
                            ? `Edit ${button.dataset.entity || "Data"}`
                            : `Tambah ${button.dataset.entity || "Data"}`;
                }

                modal.classList.add("open");

                modal.setAttribute("aria-hidden", "false");

                document.body.classList.add("locked");

                window.setTimeout(() => focusable(modal)[0]?.focus(), 80);
            });
        });

        qsa(".modal").forEach((modal) => {
            modal.setAttribute("role", "dialog");

            modal.setAttribute("aria-modal", "true");

            qsa("[data-modal-close]", modal).forEach((button) =>
                button.addEventListener("click", () => close(modal)),
            );

            qs(".modal-backdrop", modal)?.addEventListener("click", () =>
                close(modal),
            );

            modal.addEventListener("keydown", (event) => {
                if (event.key !== "Tab") {
                    return;
                }

                const items = focusable(modal);

                if (!items.length) {
                    return;
                }

                const first = items[0];

                const last = items[items.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            });
        });

        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape") {
                close(qs(".modal.open"));
            }
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Account Tabs
  |--------------------------------------------------------------------------
  */

    function setupAccountTabs() {
        const tabs = qsa("[data-account-tab]");

        const panels = qsa("[data-account-panel]");

        if (!tabs.length || !panels.length) {
            return;
        }

        const activate = (name, updateHash = false) => {
            const valid = tabs.some((item) => item.dataset.accountTab === name)
                ? name
                : tabs[0].dataset.accountTab;

            tabs.forEach((item) => {
                const active = item.dataset.accountTab === valid;

                const panelId = `account-panel-${item.dataset.accountTab}`;

                item.id = `account-tab-${item.dataset.accountTab}`;

                item.setAttribute("role", "tab");

                item.setAttribute("aria-controls", panelId);

                item.setAttribute("aria-selected", String(active));

                item.setAttribute("tabindex", active ? "0" : "-1");

                item.classList.toggle("active", active);
            });

            panels.forEach((panel) => {
                const active = panel.dataset.accountPanel === valid;

                panel.id = `account-panel-${panel.dataset.accountPanel}`;

                panel.setAttribute("role", "tabpanel");

                panel.setAttribute(
                    "aria-labelledby",
                    `account-tab-${panel.dataset.accountPanel}`,
                );

                panel.classList.toggle("active", active);

                panel.hidden = !active;
            });

            if (updateHash) {
                history.replaceState(null, "", `#${valid}`);
            }
        };

        tabs.forEach((button, index) => {
            button.addEventListener("click", () =>
                activate(button.dataset.accountTab, true),
            );

            button.addEventListener("keydown", (event) => {
                if (!["ArrowLeft", "ArrowRight"].includes(event.key)) {
                    return;
                }

                event.preventDefault();

                const direction = event.key === "ArrowRight" ? 1 : -1;

                const next =
                    tabs[(index + direction + tabs.length) % tabs.length];

                activate(next.dataset.accountTab, true);

                next.focus();
            });
        });

        activate(
            window.location.hash.replace("#", "") || tabs[0].dataset.accountTab,
        );
    }

    /*
  |--------------------------------------------------------------------------
  | Quick Actions
  |--------------------------------------------------------------------------
  */

    function setupQuickActions() {
        const searchButton = qs(
            '.topbar-actions .icon-btn[aria-label*="Pencarian"]',
        );

        const notificationButton = qs(".topbar-actions .notification-dot");

        const focusPageSearch = () => {
            const search = qs("[data-table-search]");

            if (search) {
                search.focus();
                search.select();
                return;
            }

            notify({
                title: "Pencarian cepat",
                text: "Pencarian tabel tersedia pada halaman daftar data. Buka salah satu modul daftar untuk menggunakannya.",
                icon: "info",
                confirmButtonText: "Tutup",
            });
        };

        searchButton?.addEventListener("click", focusPageSearch);

        notificationButton?.addEventListener("click", () => {
            notify({
                title: "Notifikasi",
                text: "3 pembaruan: berita diperbarui, dokumen PPID diunggah, dan FAQ baru diterbitkan.",
                icon: "info",
                confirmButtonText: "Tutup",
            });
        });

        document.addEventListener("keydown", (event) => {
            if (
                (event.ctrlKey || event.metaKey) &&
                event.key.toLocaleLowerCase("id-ID") === "k"
            ) {
                event.preventDefault();
                focusPageSearch();
            }
        });
    }

    /*
  |--------------------------------------------------------------------------
  | Dashboard Visitor Chart
  |--------------------------------------------------------------------------
  */

    function drawVisitorChart() {
        const target = qs("[data-visitor-chart]");

        if (!target) return;

        const data = window.visitorData || [];

        const labels = window.visitorLabels || [];

        const width = 760;
        const height = 280;

        const pad = {
            top: 18,
            right: 18,
            bottom: 40,
            left: 46,
        };

        const max = Math.max(...data, 10);

        const usableW = width - pad.left - pad.right;

        const usableH = height - pad.top - pad.bottom;

        const points = data.map((value, index) => ({
            x: pad.left + (usableW / Math.max(data.length - 1, 1)) * index,

            y: pad.top + usableH - (value / max) * usableH,

            value,
        }));

        const line = points
            .map((point, index) => `${index ? "L" : "M"} ${point.x} ${point.y}`)
            .join(" ");

        const area =
            `${line} ` +
            `L ${points[points.length - 1].x} ${pad.top + usableH} ` +
            `L ${points[0].x} ${pad.top + usableH} Z`;

        const gridStep = Math.ceil(max / 5);

        const grid = Array.from({ length: 6 }, (_, index) => index * gridStep)
            .map((value) => {
                const y = pad.top + usableH - (value / max) * usableH;

                return `
                    <line
                        x1="${pad.left}"
                        y1="${y}"
                        x2="${width - pad.right}"
                        y2="${y}"
                        stroke="#e9eef6"
                        stroke-width="1"
                    />

                    <text
                        x="${pad.left - 11}"
                        y="${y + 4}"
                        text-anchor="end"
                        fill="#8c98aa"
                        font-size="9"
                    >${value}</text>
                    `;
            })
            .join("");

        const xLabels = labels
            .map(
                (label, index) =>
                    `
            <text
              x="${points[index].x}"
              y="${height - 13}"
              text-anchor="middle"
              fill="#7f8b9e"
              font-size="9"
            >${label}</text>
            `,
            )
            .join("");

        const circles = points
            .map(
                (point, index) =>
                    `
            <g class="chart-point">
              <circle
                cx="${point.x}"
                cy="${point.y}"
                r="4"
                fill="#fff"
                stroke="#1f73e8"
                stroke-width="2"
              >
                <title>
                  ${labels[index]}:
                  ${point.value}
                  kunjungan
                </title>
              </circle>
            </g>
            `,
            )
            .join("");

        target.innerHTML = `
      <svg
        viewBox="0 0 ${width} ${height}"
        role="img"
        aria-label="Grafik kunjungan buku tamu"
        style="width:100%;height:auto;overflow:visible"
      >
        <defs>
          <linearGradient
            id="areaFill"
            x1="0"
            y1="0"
            x2="0"
            y2="1"
          >
            <stop
              offset="0%"
              stop-color="#1f73e8"
              stop-opacity=".28"
            />
            <stop
              offset="100%"
              stop-color="#1f73e8"
              stop-opacity=".02"
            />
          </linearGradient>
        </defs>

        ${grid}
        ${xLabels}

        <path
          d="${area}"
          fill="url(#areaFill)"
        />

        <path
          d="${line}"
          fill="none"
          stroke="#1f73e8"
          stroke-width="3"
          stroke-linecap="round"
          stroke-linejoin="round"
        />

        ${circles}
      </svg>
    `;
    }

    /*
  |--------------------------------------------------------------------------
  | Init
  |--------------------------------------------------------------------------
  */

    document.addEventListener("DOMContentLoaded", () => {
        setupShell();
        setupLogin();
        setupPasswordToggles();
        setupTables();
        setupForms();
        setupModals();
        setupAccountTabs();
        setupQuickActions();
        drawVisitorChart();
    });
})();

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("pamfletForm");
    const submitButton = document.getElementById("submitButton");
    const submitText = document.getElementById("submitText");

    if (!form || !submitButton || !submitText) {
        console.error("Form atau tombol submit tidak ditemukan.");
        return;
    }

    form.addEventListener("submit", function (event) {
        if (!form.checkValidity()) {
            return;
        }

        const icon = submitButton.querySelector("i");

        if (icon) {
            icon.classList.remove("fa-floppy-disk");
            icon.classList.add("fa-spinner", "fa-spin");
        }

        submitText.textContent = "Memproses...";
        submitButton.disabled = true;
    });
});
