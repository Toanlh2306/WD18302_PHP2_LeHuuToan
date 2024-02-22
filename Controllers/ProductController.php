<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();
        // Hiển thị danh sách sản phẩm
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
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

        // Kiểm tra có dữ liệu fileupload trong $_FILES không
        if (isset($_FILES["thumbnail"])) {
            // Thư mục bạn sẽ lưu file upload
            $target_dir = "uploads/";

            // Tạo tên file mới dựa trên thời gian upload
            $file_name = date('YmdHis') . '_' . $_FILES["thumbnail"]["name"];

            // Vị trí file lưu tạm trong server (file sẽ lưu trong thư mục uploads với tên mới)
            $target_file = $target_dir . $file_name;

            $allowUpload = true;

            //Lấy phần mở rộng của file (jpg, png, ...)
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Cỡ lớn nhất được upload (bytes)
            $maxfilesize = 800000;

            // Những loại file được phép upload
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

            // Kiểm tra xem có phải là ảnh bằng hàm getimagesize
            $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
            if ($check !== false) {
                $allowUpload = true;
            } else {
                $allowUpload = false;
            }

            // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
            if (file_exists($target_file)) {
                $allowUpload = false;
            }

            // Kiểm tra kích thước file upload
            if ($_FILES["thumbnail"]["size"] > $maxfilesize) {
                $allowUpload = false;
            }

            // Kiểm tra kiểu file
            if (!in_array($imageFileType, $allowtypes)) {
                $allowUpload = false;
            }
            var_dump($target_file);
            if ($allowUpload) {
                // Di chuyển file tạm ra thư mục lưu trữ
                if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                    $data['thumbnail'] = $file_name;
                }
            }
        }

        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
        $this->productModel->create($data);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        // Hiển thị form chỉnh sửa sản phẩm và truyền dữ liệu sản phẩm vào form
    }

    public function update($id)
    {
        // Xử lý dữ liệu gửi từ form chỉnh sửa sản phẩm
        $data = $_POST;

        // Kiểm tra có dữ liệu fileupload trong $_FILES không
        if (isset($_FILES["thumbnail"])) {
            // Thư mục bạn sẽ lưu file upload
            $target_dir = "uploads/";

            // Tạo tên file mới dựa trên thời gian upload
            $file_name = date('YmdHis') . '_' . $_FILES["thumbnail"]["name"];

            // Vị trí file lưu tạm trong server (file sẽ lưu trong thư mục uploads với tên mới)
            $target_file = $target_dir . $file_name;

            $allowUpload = true;

            //Lấy phần mở rộng của file (jpg, png, ...)
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            // Cỡ lớn nhất được upload (bytes)
            $maxfilesize = 800000;

            // Những loại file được phép upload
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');

            // Kiểm tra xem có phải là ảnh bằng hàm getimagesize
            $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
            if ($check !== false) {
                $allowUpload = true;
            } else {
                $allowUpload = false;
            }

            // Kiểm tra nếu file đã tồn tại thì không cho phép ghi đè
            if (file_exists($target_file)) {
                $allowUpload = false;
            }

            // Kiểm tra kích thước file upload
            if ($_FILES["thumbnail"]["size"] > $maxfilesize) {
                $allowUpload = false;
            }

            // Kiểm tra kiểu file
            if (!in_array($imageFileType, $allowtypes)) {
                $allowUpload = false;
            }

            if ($allowUpload) {
                // Di chuyển file tạm ra thư mục lưu trữ
                if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
                    $data['image'] = $file_name;
                }
            }
        }

        // Lưu thông tin sản phẩm vào cơ sở dữ liệu
        $this->productModel->create($data);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }

    public function delete($id)
    {
        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $this->productModel->remove($id);

        // Chuyển hướng đến trang danh sách sản phẩm
        $this->index();
    }
}