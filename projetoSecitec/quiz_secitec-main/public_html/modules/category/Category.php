<?php 

class Category {
    private $pdo;
    private $table = "Category";
    public function __construct(){
        $this->pdo = new Mysql();
    }
    public function create($sql){
        $this->pdo->insert($this->table, $sql);
    }
    public function select($sql, $conditions){
        return $this->pdo->select($this->table, $sql, $conditions);
    }
    public function selectById($sql, $condition){
        return $this->pdo->selectById($this->table, $sql, $condition);
    }
    public function update($sql, $conditions){
        $this->pdo->update($this->table, $sql, $conditions);
    }
    public function delete($conditions){
        $this->pdo->delete($this->table, $conditions);
    }
    public function getTable(){
        return $this->table;
    }
}
