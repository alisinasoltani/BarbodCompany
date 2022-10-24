<?php
class Gateway {
    private $db;

    public function __construct(DB $db) {
        $this->db = $db->connect();
    }

    public function getApps() {
        $sql = "SELECT * FROM positions";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getPositions($id) {
        if ($id) {
            $sql = "SELECT * FROM positions";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;
        } else {
            $sql = "SELECT * FROM positions WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function setPosition(array $data) {
        $sql = "INSERT INTO positions (`title`,`type`,`city`,`description`,`options`)
        VALUES (:title, :type, :city, :description, :options)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":title", $data['title'], PDO::PARAM_STR);
        $stmt->bindValue(":type", $data['type'], PDO::PARAM_STR);
        $stmt->bindValue(":city", $data['city'], PDO::PARAM_STR);
        $stmt->bindValue(":description", $data['description'], PDO::PARAM_STR);
        $stmt->bindValue(":options", $data['options'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
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