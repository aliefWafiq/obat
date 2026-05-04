// Sticky navbar shadow on scroll
const navbar = document.getElementById("navbar");
window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 10);
});

document.getElementById("filter-tabs").addEventListener("click", (e) => {
    const btn = e.target.closest(".tab");
    if (!btn) return;
    document
        .querySelectorAll(".tab")
        .forEach((t) => t.classList.remove("active"));
    btn.classList.add("active");
    currentCat = btn.dataset.cat;
    document.querySelectorAll(".product-card").forEach((card) => {
        const idCategory = parseInt(card.dataset.id);
        card.style.display = currentCat === "semua" || idCategory == currentCat ? "" : "none";
    });
});

// Sort
document.getElementById("sort-select").addEventListener("change", (e) => {
    currentSort = e.target.value;
    renderProducts();
});

// Search filter
document.getElementById("search-input").addEventListener("input", (e) => {
    const q = e.target.value.toLowerCase();
    document.querySelectorAll(".product-card").forEach((card) => {
        const id = parseInt(card.dataset.id);
        const p = products.find((x) => x.id === id);
        card.style.display =
            p && p.name.toLowerCase().includes(q) ? "" : "none";
    });
});

// Pagination
document.querySelectorAll(".page-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        document
            .querySelectorAll(".page-btn")
            .forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
    });
});

// renderProducts();
