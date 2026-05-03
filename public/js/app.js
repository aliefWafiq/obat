// ================================
// NAVBAR SCROLL EFFECT
// ================================
const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

// ================================
// SMOOTH SCROLL
// ================================
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        const href = this.getAttribute("href");
        if (href === "#") return;

        const target = document.querySelector(href);
        if (target) {
            e.preventDefault();
            const navHeight = navbar.offsetHeight;
            const targetPosition = target.offsetTop - navHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: "smooth",
            });
        }
    });
});

// ================================
// HERO SLIDER
// ================================
const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".slider-dot");
let currentSlide = 0;
let slideInterval;
const slideDuration = 5000;

function showSlide(index) {
    slides.forEach((slide) => slide.classList.remove("active"));
    dots.forEach((dot) => dot.classList.remove("active"));

    slides[index].classList.add("active");
    dots[index].classList.add("active");
    currentSlide = index;
}

function nextSlide() {
    const next = (currentSlide + 1) % slides.length;
    showSlide(next);
}

function startSlider() {
    slideInterval = setInterval(nextSlide, slideDuration);
}

function stopSlider() {
    clearInterval(slideInterval);
}

// Initialize slider
if (slides.length > 0) {
    showSlide(0);
    startSlider();

    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            stopSlider();
            showSlide(index);
            startSlider();
        });
    });

    // Pause on hover
    const hero = document.querySelector(".hero");
    hero.addEventListener("mouseenter", stopSlider);
    hero.addEventListener("mouseleave", startSlider);
}

// ================================
// SCROLL REVEAL ANIMATIONS
// ================================
const reveals = document.querySelectorAll(".reveal-left, .reveal-right");

function revealOnScroll() {
    const windowHeight = window.innerHeight;

    reveals.forEach((el) => {
        const elementTop = el.getBoundingClientRect().top;
        const revealPoint = 150;

        if (elementTop < windowHeight - revealPoint) {
            el.classList.add("active");
        }
    });
}

window.addEventListener("scroll", revealOnScroll);
revealOnScroll();

// ================================
// PRODUCT CATEGORY FILTER
// ================================
const categoryBtns = document.querySelectorAll(".category-btn");

categoryBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        categoryBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        // Add filtering logic here when products have data attributes
    });
});

// ================================
// SEARCH FUNCTIONALITY
// ================================
const searchBox = document.querySelector(".search-box");
const searchInput = document.querySelector(".search-input");

if (searchInput) {
    searchInput.addEventListener("focus", () => {
        searchBox.classList.add("active");
    });

    searchInput.addEventListener("blur", () => {
        setTimeout(() => {
            searchBox.classList.remove("active");
        }, 200);
    });
}

// ================================
// MOBILE MENU TOGGLE
// ================================
const mobileToggle = document.getElementById("mobileToggle");
const navLinks = document.querySelector(".nav-links");

if (mobileToggle) {
    mobileToggle.addEventListener("click", () => {
        mobileToggle.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
}

// ================================
// FORM HANDLING
// ================================
const contactForm = document.querySelector(".contact-form");

if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
        e.preventDefault();

        // Add form submission logic here
        const formData = new FormData(contactForm);
        console.log("Form submitted:", Object.fromEntries(formData));

        // Show success message
        alert("Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.");
        contactForm.reset();
    });
}

// ================================
// PARALLAX EFFECT (subtle)
// ================================
window.addEventListener("scroll", () => {
    const scrolled = window.scrollY;
    const heroContent = document.querySelector(".hero-content");

    if (heroContent && scrolled < window.innerHeight) {
        heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
        heroContent.style.opacity = 1 - scrolled / window.innerHeight;
    }
});
