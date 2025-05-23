<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Rental App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f0f4ff, #e0f0ff);
        }
        .card {
            border: none;
            border-radius: 1.5rem;
        }
        .form-control {
            border-radius: 0.75rem;
        }
        .btn-primary {
            border-radius: 0.75rem;
            font-weight: 600;
        }
        .fade-in {
            animation: fadeIn 0.7s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card {
            border-radius: 12px;
        }   
    </style>
</head>
<body>

@yield('content')

<!-- Toast Message -->
@if (session('success'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="otpToast" class="toast align-items-center text-bg-success border-0 shadow show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body">
                ✅ {{ session('success') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif

@if (session('error'))
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="otpToast" class="toast align-items-center text-bg-danger border-0 shadow show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="4000">
        <div class="d-flex">
            <div class="toast-body">
                ❌ {{ session('error') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional: Auto-show toast -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastEl = document.getElementById('otpToast');
        if (toastEl) {
            const toast = new bootstrap.Toast(toastEl);
            toast.show();

            // Optional: Manually hide after delay (if needed extra)
            setTimeout(() => toast.hide(), 4000);
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Forget Password Button Click Event
        var forgotPasswordBtn = document.getElementById("forgot-password-btn");
        if (forgotPasswordBtn) {
            forgotPasswordBtn.addEventListener('click', function() {
                localStorage.setItem('otp-type', 'forgot'); // Store as a string
            });
        }

        // Register Button Click Event
        var registerBtn = document.getElementById("register-btn");
        if (registerBtn) {
            registerBtn.addEventListener('click', function() {
                localStorage.setItem('otp-type', 'register'); // Store as a string
            });
        }
    });
</script>

</body>
</html>
