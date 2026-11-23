const menuToggle = document.getElementById("menuToggle");
const navMenu = document.getElementById("navMenu");
const backTop = document.getElementById("backTop");
const dropdowns = document.querySelectorAll(".has-dropdown");

if (menuToggle && navMenu) {
    menuToggle.addEventListener("click", () => {
        navMenu.classList.toggle("open");
        menuToggle.innerHTML = navMenu.classList.contains("open")
            ? '<i class="fa-solid fa-xmark"></i>'
            : '<i class="fa-solid fa-bars"></i>';
    });
}

dropdowns.forEach((item) => {
    const toggle = item.querySelector(".dropdown-toggle");
    toggle.addEventListener("click", (e) => {
        e.stopPropagation();
        const willOpen = !item.classList.contains("open");
        dropdowns.forEach((other) => {
            if (other !== item) {
                other.classList.remove("open");
                other
                    .querySelector(".dropdown-toggle")
                    ?.setAttribute("aria-expanded", "false");
            }
        });
        item.classList.toggle("open", willOpen);
        toggle.setAttribute("aria-expanded", willOpen ? "true" : "false");
    });
});

document.addEventListener("click", (e) => {
    if (!e.target.closest(".has-dropdown")) {
        dropdowns.forEach((item) => {
            item.classList.remove("open");
            item.querySelector(".dropdown-toggle")?.setAttribute(
                "aria-expanded",
                "false",
            );
        });
    }
});

document.querySelectorAll(".nav-menu a").forEach((link) => {
    link.addEventListener("click", () => {
        if (window.innerWidth <= 1180) {
            navMenu.classList.remove("open");
            menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
        }
    });
});

const carousel = document.getElementById("heroCarousel");
const slides = [...document.querySelectorAll(".hero-slide")];
const dots = [...document.querySelectorAll(".slider-dot")];
const prevBtn = document.querySelector(".slider-prev");
const nextBtn = document.querySelector(".slider-next");
const currentSlide = document.getElementById("currentSlide");
let slideIndex = 0;
let autoSlide;
let touchStartX = 0;

function showSlide(index) {
    slideIndex = (index + slides.length) % slides.length;
    slides.forEach((slide, i) =>
        slide.classList.toggle("active", i === slideIndex),
    );
    dots.forEach((dot, i) => dot.classList.toggle("active", i === slideIndex));
    currentSlide.textContent = String(slideIndex + 1).padStart(2, "0");
}

function startAutoSlide() {
    clearInterval(autoSlide);
    autoSlide = setInterval(() => showSlide(slideIndex + 1), 6000);
}

if (carousel && slides.length > 0) {
    prevBtn?.addEventListener("click", () => {
        showSlide(slideIndex - 1);
        startAutoSlide();
    });

    nextBtn?.addEventListener("click", () => {
        showSlide(slideIndex + 1);
        startAutoSlide();
    });

    dots.forEach((dot) =>
        dot.addEventListener("click", () => {
            showSlide(Number(dot.dataset.slide));
            startAutoSlide();
        }),
    );

    carousel.addEventListener("mouseenter", () => {
        clearInterval(autoSlide);
    });

    carousel.addEventListener("mouseleave", startAutoSlide);

    carousel.addEventListener(
        "touchstart",
        (e) => {
            touchStartX = e.changedTouches[0].screenX;
        },
        { passive: true },
    );

    carousel.addEventListener(
        "touchend",
        (e) => {
            const delta = e.changedTouches[0].screenX - touchStartX;

            if (Math.abs(delta) > 45) {
                showSlide(slideIndex + (delta < 0 ? 1 : -1));
            }

            startAutoSlide();
        },
        { passive: true },
    );
}

if (slides.length > 0) {
    showSlide(0);
    startAutoSlide();
}

if (backTop) {
    window.addEventListener("scroll", () =>
        backTop.classList.toggle("show", window.scrollY > 550),
    );

    backTop.addEventListener("click", () =>
        window.scrollTo({
            top: 0,
            behavior: "smooth",
        }),
    );
}

window.addEventListener("resize", () => {
    if (window.innerWidth > 1180) {
        navMenu.classList.remove("open");
        menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
    }
});

const year = document.getElementById("year");

if (year) {
    year.textContent = new Date().getFullYear();
}

window.openYoutube = function (id) {
    if (!id) {
        console.error("Youtube ID tidak ditemukan");
        return;
    }

    const modal = document.getElementById("youtubeModal");
    const frame = document.getElementById("youtubeFrame");

    if (!modal || !frame) {
        console.error("Modal atau iframe YouTube tidak ditemukan");
        return;
    }

    frame.src =
        "https://www.youtube.com/embed/" +
        id +
        "?autoplay=1&rel=0&modestbranding=1";

    modal.classList.add("active");
    document.body.style.overflow = "hidden";
};

window.closeYoutube = function () {
    const modal = document.getElementById("youtubeModal");
    const frame = document.getElementById("youtubeFrame");

    if (!modal || !frame) {
        return;
    }

    frame.src = "";
    modal.classList.remove("active");
    document.body.style.overflow = "";
};

document.addEventListener("DOMContentLoaded", function () {
    const youtubeModal = document.getElementById("youtubeModal");

    if (youtubeModal) {
        youtubeModal.addEventListener("click", function (e) {
            if (e.target === youtubeModal) {
                window.closeYoutube();
            }
        });
    }
});

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        window.closeYoutube();
    }
});
