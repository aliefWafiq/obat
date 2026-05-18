const navbar = document.getElementById("navbar");

window.addEventListener("scroll", () => {
    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});

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

    const hero = document.querySelector(".hero");
    hero.addEventListener("mouseenter", stopSlider);
    hero.addEventListener("mouseleave", startSlider);
}

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

const categoryBtns = document.querySelectorAll(".category-btn");

function filterProducts(category) {
    if (category === "semua") {
        let productsByCategory = {};
        let allProducts = [];
        
        document.querySelectorAll(".product-card").forEach((card) => {
            const idCategory = parseInt(card.dataset.id);
            if (!productsByCategory[idCategory]) {
                productsByCategory[idCategory] = [];
            }
            productsByCategory[idCategory].push(card);
            allProducts.push(card);
        });

        let selectedCards = new Set();
        
        for (let cat in productsByCategory) {
            if (selectedCards.size < 4 && productsByCategory[cat].length > 0) {
                selectedCards.add(productsByCategory[cat][0]);
            }
        }

        if (selectedCards.size < 4) {
            for (let card of allProducts) {
                if (selectedCards.size < 4 && !selectedCards.has(card)) {
                    selectedCards.add(card);
                }
            }
        }

        document.querySelectorAll(".product-card").forEach((card) => {
            card.style.display = selectedCards.has(card) ? "" : "none";
        });
    } else {
        document.querySelectorAll(".product-card").forEach((card) => {
            const idCategory = parseInt(card.dataset.id);
            card.style.display = (idCategory == category) ? "" : "none";
        });
    }
}

categoryBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
        categoryBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        filterProducts(btn.dataset.cat);
    });
});

if (document.querySelector(".product-card")) {
    filterProducts("semua");
}

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

const mobileToggle = document.getElementById("mobileToggle");
const navLinks = document.querySelector(".nav-links");

if (mobileToggle) {
    mobileToggle.addEventListener("click", () => {
        mobileToggle.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
}

const contactForm = document.querySelector(".contact-form");

if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const formData = new FormData(contactForm);
        console.log("Form submitted:", Object.fromEntries(formData));

        alert("Pesan Anda telah terkirim! Kami akan segera menghubungi Anda.");
        contactForm.reset();
    });
}

window.addEventListener("scroll", () => {
    const scrolled = window.scrollY;
    const heroContent = document.querySelector(".hero-content");

    if (heroContent && scrolled < window.innerHeight) {
        heroContent.style.transform = `translateY(${scrolled * 0.3}px)`;
        heroContent.style.opacity = 1 - scrolled / window.innerHeight;
    }
});
