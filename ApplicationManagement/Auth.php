<?php
class Auth {
    private $db;
    
    public function __construct(DB $db) {
        $this->db = $db->connect();
    }

    public function checkUsername(string $username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPassword(string $username, string $password) {
        $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":password", md5($password), PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPremission(string $username, string $password, string $premission) {
        if (checkUsername($username, $password) && checkPassword($username, $password)) {
            switch ($premission) {
                case 'apps':
                    $sql = "SELECT apps from users WHERE username = :username";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $result;
                
                case 'content':
                    $sql = "SELECT content from users WHERE username = :username";
                    $stmt = $this->db->prepare($sql);
                    $stmt->bindValue(":username", $username, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $result;
                
                default:
                    break;
            }
        }
    }
}