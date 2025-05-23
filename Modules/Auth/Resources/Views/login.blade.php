@extends('auth::layouts.master')

@section('title', 'Login')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card shadow fade-in">
            <div class="card-body p-5">
                <h3 class="mb-4 text-center text-primary fw-bold">🔐 Login</h3>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- OTP Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email_phone" class="form-label fw-semibold">Email or Phone</label>
                        <input 
                            type="text" 
                            name="email_phone" 
                            id="email_phone" 
                            class="form-control @error('email_phone') is-invalid @enderror"
                            placeholder="Enter Your Email or Phone" 
                            value="{{ old('email_phone') }}"
                            required
                        >
                        @error('email_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter Your Password" 
                            value="{{ old('password') }}"
                            required
                        >
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 🔁 Beautifully Styled Forgot Password Link -->
                    <div class="mb-3 text-end">
                        <a href="{{ route('otp.form') }}" class="text-decoration-none text-primary fw-semibold small" id="forgot-password-btn">
                            <i class="bi bi-key"></i> Forgot Password?
                        </a>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            👤 Login
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Don’t have an account?
                            <a href="{{ route('otp.send') }}" class="text-primary fw-semibold text-decoration-none" id="register-btn">
                                Register here
                            </a>
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

