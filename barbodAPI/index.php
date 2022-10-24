<?php
declare(strict_types = 1);
spl_autoload_register(function ($class) {
    require __DIR__."/src/$class.php";
});
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
header("Content-Type: application/json; charset=UTF-8");

$database = new DB;
$gateway = new Gateway($database);
$controller = new Controller($gateway);

$parts = explode('/', $_SERVER['REQUEST_URI']);
$data = (array) json_decode(file_get_contents("php://input"));

if (array_key_exists("username", $data) && array_key_exists("password", $data) && $gateway->checkUsername($data['username']) && $gateway->checkPassword($data['username'], $data['password'])) {
    switch ($parts[3]) {
        case 'users':
            $controller->processUsers($_SERVER['REQUEST_METHOD']);
            break;
        case 'positions':
            $id = $parts[4] ?? null;
            $controller->processPositions($_SERVER['REQUEST_METHOD'], $id);
            break;
        case 'apps':
            $id = $parts[4] ?? null;
            $controller->processApps($_SERVER['REQUEST_METHOD'], $id);
            break;
        default:
            http_response_code(404);
            exit;
    }
} else {
    http_response_code(403);
    echo json_encode("Access Denied!");
    exit;
}