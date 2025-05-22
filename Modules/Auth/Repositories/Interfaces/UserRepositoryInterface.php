<?php

namespace Modules\Auth\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function otpSend($request, $handler);

    public function verifyOtp($request, $handler);

    public function register($request, $handler);

    public function login($request);

    public function logout();

    public function manageAdmins($request);

    public function fetchAdmins();

    public function registerAdmin($request, $handler);

    public function editAdmin($request, $handler, $id);

    public function userSole($id);

    public function userImage($id);

    public function deleteAdmin($id);

    public function superAdminAccess();

    public function adminAccess();

    public function superAdminAndAdminAccess();

    public function authUser();
}
