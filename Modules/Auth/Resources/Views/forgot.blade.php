@extends('auth::layouts.master')
@section('title', 'Forgot Password')
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card shadow fade-in">
                <div class="card-body p-5">
                    <h3 class="mb-4 text-center text-primary fw-bold">🔐 Forgot Password</h3>

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

                    <!-- Forgot Form -->
                    <form method="POST" action="{{ route('forgot') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password" 
                                value="{{ old('password') }}"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-semibold">Confirm Password</label>
                            <input 
                                type="password" 
                                name="confirm_password" 
                                id="confirm_password" 
                                class="form-control @error('confirm_password') is-invalid @enderror"
                                placeholder="Enter your confirm_password" 
                                value="{{ old('confirm_password') }}"
                                required
                            >
                            @error('confirm_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            📩 Sumbit
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100 mt-3">
                            🔄 Go Back Login
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection