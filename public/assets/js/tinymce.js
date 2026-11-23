document.addEventListener("DOMContentLoaded", function () {
    if (typeof tinymce === "undefined") {
        console.error("TinyMCE gagal dimuat.");
        return;
    }

    tinymce.init({
        selector: ".tinymce-editor",
        height: 420,
        menubar: false,
        branding: false,
        promotion: false,
        resize: true,

        plugins: [
            "advlist",
            "autolink",
            "lists",
            "link",
            "image",
            "charmap",
            "preview",
            "anchor",
            "searchreplace",
            "visualblocks",
            "code",
            "fullscreen",
            "insertdatetime",
            "media",
            "table",
            "wordcount",
        ],

        toolbar:
            "undo redo | blocks | fontfamily fontsize | " +
            "bold italic underline | forecolor backcolor | " +
            "alignleft aligncenter alignright alignjustify | " +
            "bullist numlist | link image media table | " +
            "removeformat | fullscreen",

        toolbar_mode: "sliding",

        font_family_formats:
            'Plus Jakarta Sans="Plus Jakarta Sans",sans-serif;' +
            "Poppins=Poppins,sans-serif;" +
            "Arial=arial,helvetica,sans-serif;" +
            "Georgia=georgia,palatino,serif;" +
            "Times New Roman=times new roman,times,serif;" +
            "Verdana=verdana,geneva,sans-serif",

        content_css: [
            "https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap",
        ],

        content_style: `
            body {
                font-family: "Plus Jakarta Sans", Arial, sans-serif;
                font-size: 14px;
                line-height: 1.75;
                color: #172033;
                padding: 18px 20px;
                background: #ffffff;
            }

            p {
                margin: 0 0 12px;
            }

            h1, h2, h3, h4 {
                color: #0f172a;
                font-weight: 700;
            }

            a {
                color: #2563eb;
            }

            img {
                max-width: 100%;
                border-radius: 10px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            table td,
            table th {
                border: 1px solid #e2e8f0;
                padding: 10px;
            }
        `,

        setup: function (editor) {
            editor.on("change input undo redo", function () {
                editor.save();
            });
        },
    });

    document.querySelectorAll("form").forEach(function (form) {
        form.addEventListener("submit", function () {
            tinymce.triggerSave();
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (event) {
        const deleteButton = event.target.closest("[data-berita-delete]");

        if (!deleteButton) {
            return;
        }

        // Cegah form langsung terkirim
        event.preventDefault();
        event.stopPropagation();

        const form = deleteButton.closest("form");

        if (!form) {
            console.error("Form hapus berita tidak ditemukan.");
            return;
        }

        Swal.fire({
            title: "Hapus data?",
            text: "Data yang dihapus tidak dapat dikembalikan.",
            icon: "warning",

            showCancelButton: true,

            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Batal",

            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",

            reverseButtons: true,
            focusCancel: true,
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
