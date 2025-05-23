<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\EditProfileRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Auth\Http\Requests\OtpSendRequest;
use Modules\Auth\Http\Requests\OtpVerifyRequest;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\ResetPasswordRequest;
use Modules\Auth\Http\Requests\ForgotPasswordRequest;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Shared\Actions\HandleFormSubmission;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function loginForm()
    {
        return view('auth::login');
    }

    public function showOtpForm()
    {
        return view('auth::Otp.otp-send');
    }

    public function otpSend(OtpSendRequest $request, HandleFormSubmission $handler)
    {
        return $this->userRepository->otpSend($request, $handler);
    }

    public function verifyOtpForm()
    {
        return view('auth::Otp.otp-verify');
    }

    public function verifyOtp(OtpVerifyRequest $request)
    {
        $phone_number = $request->identifier;

        return $this->userRepository->verifyOtp($request, $phone_number);
    }

    public function registerForm()
    {
        return view('auth::register');
    }

    public function forgotForm()
    {
        return view('auth::forgot');
    }

    public function register(RegisterRequest $request, HandleFormSubmission $handler)
    {
        return $this->userRepository->register($request, $handler);
    }

    public function forgot(ForgotPasswordRequest $request, HandleFormSubmission $handler)
    {
        return $this->userRepository->forgot($request, $handler);
    }

    public function login(LoginRequest $request)
    {
        return $this->userRepository->login($request);
    }

    public function logout()
    {
        return $this->userRepository->logout();
    }

    // Manage Profile

    public function profile()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('auth::profile', compact('user', 'profile'));
    }

    public function editProfile(EditProfileRequest $request, HandleFormSubmission $handler)
    {
        return $this->userRepository->editProfile($request, $handler);
    }

    public function resetPassword(ResetPasswordRequest $request, HandleFormSubmission $handler)
    {
        return $this->userRepository->resetPassword($request, $handler);
    }
}
