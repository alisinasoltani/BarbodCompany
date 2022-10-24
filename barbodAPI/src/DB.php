<?php
class DB {
    private $hostname;
    private $dbname;
    private $username;
    private $password;
    
    public function __construct() {
        $this->hostname = 'localhost';
        $this->dbname = 'barbod';
        $this->username = 'root';
        $this->password = '';
    }
    public function connect() {
        $dns = "mysql:hostname={$this->hostname};dbname={$this->dbname};charset=utf8";
        return new PDO($dns, $this->username, $this->password, [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]);
    }
}