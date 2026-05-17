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
    initMobileMenu();
    initModals();
    initSearch();
    initActiveNav();
});

function initActiveNav() {
    const currentPath = window.location.pathname;
    navItems.forEach(item => {
        try {
            const itemPath = new URL(item.href).pathname;
            if (currentPath === itemPath) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        } catch (e) {
            // Silently ignore invalid URLs
        }
    });
}

function initCharts() {
    const dailyChartEl = document.getElementById("dailyChart");
    if (dailyChartEl) {
        const dailyCtx = dailyChartEl.getContext("2d");
        dailyChart = new Chart(dailyCtx, {
            type: "line",
            data: {
            labels: window.chartData ? window.chartData.dailyLabels : ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
            datasets: [
                {
                    label: "Penjualan",
                    data: window.chartData ? window.chartData.dailyData : [
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
    }

    const monthlyChartEl = document.getElementById("monthlyChart");
    if (monthlyChartEl) {
        const monthlyCtx = monthlyChartEl.getContext("2d");
        monthlyChart = new Chart(monthlyCtx, {
            type: "bar",
            data: {
            labels: window.chartData ? window.chartData.monthlyLabels : ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"],
            datasets: [
                {
                    label: "Penjualan",
                    data: window.chartData ? window.chartData.monthlyData : [
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

    const revenueCtx = document.getElementById("revenuePeriodChart");
    if (revenueCtx && window.chartData) {
        let revenuePeriodChartInstance = new Chart(revenueCtx.getContext("2d"), {
            type: "line",
            data: {
                labels: window.chartData.dailyLabels,
                datasets: [{
                    label: "Pendapatan",
                    data: window.chartData.dailyData,
                    borderColor: "#3b82f6",
                    backgroundColor: "rgba(59, 130, 246, 0.1)",
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        document.querySelectorAll('.detail-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                document.querySelectorAll('.detail-tab').forEach(t => t.classList.remove('active'));
                e.target.classList.add('active');
                
                const period = e.target.dataset.period;
                let labels, data;
                if (period === 'daily') {
                    labels = window.chartData.dailyLabels;
                    data = window.chartData.dailyData;
                } else if (period === 'monthly') {
                    labels = window.chartData.monthlyLabels;
                    data = window.chartData.monthlyData;
                } else if (period === 'yearly') {
                    labels = window.chartData.yearlyLabels;
                    data = window.chartData.yearlyData;
                }
                
                revenuePeriodChartInstance.data.labels = labels;
                revenuePeriodChartInstance.data.datasets[0].data = data;
                revenuePeriodChartInstance.update();
            });
        });
    }

    const avgCtx = document.getElementById("averageTrendChart");
    if (avgCtx && window.chartData) {
        new Chart(avgCtx.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: window.chartData.kategoriLabels,
                datasets: [{
                    data: window.chartData.kategoriData,
                    backgroundColor: [
                        "#00d4aa", "#3b82f6", "#f59e0b", "#ef4444", "#8b5cf6"
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });
    }
}

function initMobileMenu() {
    if (menuToggle && sidebar) {
        menuToggle.addEventListener("click", () => {
            sidebar.classList.toggle("active");
        });
    }
}

function initModals() {
    if (addBtn && adminModal) {
        addBtn.addEventListener("click", () => {
            adminModal.style.display = "flex";
        });
    }

    if (closeModal && adminModal) {
        closeModal.addEventListener("click", () => {
            adminModal.style.display = "none";
        });
    }



    if (adminModal) {
        window.addEventListener("click", (e) => {
            if (e.target === adminModal) {
                adminModal.style.display = "none";
            }
        });
    }
}

document.querySelectorAll(".print-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
        window.print();
    });
});



window.addEventListener("resize", () => {
    if (dailyChart) dailyChart.resize();
    if (monthlyChart) monthlyChart.resize();
});

function initSearch() {
    const searchInput = document.getElementById('searchInput');
    const dataTable = document.querySelector('.data-table');
    
    if (searchInput && dataTable) {
        const tbody = dataTable.querySelector('tbody');
        const rows = tbody.querySelectorAll('tr');
        
        searchInput.addEventListener('input', function(e) {
            const term = e.target.value.toLowerCase();
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
}
