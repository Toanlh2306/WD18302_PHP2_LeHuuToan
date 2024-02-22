<?php

namespace App\Models;

class ProductModel extends BaseModel{

    protected $name = "ProductModel";
    public $tableName = 'products';

    public $table = "products";


    
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllWithPaginate(int $limit, int $offset){

    }

    public function getAllProducts()
    {
        return $this->getAll()->get();
    }

    public function getProductById($id)
    {
        return $this->select()->where('id', '=', $id)->first();
    }

    public function create($data)
    {
        $product = $this->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $product = $this->update($this->table, $id);
    }

    public function remove(int $id): bool
    {
        return true;
    }
}