function handleSubmit(form) {
    const btn = document.getElementById("submitBtn");
    const originalText = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    btn.style.transform = "scale(0.98)";

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        btn.style.transform = "";
    }, 5000);
}

document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll("input");
    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.parentElement.style.transform = "scale(1.02)";
        });
        input.addEventListener("blur", function () {
            this.parentElement.style.transform = "";
        });
    });
});
