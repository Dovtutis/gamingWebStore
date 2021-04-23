<?php


namespace app\core;


class Database
{
    private \PDO $dbh;
    private \PDOStatement $stmt;
    private string $error;

    /**
     * Database constructor. Defines a lightweight interface for accessing database.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $dsn = $config['dsn'];
        $user = $config['user'];
        $password = $config['password'];

        $options = [
            \PDO::ATTR_PERSISTENT => false,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new \PDO($dsn, $user, $password, $options);
        } catch (PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    /**
     * Prepares statement with SQL query
     *
     * @param $sql
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    /**
     * Check argument type and bind accordingly
     * @param $param
     * @param $value
     * @param null $type
     */
    public function bind($param, $value, $type = null){
        if (is_null($type)){
            switch (true){
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute the saved statement
     * @return bool
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Executing statement. Getting all results as an array of objects
     * @return array
     */
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Executing statement. Getting single result row as object
     * @return mixed
     */
    public function singleRow()
    {
        $this->execute();
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Get statement affected or returned row count.
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}