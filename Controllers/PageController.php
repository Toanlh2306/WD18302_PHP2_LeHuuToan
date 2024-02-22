<?php

namespace App\Controllers;

use App\Core\RenderBase;
use App\Models\ProductModel;
use App\Models\CommentModel;

class PageController extends BaseController
{
    private $productModel;
    private $CommentModel;
    private $_renderBase;
    function __construct()
    {
        parent::__construct();
        $this->_renderBase = new RenderBase();
        $this->productModel = new ProductModel();
        $this->CommentModel = new CommentModel();
    }
    public function home()
    {
        // dữ liệu ở đây lấy từ responsitories hoặc model
        $this->_renderBase->renderHeader();
        $this->load->render('client/home');
        $this->_renderBase->renderFooter();
    }
    public function about()
    {
        // dữ liệu ở đây lấy từ responsitories hoặc model
        $this->_renderBase->renderHeader();
        $this->load->render('client/about');
        $this->_renderBase->renderFooter();
    }
    public function contact()
    {
        // dữ liệu ở đây lấy từ responsitories hoặc model
        $this->_renderBase->renderHeader();
        $this->load->render('client/contact');
        $this->_renderBase->renderFooter();
    }
    public function product()
    {
        $data = [
            "products" => $this->productModel->getAllProducts(),
        ];
        // dữ liệu ở đây lấy từ responsitories hoặc model
        $this->_renderBase->renderHeader();
        $this->load->render('client/products', $data);
        $this->_renderBase->renderFooter();
    }
    public function dashboard()
    {
        // dữ liệu ở đây lấy từ responsitories hoặc model       
        $this->load->render('admin/dashboard');
    }
    public function login()
    {
        // dữ liệu ở đây lấy từ responsitories hoặc model
        $this->load->render('client/login');
    }
    function detail($id)
    {
        $product = $this->productModel->getProductById($id);
        $comment = $this->CommentModel->getCommentByProductId($id);
        // Kiểm tra xem sản phẩm có tồn tại hay không
        if ($product) {     
            $this->_renderBase->renderHeader();
            // Truyền dữ liệu sản phẩm vào view chi tiết sản phẩm
            $this->load->render('client/product_detail', ['product' => $product,'comment' => $comment]);
            $this->_renderBase->renderFooter();
        } else {
            // Xử lý khi sản phẩm không tồn tại
            // Ví dụ: Hiển thị thông báo lỗi hoặc chuyển hướng đến trang 404
        }
    }

}