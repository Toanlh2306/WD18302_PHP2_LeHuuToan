<?php

namespace App\Controllers;

use App\Core\RenderBase;
use App\Models\UserModel;

class LoginController extends BaseController
{

    private $_renderBase;
    private $UserModel;

    public function __construct()
    {
        parent::__construct();
        $this->_renderBase = new RenderBase();
        $this->UserModel = new UserModel();
    }

    public function loadViewLogin()
    {
        if (!empty($_SESSION['user'])) {
            $this->redirect(URL);
        }
        $this->load->render('client/login');
    }

    public function handleLogin()
    {
        // Kiểm tra dữ liệu nhập vào
        if (!validateLoginForm()) {
            // Redirect về trang đăng nhập và báo lỗi
            $this->redirect(URL . "?url=LoginController/loadViewLogin&error=validation_error");
        }

        $userModel = new UserModel();
        $user = $userModel->checkUserExist($_POST["email"]);
        if (!$user) {
            // Redirect về trang đăng nhập và báo lỗi
            $this->redirect(URL . "?url=LoginController/loadViewLogin&error=user_not_found");
        }

        // Xác thực mật khẩu
        if (password_verify($_POST['password'], $user['password'])) {
            // Xử lý session
            $_SESSION['user'] = $user;
            $_SESSION["role"] = $user["role"]; // Lưu vai trò của người dùng trong session

            if ($user["role"] == 0) {
                // Vai trò là admin
                $this->redirect(URL . "?url=PageController/dashboard");
            } elseif ($user["role"] == 1) {
                // Vai trò là người dùng
                $this->redirect(URL . "?url=PageController/home");
            }
        } else {
            // Redirect về trang đăng nhập và báo lỗi
            $this->redirect(URL . "?url=LoginController/loadViewLogin&error=wrong_password");
        }
    }
    public function add($id)
    {
        $user = $this->UserModel->getUserById($id);
    }
    public function logout()
    {
        unset($_SESSION['user']);
        unset($_SESSION['role']);
        $this->redirect(URL . "?url=PageController/login");
    }
}

function validateLoginForm()
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        return false;
    }
    $emailPattern = '/^[^\s@]+@[^\s@]+\.[^\s@]+$/';
    if (!preg_match($emailPattern, $email)) {
        return false;
    }

    return true;
}