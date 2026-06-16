function handleSubmit(form) {
    const btn = document.getElementById("submitBtn");
    const originalText = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftarkan...';
    btn.style.transform = "scale(0.98)";

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalText;
        btn.style.transform = "";
    }, 5000);
}

document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll("input, textarea");
    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.parentElement.style.opacity = "0.8";
        });
        input.addEventListener("blur", function () {
            this.parentElement.style.opacity = "1";
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

    const sendOtpBtn = document.getElementById('sendOtpBtn');
    const otpStatus = document.getElementById('otpStatus');
    const phoneInput = document.getElementById('phoneNumber');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    sendOtpBtn.addEventListener('click', function () {
        const phone = phoneInput.value.trim();
        if (!phone) {
            otpStatus.textContent = 'Nomor HP belum diisi.';
            return;
        }
        otpStatus.textContent = '';
        fetch('/register/send-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ phoneNumber: phone })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                otpStatus.style.color = '#52c41a'; // success green
                otpStatus.textContent = data.message;
            } else {
                otpStatus.style.color = '#ff4d4f'; // error red
                otpStatus.textContent = data.message;
            }
        })
        .catch(err => {
            otpStatus.style.color = '#ff4d4f';
            otpStatus.textContent = 'Terjadi kesalahan saat mengirim OTP.';
            console.error(err);
        });
    });
});
