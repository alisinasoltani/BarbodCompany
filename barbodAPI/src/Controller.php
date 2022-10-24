<?php
class Controller {
    private $gateway;

    public function __construct(Gateway $gateway) {
        $this->gateway = $gateway;
    }

    public function processUsers(string $method) {
        switch ($method) {
            case 'GET':
                $data = (array) json_decode(file_get_contents("php://input"), true);
                if (array_key_exists('username', $data) && array_key_exists('password', $data)) {
                    if ($this->gateway->checkUsername($data['username']) && $this->gateway->checkPassword($data['username'], $data['password'])) {
                        http_response_code(200);
                        echo json_encode(true);
                    } else {
                        http_response_code(404);
                        echo json_encode(false);
                    }
                }
                break;
            default:
                http_response_code(405);
                header("Allow: GET");
                break;
        }
    }

    public function processPositions($method, $id) {
        switch ($method) {
            case 'GET':
                $result = $this->gateway->getPositions($id);
                echo json_encode($result);
                break;
            case 'POST':
                $data = (array) json_decode(file_get_contents("php://input"));
                if (array_key_exists("id", $data) && array_key_exists("title", $data) && array_key_exists("type", $data) && array_key_exists("city", $data) && array_key_exists("description", $data) && array_key_exists("options", $data)) {
                    $this->gateway->setPosition($data);
                } else {
                    http_response_code(422);
                    echo json_encode("Invalid Data!");
                }
                break;
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    public function processApps($method, $id) {
        
    }
}