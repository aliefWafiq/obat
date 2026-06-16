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

    const toggles = document.querySelectorAll('.password-toggle');
    toggles.forEach((toggle) => {
        toggle.addEventListener('click', function () {
            const wrapper = this.closest('.password-wrapper');
            const input = wrapper.querySelector('input[type="password"], input[type="text"]');
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                this.setAttribute('aria-label', 'Sembunyikan password');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
                this.setAttribute('aria-label', 'Tampilkan password');
            }
        });
    });
});
