<?php
class DB {
    private $hostname = "localhost";
    private $dbname = "barbod";
    private $username = "root";
    private $password = "";

    public function connect() {
        $dns = "mysql:host={$this->hostname};dbname={$this->dbname};charset=utf8";
        return new PDO($dns, $this->username, $this->password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}