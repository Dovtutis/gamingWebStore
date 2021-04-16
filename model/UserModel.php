<?php


namespace app\model;

use app\core\Database;
use app\core\Application;

/**
 * This model will handle SQL query's for registration and login
 *
 * Class UserModel
 * @package app\model
 */
class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    /**
     * Function for checking if email is already registered in the database.
     *
     * @param $email
     * @return bool
     */
    public function findUserByEmail($email)
    {
        $this->db->query("SELECT * FROM users WHERE email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->singleRow();
        if ($this->db->rowCount()>0){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Register function which creates SQL query, binds params and executes the query for user registration.
     *
     * @param $data
     * @return bool
     */
    public function register($data)
    {
        $this->db->query("INSERT INTO users (`firstname`, `lastname`, `email`, `phone`, `address`, `postal_code`, `password`) 
        VALUES (:firstname, :lastname, :email, :phone, :address, :postal_code, :password)");
        $this->db->bind(':firstname', $data['firstName']);
        $this->db->bind(':lastname', $data['lastName']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':postal_code', $data['postalCode']);
        $this->db->bind(':password', $data['password']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }

    /**
     * Login function which creates SQL query, binds params and executes the query for user login.
     *
     * @param $email
     * @param $password
     * @return false|mixed
     */
    public function login($email, $password)
    {
        $this->db->query("SELECT * FROM users WHERE `email` = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->singleRow();

        if ($row){
            $hashedPassword = $row->password;
        }else{
            return false;
        }

        if (password_verify($password, $hashedPassword)){
            return $row;
        }else {
            return false;
        }
    }

    public function getUserById($id)
    {
        $this->db->query("SELECT firstname, lastname, email, phone, address, postal_code FROM users WHERE user_id = :id");
        $this->db->bind(':id', $id);
        $row = $this->db->singleRow();
        if ($this->db->rowCount() > 0) {
            return $row;
        }
        return false;
    }

    public function editUserInfo($data)
    {
        $this->db->query("UPDATE users  SET 
             `firstname` = :firstname,
             `lastname` = :lastName,
             `email` = :email,
             `phone` = :phone,
             `address` = :address,
             `postal_code` = :postal_code
             WHERE `user_id` = :user_id");

        $this->db->bind(':firstname', $data['firstName']);
        $this->db->bind(':lastName', $data['lastName']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':postal_code', $data['postalCode']);
        $this->db->bind(':user_id', $data['userId']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function changeUserPassword($data)
    {
        $this->db->query("UPDATE users  SET `password` = :password WHERE `user_id` = :user_id");
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':user_id', $data['userId']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}