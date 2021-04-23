<?php


namespace app\model;

use app\core\Database;
use app\core\Application;

/**
 * This model will handle SQL query's for comments.
 *
 * Class CommentsModel
 * @package app\model
 */
class CommentsModel
{
    private $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    /**
     * Returns all comments from database.
     *
     * @return array|false
     */
    public function getComments()
    {
        $this->db->query('SELECT comments.body, comments.created_at, users.name FROM comments INNER JOIN users
        ON comments.user_id = users.id  ORDER BY created_at DESC');
        $comments = $this->db->resultSet();

        if ($this->db->rowCount() > 0){
            return $comments;
        }
        return false;
    }

    /**
     * Adds comment to the database
     *
     * @param $data
     * @return bool
     */
    public function addComment($data)
    {
        $this->db->query("INSERT INTO comments (user_id, body) VALUES (:user_id, :body)");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':body', $data['body']);

        if ($this->db->execute()){
            return true;
        }else {
            return false;
        }
    }
}