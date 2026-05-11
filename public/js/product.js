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
    filterTabs.addEventListener("click", (e) => {
        const btn = e.target.closest(".tab");
        if (!btn) return;

        document
            .querySelectorAll(".tab")
            .forEach((t) => t.classList.remove("active"));
        btn.classList.add("active");

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
