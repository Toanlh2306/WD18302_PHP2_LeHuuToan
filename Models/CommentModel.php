<?php

namespace App\Models;

class CommentModel extends BaseModel{

    protected $name = "CommentModel";
    public $tableName = 'reviews';

    public $table = "reviews";


    
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllWithPaginate(int $limit, int $offset){

    }

    public function getAllComment()
    {
        return $this->getAll()->get();
    }

    public function getCommentById($id)
    {
        return $this->select()->where('id', '=', $id)->first();
    }
    public function getCommentByProductId($id)
    {
        return $this->select()->where('id_product', '=', $id)->get();
    }
    public function create($data)
    {
        $comment = $this->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        $comment = $this->update($this->table, $id);
    }

    public function remove(int $id): bool
    {
        return true;
    }
}