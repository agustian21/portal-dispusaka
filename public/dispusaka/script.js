const menuBtn = document.getElementById("menuBtn");
const closeMenu = document.getElementById("closeMenu");
const panel = document.getElementById("mobilePanel");
const scrim = document.getElementById("scrim");
const menuGroups = [...document.querySelectorAll(".menu-group")];
let lastFocused = null;

function setMenu(open) {
    if (!panel || !scrim || !menuBtn) return;

    panel.classList.toggle("open", open);
    scrim.classList.toggle("show", open);
    panel.setAttribute("aria-hidden", String(!open));
    menuBtn.setAttribute("aria-expanded", String(open));
    document.body.style.overflow = open ? "hidden" : "";

    if (open) {
        lastFocused = document.activeElement;
        requestAnimationFrame(() =>
            panel.querySelector("a, summary, button")?.focus(),
        );
    } else if (lastFocused instanceof HTMLElement) {
        lastFocused.focus();
    }
}

// Accordion: hanya satu submenu terbuka pada satu waktu.
menuGroups.forEach((group) => {
    group.addEventListener("toggle", () => {
        if (!group.open) return;
        menuGroups.forEach((other) => {
            if (other !== group) other.open = false;
        });
    });
});

menuBtn?.addEventListener("click", () => setMenu(true));
closeMenu?.addEventListener("click", () => setMenu(false));
scrim?.addEventListener("click", () => setMenu(false));

panel?.querySelectorAll("a").forEach((a) => {
    a.addEventListener("click", () => setMenu(false));
});

// Menjaga fokus keyboard tetap berada di panel saat menu terbuka.
panel?.addEventListener("keydown", (e) => {
    if (e.key !== "Tab" || !panel.classList.contains("open")) return;
    const focusable = [
        ...panel.querySelectorAll("a[href], summary, button:not([disabled])"),
    ].filter((el) => el.offsetParent !== null);
    if (!focusable.length) return;

    const first = focusable[0];
    const last = focusable[focusable.length - 1];
    if (e.shiftKey && document.activeElement === first) {
        e.preventDefault();
        last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
        e.preventDefault();
        first.focus();
    }
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") setMenu(false);
});

// Multipage enhancement: active page is set in HTML, while grouped menus stay open when needed.
const currentPage =
    document.body.dataset.page ||
    location.pathname.split("/").pop() ||
    "index.html";
document.querySelectorAll(".panel-nav a[href]").forEach((link) => {
    const href = link.getAttribute("href");
    if (href === currentPage) link.classList.add("active");
});
document.querySelectorAll(".menu-group").forEach((group) => {
    if (group.querySelector("a.active")) group.open = true;
});

// Aksesibilitas: pembaca suara saat kursor diarahkan ke teks.
// Aktif menggunakan Web Speech API pada browser yang mendukung.
(function initHoverVoiceAccessibility() {
    if (!("speechSynthesis" in window)) return;

    let lastText = "";
    let timer;
    let voiceEnabled = false;

    const voiceToggle = document.getElementById("voiceToggle");
    const accessibilityToggle = document.getElementById("accessibilityToggle");
    const voicePanel = document.getElementById("voicePanel");

    accessibilityToggle?.addEventListener("click", () => {
        const open = voicePanel.hidden;
        voicePanel.hidden = !open;
        accessibilityToggle.setAttribute("aria-expanded", String(open));
    });

    voiceToggle?.addEventListener("click", () => {
        voiceEnabled = !voiceEnabled;
        voiceToggle.setAttribute("aria-pressed", String(voiceEnabled));
        voiceToggle.setAttribute(
            "aria-label",
            voiceEnabled ? "Matikan Text to Speech" : "Aktifkan Text to Speech",
        );
        voiceToggle.querySelector("span").textContent = voiceEnabled
            ? "Matikan Text to Speech"
            : "Aktifkan Text to Speech";
        voiceToggle.querySelector("i").className = voiceEnabled
            ? "fa-solid fa-volume-high"
            : "fa-solid fa-volume-xmark";
        if (!voiceEnabled) window.speechSynthesis.cancel();
    });

    const speakText = (text) => {
        text = text.replace(/\s+/g, " ").trim();
        if (!voiceEnabled || !text || text === lastText) return;

        lastText = text;
        window.speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = "id-ID";
        utterance.rate = 1;
        utterance.pitch = 1;
        window.speechSynthesis.speak(utterance);
    };

    document.addEventListener("mouseover", (event) => {
        const target = event.target.closest(
            "h1,h2,h3,p,a,button,span,strong,small,li,label",
        );
        if (!target) return;

        clearTimeout(timer);
        timer = setTimeout(() => {
            speakText(target.innerText || target.textContent || "");
        }, 400);
    });

    document.addEventListener("mouseout", () => {
        clearTimeout(timer);
    });
})();
