// // Sticky navbar shadow on scroll
// const navbar = document.getElementById("navbar");
// window.addEventListener("scroll", () => {
//     navbar.classList.toggle("scrolled", window.scrollY > 10);
// });

// // Product data
// const products = [
//     {
//         id: 1,
//         name: "Vitamin C 1000mg",
//         cat: "vitamin",
//         catLabel: "Vitamin & Suplemen",
//         desc: "Meningkatkan daya tahan tubuh",
//         priceNum: 125000,
//         price: "Rp 125.000",
//         badge: "Best Seller",
//         badgeType: "",
//     },
//     {
//         id: 2,
//         name: "Paracetamol 500mg",
//         cat: "obat",
//         catLabel: "Obat Umum",
//         desc: "Pereda nyeri dan penurun demam",
//         priceNum: 18000,
//         price: "Rp 18.000",
//         badge: null,
//     },
//     {
//         id: 3,
//         name: "Tensimeter Digital",
//         cat: "alat",
//         catLabel: "Alat Kesehatan",
//         desc: "Pengukur tekanan darah akurat",
//         priceNum: 320000,
//         price: "Rp 320.000",
//         oldPrice: "Rp 450.000",
//         badge: "Sale",
//         badgeType: "sale",
//     },
//     {
//         id: 4,
//         name: "Temulawak Kapsul",
//         cat: "herbal",
//         catLabel: "Herbal & Jamu",
//         desc: "Menjaga kesehatan hati & lambung",
//         priceNum: 65000,
//         price: "Rp 65.000",
//         badge: null,
//     },
//     {
//         id: 5,
//         name: "Vitamin D3 1000IU",
//         cat: "vitamin",
//         catLabel: "Vitamin & Suplemen",
//         desc: "Mendukung kesehatan tulang & imun",
//         priceNum: 95000,
//         price: "Rp 95.000",
//         badge: "New",
//         badgeType: "new",
//     },
//     {
//         id: 6,
//         name: "Amoxicillin 500mg",
//         cat: "obat",
//         catLabel: "Antibiotik",
//         desc: "Antibiotik spektrum luas",
//         priceNum: 35000,
//         price: "Rp 35.000",
//         badge: null,
//     },
//     {
//         id: 7,
//         name: "Oximeter Pulse",
//         cat: "alat",
//         catLabel: "Alat Kesehatan",
//         desc: "Monitor saturasi oksigen darah",
//         priceNum: 185000,
//         price: "Rp 185.000",
//         badge: "Best Seller",
//         badgeType: "",
//     },
//     {
//         id: 8,
//         name: "Jahe Merah Kapsul",
//         cat: "herbal",
//         catLabel: "Herbal & Jamu",
//         desc: "Menghangatkan dan meningkatkan stamina",
//         priceNum: 55000,
//         price: "Rp 55.000",
//         badge: null,
//     },
//     {
//         id: 9,
//         name: "Omega-3 Fish Oil",
//         cat: "vitamin",
//         catLabel: "Vitamin & Suplemen",
//         desc: "Menjaga kesehatan jantung & otak",
//         priceNum: 145000,
//         price: "Rp 145.000",
//         badge: null,
//     },
//     {
//         id: 10,
//         name: "Ibuprofen 400mg",
//         cat: "obat",
//         catLabel: "Obat Umum",
//         desc: "Anti-inflamasi dan pereda nyeri",
//         priceNum: 22000,
//         price: "Rp 22.000",
//         badge: null,
//     },
//     {
//         id: 11,
//         name: "Termometer Digital",
//         cat: "alat",
//         catLabel: "Alat Kesehatan",
//         desc: "Pengukur suhu tubuh presisi tinggi",
//         priceNum: 78000,
//         price: "Rp 78.000",
//         oldPrice: "Rp 110.000",
//         badge: "Sale",
//         badgeType: "sale",
//     },
//     {
//         id: 12,
//         name: "Sambiloto Kapsul",
//         cat: "herbal",
//         catLabel: "Herbal & Jamu",
//         desc: "Membantu menurunkan gula darah",
//         priceNum: 72000,
//         price: "Rp 72.000",
//         badge: null,
//     },
// ];

// let cartCount = 0;
// let currentCat = "semua";
// let currentSort = "default";

// function getFiltered() {
//     let list =
//         currentCat === "semua"
//             ? [...products]
//             : products.filter((p) => p.cat === currentCat);
//     if (currentSort === "price-asc")
//         list.sort((a, b) => a.priceNum - b.priceNum);
//     else if (currentSort === "price-desc")
//         list.sort((a, b) => b.priceNum - a.priceNum);
//     return list;
// }

// function renderProducts() {
//     const grid = document.getElementById("product-grid");
//     const list = getFiltered();
//     document.getElementById("result-count").textContent =
//         `Menampilkan ${list.length} produk`;
//     document.getElementById("sort-count").textContent =
//         `${list.length} produk ditemukan`;
//     grid.innerHTML = list
//         .map(
//             (p) => `
//       <div class="product-card" data-id="${p.id}">
//         <div class="card-img-wrap">
//           ${p.badge ? `<span class="card-badge ${p.badgeType || ""}">${p.badge}</span>` : ""}
//           <div class="card-img-placeholder">
//             <svg viewBox="0 0 24 24">
//               <rect x="3" y="3" width="18" height="18" rx="2"/>
//               <path d="M9 9h.01M15 9h.01M9 15c.83 1 2 1.5 3 1.5s2.17-.5 3-1.5"/>
//             </svg>
//             <span>${p.catLabel}</span>
//           </div>
//           <div class="card-overlay">Tambah ke Keranjang</div>
//         </div>
//         <div class="card-body">
//           <div class="card-cat">${p.catLabel}</div>
//           <div class="card-name">${p.name}</div>
//           <div class="card-desc">${p.desc}</div>
//           <div class="card-footer">
//             <div>
//               <span class="card-price">${p.price}</span>
//               ${p.oldPrice ? `<span class="card-price-old">${p.oldPrice}</span>` : ""}
//             </div>
//             <button class="card-add-btn" onclick="addToCart(event, ${p.id})" title="Tambah ke keranjang">
//               <svg viewBox="0 0 24 24">
//                 <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
//                 <line x1="3" y1="6" x2="21" y2="6"/>
//                 <path d="M16 10a4 4 0 01-8 0"/>
//               </svg>
//             </button>
//           </div>
//         </div>
//       </div>
//     `,
//         )
//         .join("");
// }

// function addToCart(e, id) {
//     e.stopPropagation();
//     cartCount++;
//     document.getElementById("cart-count").textContent = cartCount;
// }

// // Tab filter
// document.getElementById("filter-tabs").addEventListener("click", (e) => {
//     const btn = e.target.closest(".tab");
//     if (!btn) return;
//     document
//         .querySelectorAll(".tab")
//         .forEach((t) => t.classList.remove("active"));
//     btn.classList.add("active");
//     currentCat = btn.dataset.cat;
//     renderProducts();
// });

// // Sort
// document.getElementById("sort-select").addEventListener("change", (e) => {
//     currentSort = e.target.value;
//     renderProducts();
// });

// // Search filter
// document.getElementById("search-input").addEventListener("input", (e) => {
//     const q = e.target.value.toLowerCase();
//     document.querySelectorAll(".product-card").forEach((card) => {
//         const id = parseInt(card.dataset.id);
//         const p = products.find((x) => x.id === id);
//         card.style.display =
//             p && p.name.toLowerCase().includes(q) ? "" : "none";
//     });
// });

// // Pagination
// document.querySelectorAll(".page-btn").forEach((btn) => {
//     btn.addEventListener("click", () => {
//         document
//             .querySelectorAll(".page-btn")
//             .forEach((b) => b.classList.remove("active"));
//         btn.classList.add("active");
//     });
// });

// renderProducts();
