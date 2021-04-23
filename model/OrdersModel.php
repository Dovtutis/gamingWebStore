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
class OrdersModel
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    /**
     * Adds an order to database.
     *
     * @return array|false
     */
    public function addOrder($data)
    {
        $this->db->query("INSERT INTO orders (`user_id`, `order_list`, `status`) VALUES (:user_id, :order_list, :status)");
        $this->db->bind(':user_id', $data['userId']);
        $this->db->bind(':order_list', $data['orderList']);
        $this->db->bind(':status', $data['status']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Returns all orders from database.
     *
     * @return array|false
     */
    public function getAllOrders()
    {
        $this->db->query("SELECT * FROM orders");
        $orders = $this->db->resultSet();

        if ($this->db->rowCount() > 0){
            return $orders;
        }
        return false;
    }

    /**
     * Returns all orders from database.
     *
     * @return array|false
     */
    public function getAllOrdersByUser($user_id)
    {
        $this->db->query("SELECT * FROM orders WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        $orders = $this->db->resultSet();

        if ($this->db->rowCount() > 0){
            return $orders;
        }
        return false;
    }

    public function updateOrder($data) {
        $this->db->query("UPDATE orders SET `message` = :orderMessage, `status` = :orderStatus WHERE id = :id");
        $this->db->bind(':orderMessage', $data['order-message']);
        $this->db->bind(':orderStatus', $data['order-status']);
        $this->db->bind(':id', $data['order-id']);
        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}