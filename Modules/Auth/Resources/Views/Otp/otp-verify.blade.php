@extends('auth::layouts.master')
@section('title', 'Verify OTP')
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
                    <form method="POST" action="{{ route('otp.verify') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="otp" class="form-label fw-semibold">Otp</label>
                            <input 
                                type="text" 
                                name="otp" 
                                id="otp" 
                                class="form-control @error('otp') is-invalid @enderror"
                                placeholder="Enter your otp" 
                                value="{{ old('otp') }}"
                                required
                            >
                            @error('otp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            📩 Verify OTP
                        </button>

                        <a href="{{ route('otp.form') }}" class="btn btn-outline-secondary w-100 mt-3">
                            🔄 Change Mobile Number
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection