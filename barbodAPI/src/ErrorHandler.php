<?php

class ErrorHandler {
    public static function handleException(Throwable $exp) {
        http_response_code(505);
        echo json_encode([
            "code" => $exp->getCode(),
            "message" => $exp->getMessage(),
            "file" => $exp->getFile(),
            "line" => $exp->getLine()
        ]);
    }

    public static function handleError(int $errno, string $errstr, string $errfile, int $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}