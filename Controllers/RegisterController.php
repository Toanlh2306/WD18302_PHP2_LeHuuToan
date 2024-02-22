<?php

namespace App\Controllers;

use App\Core\RenderBase;
use App\Models\UserModel;

class RegisterController extends BaseController
{
    private $_renderBase;

    public function __construct()
    {
        parent::__construct();
        $this->_renderBase = new RenderBase();
    }

    public function loadViewRegister()
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect(URL);
        }

        $this->load->render('client/register');
    }

    public function handleRegister()
    {
        // Kiểm tra dữ liệu nhập vào
        if (!validateForm()) {
            // Redirect về trang đăng ký và báo lỗi
            $this->redirect(URL . "?url=RegisterController/loadViewRegister&error=validation_error");
        }

        $userModel = new UserModel();
        $user = $userModel->checkUserExist($_POST["email"]);

        if ($user) {
            // Tài khoản này đã tồn tại, vui lòng đăng nhập
            $this->redirect(URL . "?url=LoginController/loadViewLogin&error=user_already_exists");
        }

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userModel->registerUser($_POST);

        // Đăng ký thành công, chuyển hướng đến trang chủ
        $this->redirect(URL . "?url=PageController/home");
    }
}

function validateForm()
{
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($username) || empty($email) || empty($password)) {
        return false;
    }

    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $email)) {
        return false;
    }

    if (strlen($password) < 6) {
        return false;
    }

    return true;
}