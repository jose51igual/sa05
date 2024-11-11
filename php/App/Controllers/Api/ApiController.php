<?php
namespace BatoiBook\Controllers\Api;
class ApiController extends DBController
{

    /**
     * Envia una resposta JSON con un codi d'estat
     * 
     * @param mixed $data
     */
    public function jsonResponse(int $code, array $data): void
    {
        http_response_code($code);
        header("Content-Type: application/json");
        $body = json_encode($data);
        echo $body;
        exit;
    }

    /**
     * Envia una resposta JSON de error
     * 
     * @param string $message
     * @param int $errorCode
     */
    public function errorResponse(int $errorCode, string $message): void
    {
        http_response_code($errorCode);
        header("Content-Type: application/json");
        echo json_encode([
            'status' => 'error ' . $errorCode,
            'message' => $message
        ]);
    }
}