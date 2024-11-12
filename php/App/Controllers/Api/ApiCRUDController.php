<?php

namespace BatoiBook\Controllers\Api;

abstract class ApiCRUDthis extends ApiController
{
    public function __construct()
    {
        parent::__construct();
    }

    abstract public function getAll(): void;

    abstract public function getOne(int $id): void;

    abstract public function create(array $data): int;

    abstract public function update(int $id, array $data): void;

    abstract public function delete(int $id): void;

    public function handleRequest(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        switch ($method) {
            case 'GET':
                if (isset($id)) {
                    $this->getOne($id);
                } else {
                    $this->getAll ();
               }
                break;
            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);

                if ($data) {
                    $this->create($data);
                } else {
                    echo json_encode(["error" => "Invalid data"]);
                }
                break;
            case 'PUT':
                $data = json_decode(file_get_contents('php://input'), true);

                if (isset($_GET['id']) && $data) {
                    $success = $this->update ($id, $data);
                    echo json_encode(["message" => $success ? "Field updated successfully" : "Book not found"]);
                } else {
                    echo json_encode(["error" => "Invalid data or ID"]);
                }
                break;
            case 'DELETE':
                if (isset($_GET['id'])) {
                    $this->delete ($id);
                } else {
                    echo json_encode(["error" => "ID not provided"]);
                }
                break;
            default:
                echo json_encode(["error" => "Invalid request method"]);
                break;
        }
    }
}