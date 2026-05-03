// DOM Elements
const sidebar = document.querySelector(".sidebar");
const menuToggle = document.querySelector(".menu-toggle");
const navItems = document.querySelectorAll(".nav-item");
const contentSections = document.querySelectorAll(".content-section");
const pageTitle = document.getElementById("page-title");
const addBtn = document.querySelector(".add-btn");
const adminModal = document.getElementById("adminModal");
const closeModal = document.querySelector(".close-modal");
const adminForm = document.querySelector(".admin-form");

// Charts
let dailyChart, monthlyChart;

// Initialize Dashboard
document.addEventListener("DOMContentLoaded", function () {
    initCharts();
    initNavigation();
    initMobileMenu();
    initModals();
});

// Navigation
function initNavigation() {
    navItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            const section = item.getAttribute("data-section");

            // Update active nav
            navItems.forEach((nav) => nav.classList.remove("active"));
            item.classList.add("active");

            // Show section
            contentSections.forEach((sectionEl) =>
                sectionEl.classList.remove("active"),
            );
            document.getElementById(section).classList.add("active");

            // Update page title
            const titles = {
                dashboard: "Dashboard",
                transaksi: "Riwayat Transaksi",
                penjualan: "Laporan Penjualan",
                admin: "Kelola Admin",
                obat: "Data Obat",
                pembeli: "Data Pembeli",
                pengaturan: "Pengaturan",
            };
            pageTitle.textContent = titles[section] || "Dashboard";
        });
    });
}

// Charts
function initCharts() {
    const dailyCtx = document.getElementById("dailyChart").getContext("2d");
    dailyChart = new Chart(dailyCtx, {
        type: "line",
        data: {
            labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            datasets: [
                {
                    label: "Penjualan",
                    data: [
                        1200000, 1900000, 1500000, 2300000, 2800000, 2200000,
                        3000000,
                    ],
                    borderColor: "#00d4aa",
                    backgroundColor: "rgba(0, 212, 170, 0.1)",
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "#f1f3f4",
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });

    const monthlyCtx = document.getElementById("monthlyChart").getContext("2d");
    monthlyChart = new Chart(monthlyCtx, {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
            datasets: [
                {
                    label: "Penjualan",
                    data: [
                        45000000, 52000000, 48000000, 61000000, 58000000,
                        67000000,
                    ],
                    backgroundColor: "#00d4aa",
                    borderRadius: 8,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: "#f1f3f4",
                    },
                },
                x: {
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
}

// Mobile Menu
function initMobileMenu() {
    menuToggle.addEventListener("click", () => {
        sidebar.classList.toggle("active");
    });
}

// Modals
function initModals() {
    addBtn.addEventListener("click", () => {
        adminModal.style.display = "flex";
    });

    closeModal.addEventListener("click", () => {
        adminModal.style.display = "none";
    });

    adminForm.addEventListener("submit", (e) => {
        e.preventDefault();
        // Handle form submission
        alert("Admin baru berhasil ditambahkan!");
        adminModal.style.display = "none";
        adminForm.reset();
    });

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === adminModal) {
            adminModal.style.display = "none";
        }
    });
}

// Print functionality
document.querySelectorAll(".print-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        window.print();
    });
});

// Action buttons
document.querySelectorAll(".action-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        const icon = btn.querySelector("i").classList[1];
        if (icon === "fa-trash") {
            if (confirm("Yakin ingin menghapus data ini?")) {
                btn.closest("tr").remove();
            }
        }
    });
});

window.addEventListener("resize", () => {
    dailyChart.resize();
    monthlyChart.resize();
});
