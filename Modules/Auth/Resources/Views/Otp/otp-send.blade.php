@extends('auth::layouts.master')

@section('title', 'Send OTP')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6">
        <div class="card shadow fade-in">
            <div class="card-body p-5">
                <h3 class="mb-4 text-center text-primary fw-bold">🔐 Verify with OTP</h3>

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
                <form method="POST" action="{{ route('otp.send') }}">
                    @csrf

                    <!-- OTP Type -->
                     <input type="text" name="type" value="register" hidden class="form-control" id="otp-type">
                    <div class="mb-4">
                        <label for="identifier" class="form-label fw-semibold">Phone Number or Email</label>
                        <input 
                            type="text" 
                            name="identifier" 
                            id="identifier" 
                            class="form-control @error('identifier') is-invalid @enderror"
                            placeholder="Enter your phone or email" 
                            value="{{ old('identifier') }}"
                            required
                        >
                        @error('identifier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        📩 Send OTP
                    </button>
                </form>
                <a href="{{ route('login') }}" class="btn btn-secondary w-100 mt-3">🔙 Go Back Login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Retrieve OTP Type from Local Storage
            var type = localStorage.getItem('otp-type');
            var otpTypeInput = document.getElementById('otp-type');
            if (otpTypeInput) {
                otpTypeInput.value = type;
            }
            
        });
    </script>
