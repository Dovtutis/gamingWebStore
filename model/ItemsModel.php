<?php

namespace app\model;

use app\core\Database;
use app\core\Application;

/**
 * This model will handle SQL query's for orders.
 *
 * Class OrdersModel
 * @package app\model
 */
class ItemsModel
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function add($data)
    {
        $this->db->query("INSERT INTO items (`item_name`, `item_image`, `item_price`, `item_quantity`, `item_description`) 
            VALUES (:item_name, :item_image, :item_price, :item_quantity, :item_description)");
        $this->db->bind(':item_name', $data['item']['itemName']);
        $this->db->bind(':item_image', $data['item']['itemImage']);
        $this->db->bind(':item_price', $data['item']['itemPrice']);
        $this->db->bind(':item_quantity', $data['item']['itemQuantity']);
        $this->db->bind(':item_description', $data['item']['itemDescription']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    public function getAll()
    {
        $sql = "SELECT * FROM items";

        $this->db->query($sql);
        $result = $this->db->resultSet();

        return $result;
    }

    public function search($searchQuery)
    {
        $this->db->query("SELECT * FROM items WHERE item_name LIKE :searchQuery ");
        $this->db->bind(':searchQuery', "%" . $searchQuery . "%");
        $result = $this->db->resultSet();
        if ($this->db->rowCount() > 0){
            return $result;
        }
        return false;
    }

    public function getOne($id)
    {
        $this->db->query("SELECT * FROM items WHERE item_id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }

    public function getItemQuantity($item_id)
    {
        $this->db->query("SELECT item_quantity FROM items WHERE item_id = :item_id");
        $this->db->bind(':item_id', $item_id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }

    public function editItemQuantity($id, $quantity)
    {
        $this->db->query("UPDATE items SET item_quantity = :item_quantity WHERE item_id = :id");
        $this->db->bind(':item_quantity', $quantity);
        $this->db->bind(':id', $id);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}