// Sticky navbar shadow on scroll
const navbar = document.getElementById("navbar");
if (navbar) {
    window.addEventListener("scroll", () => {
        navbar.classList.toggle("scrolled", window.scrollY > 10);
    });
}

let currentPage = 1;
const perPage = 8;

function updatePagination(visibleCardsCount) {
    const totalPages = Math.ceil(visibleCardsCount / perPage);
    const paginationContainer = document.querySelector(".pagination");

    if (!paginationContainer) return;

    paginationContainer.innerHTML = "";

    if (totalPages <= 1) {
        return;
    }

    for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.className = `page-btn ${i === currentPage ? "active" : ""}`;
        btn.textContent = i;
        btn.addEventListener("click", () => {
            currentPage = i;
            renderProducts();
            // Scroll sedikit ke atas agar nyaman dilihat
            document
                .querySelector(".catalog")
                .scrollIntoView({ behavior: "smooth" });
        });
        paginationContainer.appendChild(btn);
    }
}

function renderProducts() {
    let cards = Array.from(document.querySelectorAll(".product-card"));

    // 1. Logic Sorting
    let sortSelect = document.getElementById("sort-select");
    if (sortSelect) {
        let currentSort = sortSelect.value;
        cards.sort((a, b) => {
            let priceA = parseInt(
                a.querySelector(".card-price").textContent.replace(/\D/g, ""),
            );
            let priceB = parseInt(
                b.querySelector(".card-price").textContent.replace(/\D/g, ""),
            );
            if (currentSort === "price-asc") return priceA - priceB;
            if (currentSort === "price-desc") return priceB - priceA;
            return 0;
        });

        let grid = document.getElementById("product-grid");
        if (grid) {
            cards.forEach((card) => grid.appendChild(card));
        }
    }

    let activeTab = document.querySelector(".tab.active");
    let currentCat = activeTab ? activeTab.dataset.cat : "semua";

    let searchInput = document.getElementById("search-input");
    let searchQuery = searchInput ? searchInput.value.toLowerCase() : "";

    let visibleCards = [];
    cards.forEach((card) => {
        let name = card.querySelector(".card-name").textContent.toLowerCase();
        let idCategory = card.dataset.id;

        let matchCat = currentCat === "semua" || idCategory == currentCat;
        let matchSearch = name.includes(searchQuery);

        if (matchCat && matchSearch) {
            visibleCards.push(card);
        } else {
            card.style.display = "none";
        }
    });

    const totalPages = Math.ceil(visibleCards.length / perPage);
    if (currentPage > totalPages) currentPage = totalPages || 1;

    let startIndex = (currentPage - 1) * perPage;
    let endIndex = startIndex + perPage;

    visibleCards.forEach((card, index) => {
        if (index >= startIndex && index < endIndex) {
            card.style.display = "";
        } else {
            card.style.display = "none";
        }
    });

    updatePagination(visibleCards.length);

    let showingCardTotal = document.getElementById("result-count");
    if (showingCardTotal) {
        showingCardTotal.textContent =
            "Menampilkan " + visibleCards.length + " produk";
    }
}

const filterTabs = document.getElementById("filter-tabs");
if (filterTabs) {
    const catalogTitle = document.getElementById("catalog-title");
    filterTabs.addEventListener("click", (e) => {
        const btn = e.target.closest(".tab");
        if (!btn) return;

        document
            .querySelectorAll(".tab")
            .forEach((t) => t.classList.remove("active"));
        btn.classList.add("active");

        // Perbarui judul secara dinamis mengikuti nama kategori tab aktif
        if (catalogTitle) {
            const catName = btn.textContent.trim();
            if (catName.toLowerCase() === "semua") {
                catalogTitle.innerHTML = `Semua <em>Produk</em>`;
            } else {
                catalogTitle.innerHTML = `Produk <em>${catName}</em>`;
            }
        }

        currentPage = 1;
        renderProducts();
    });
}

const sortSelect = document.getElementById("sort-select");
if (sortSelect) {
    sortSelect.addEventListener("change", () => {
        currentPage = 1;
        renderProducts();
    });
}

const searchInput = document.getElementById("search-input");
if (searchInput) {
    searchInput.addEventListener("input", () => {
        currentPage = 1;
        renderProducts();
    });
}

renderProducts();

const mobileToggle = document.getElementById("mobileToggle");
const navLinks = document.querySelector(".nav-links");

if (mobileToggle && navLinks) {
    mobileToggle.addEventListener("click", () => {
        mobileToggle.classList.toggle("active");
        navLinks.classList.toggle("active");
    });
}

// Program Slider Logic
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".program-slide");
    const dots = document.querySelectorAll(".slider-container .dot");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");
    let currentSlideIndex = 0;
    let slideInterval;

    function showSlide(index) {
        if (slides.length === 0) return;

        // Handle index bounds
        if (index >= slides.length) {
            currentSlideIndex = 0;
        } else if (index < 0) {
            currentSlideIndex = slides.length - 1;
        } else {
            currentSlideIndex = index;
        }

        // Toggle active class on slides
        slides.forEach((slide, i) => {
            if (i === currentSlideIndex) {
                slide.classList.add("active");
            } else {
                slide.classList.remove("active");
            }
        });

        // Toggle active class on dots
        dots.forEach((dot, i) => {
            if (i === currentSlideIndex) {
                dot.classList.add("active");
            } else {
                dot.classList.remove("active");
            }
        });
    }

    function nextSlide() {
        showSlide(currentSlideIndex + 1);
    }

    function prevSlide() {
        showSlide(currentSlideIndex - 1);
    }

    function startSlideShow() {
        stopSlideShow();
        slideInterval = setInterval(nextSlide, 5000); // Auto-play every 5s
    }

    function stopSlideShow() {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    }

    // Event Listeners
    if (prevBtn) {
        prevBtn.addEventListener("click", () => {
            prevSlide();
            startSlideShow();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener("click", () => {
            nextSlide();
            startSlideShow();
        });
    }

    if (dots) {
        dots.forEach((dot) => {
            dot.addEventListener("click", (e) => {
                const index = parseInt(e.target.dataset.index);
                showSlide(index);
                startSlideShow();
            });
        });
    }

    // Start slideshow if container exists
    if (slides.length > 0) {
        startSlideShow();

        // Pause on hover
        const sliderContainer = document.querySelector(".slider-container");
        if (sliderContainer) {
            sliderContainer.addEventListener("mouseenter", stopSlideShow);
            sliderContainer.addEventListener("mouseleave", startSlideShow);
        }
    }

    // ── SHOPEE STYLE DRAWER CONTROLLER ──
    const drawerOverlay = document.getElementById("cart-drawer-overlay");
    const drawer = document.getElementById("cart-drawer");
    const closeBtn = document.querySelector(".drawer-close-btn");

    const drawerProductId = document.getElementById("drawer-product-id");
    const drawerProductImg = document.getElementById("drawer-product-img");
    const drawerProductName = document.getElementById("drawer-product-name");
    const drawerProductDesc = document.getElementById("drawer-product-desc");
    const drawerProductPrice = document.getElementById("drawer-product-price");
    const drawerProductStock = document.getElementById("drawer-product-stock");
    const drawerQtyInput = document.getElementById("drawer-qty-input");

    const openButtons = document.querySelectorAll(".open-drawer-btn");
    let currentMaxStock = 999;
    let currentRawHarga = 0;

    function updateDrawerTotalPrice() {
        const qty = parseInt(drawerQtyInput.value) || 1;
        const total = currentRawHarga * qty;
        // Format to Indonesian Rupiah representation: Rp XX.XXX
        drawerProductPrice.textContent = "Rp " + total.toLocaleString('id-ID');
    }

    // Open Drawer
    openButtons.forEach(btn => {
        btn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();

            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const desc = btn.dataset.desc;
            const harga = btn.dataset.harga;
            const rawHarga = parseInt(btn.dataset.rawHarga) || 0;
            const stok = parseInt(btn.dataset.stok) || 0;
            const gambar = btn.dataset.gambar;

            currentMaxStock = stok;
            currentRawHarga = rawHarga;

            // Populate Drawer Fields
            drawerProductId.value = id;
            drawerProductImg.src = gambar;
            drawerProductImg.alt = name;
            drawerProductName.textContent = name;
            drawerProductDesc.textContent = desc;
            drawerProductStock.textContent = `Stok: ${stok}`;

            // Reset quantity to 1
            drawerQtyInput.value = 1;
            
            // Initial Total Price Calculation
            updateDrawerTotalPrice();

            // Show Drawer
            drawerOverlay.classList.add("active");
        });
    });

    // Close Drawer Function
    function closeCartDrawer() {
        drawerOverlay.classList.remove("active");
    }

    if (closeBtn) {
        closeBtn.addEventListener("click", closeCartDrawer);
    }

    if (drawerOverlay) {
        drawerOverlay.addEventListener("click", (e) => {
            // Close if clicked on overlay (outside the drawer)
            if (e.target === drawerOverlay) {
                closeCartDrawer();
            }
        });
    }

    // Quantity Plus/Minus inside Drawer
    const drawerMinusBtn = document.querySelector(".cart-drawer .qty-btn.minus");
    const drawerPlusBtn = document.querySelector(".cart-drawer .qty-btn.plus");

    if (drawerMinusBtn && drawerPlusBtn && drawerQtyInput) {
        drawerMinusBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            let val = parseInt(drawerQtyInput.value) || 1;
            if (val > 1) {
                drawerQtyInput.value = val - 1;
                updateDrawerTotalPrice();
            }
        });

        drawerPlusBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            let val = parseInt(drawerQtyInput.value) || 1;
            if (val < currentMaxStock) {
                drawerQtyInput.value = val + 1;
                updateDrawerTotalPrice();
            } else {
                alert(`Maaf, jumlah pembelian melebihi stok yang tersedia (${currentMaxStock} pcs).`);
            }
        });
    }

    // Automatically focus input when clicking anywhere on the search bubble capsule
    const searchBox = document.querySelector(".search-box");
    const searchInput = document.getElementById("search-input");
    if (searchBox && searchInput) {
        searchBox.addEventListener("click", (e) => {
            searchInput.focus();
        });
    }
});
