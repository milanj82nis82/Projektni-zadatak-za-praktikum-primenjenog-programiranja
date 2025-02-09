<?php
namespace Include;
use PDOException;
session_start();


class DbConnect {

private $host;
private $dbname;
private $username;
private $password;
private $pdo;

public function __construct($host = HOST, $dbname = DBNAME, $username = USERNAME, $password = PASSWORD) {
    $this->host = $host;
    $this->dbname = $dbname;
    $this->username = $username;
    $this->password = $password;
}
protected function connect() {
    if ($this->pdo === null) {
        try {
            $sql = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            $this->pdo = new \PDO($sql, $this->username, $this->password);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->pdo->exec('SET NAMES UTF8');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    return $this->pdo;
}

}// DbConnect