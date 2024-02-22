<?php

namespace App\Controllers;

use App\Models\CommentModel;

class CommentController
{
    private $CommentModel;

    public function __construct()
    {
        $this->CommentModel = new CommentModel();
    }

    public function index()
    {
        $comment = $this->CommentModel->getAllComment();
        // Hiển thị danh sách sản phẩm
    }

    public function show($id)
    {
        $comment = $this->CommentModel->getCommentById($id);
        // Hiển thị thông tin sản phẩm
    }

    public function create()
    {
        // Hiển thị form tạo sản phẩm
        include 'create_product_form.php';
    }

    public function store()
    {
        // Xử lý dữ liệu gửi từ form tạo sản phẩm
        $data = $_POST;

        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
        $this->CommentModel->create($data);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }

    public function edit($id)
    {
        $comment = $this->CommentModel->getCommentByProductId($id);
        // Hiển thị form chỉnh sửa sản phẩm và truyền dữ liệu sản phẩm vào form
    }

    public function update($id)
    {
        // Xử lý dữ liệu gửi từ form chỉnh sửa sản phẩm
        $data = $_POST;
        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
        $this->CommentModel->create($data);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }

    public function delete($id)
    {
        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $this->CommentModel->remove($id);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }
}