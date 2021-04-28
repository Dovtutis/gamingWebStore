<?php


namespace app\model;

use app\core\Database;
use app\core\Application;

class ShoppingCartModel
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO shopping_cart (`user_id`, `items`) 
    VALUES (:user_id, :items)");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':items', $data['items']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function delete($shopping_cart_id)
    {
        $this->db->query("DELETE FROM shopping_cart WHERE shopping_cart_id = :shopping_cart_id LIMIT 1");
        $this->db->bind(':shopping_cart_id', $shopping_cart_id);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function getAll($user_id)
    {
        $this->db->query("SELECT * FROM shopping_cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->resultSet();;

        if ($this->db->rowCount() > 0){
            return $result;
        }
        return false;
    }

    public function getQuantity($id)
    {
        $this->db->query("SELECT item_quantity FROM shopping_cart WHERE shopping_cart_id  = :shopping_cart_id");
        $this->db->bind(':shopping_cart_id', $id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }

    public function checkQuantity($item_id, $item_quantity)
    {
        $this->db->query("SELECT IF(item_quantity >= :item_quantity, true, false) AS response FROM items WHERE item_id = :item_id");
        $this->db->bind(':item_quantity', $item_quantity);
        $this->db->bind(':item_id', $item_id);
        $result = $this->db->singleRow();
        $result = $result->response;
        return $result;
    }

    public function edit($data)
    {
        $this->db->query("UPDATE shopping_cart SET items = :items WHERE shopping_cart_id = :shopping_cart_id");
        $this->db->bind(':items', $data['items']);
        $this->db->bind(':shopping_cart_id', $data['shopping_cart_id']);
        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function checkIfItemExists($user_id, $item_id)
    {
        $this->db->query("SELECT shopping_cart_id FROM shopping_cart WHERE item_id = :item_id AND user_id = :user_id");
        $this->db->bind(':item_id', $item_id);
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }

    public function getCartQuantity($user_id)
    {
        $this->db->query("SELECT count(*) as quantity FROM shopping_cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }
}

