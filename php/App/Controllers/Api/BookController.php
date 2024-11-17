<?php
namespace BatoiBook\Controllers\Api;

use \PDO;
use \PDOException;
use BatoiBook\Controllers\Api\ApiController;
use BatoiBook\Services\DBService;

class BookController extends ApiController
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = DBService::connect();
    }

    public function getAll(): void
    {
        $stmt = $this->db->prepare("SELECT * FROM books");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->jsonResponse(201, $stmt->fetchAll());
    }

    public function getOne(int $id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $record = $stmt->fetch();

        if ($record) {
            $this->jsonResponse(201, $record);
        } else {
            $this->errorResponse(404, "Record not found");
        }
    }

    public function create(array $data): int
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO books (userId,moduleCode, publisher, price, pages, status, photo, comments,soldDate ) VALUES (:userId, :moduleCode, :publisher, :price, :pages, :status, :photo, :comments, :soldDate)");
            $stmt->bindParam(':userId', $data['userId']);
            $stmt->bindParam(':moduleCode', $data['moduleCode']);
            $stmt->bindParam(':publisher', $data['publisher']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':pages', $data['pages']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':photo', $data['photo']);
            $stmt->bindParam(':comments', $data['comments']);
            $stmt->bindParam(':soldDate', $data['soldDate']);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->errorResponse(400, "Failed to create record: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE books SET moduleCode = :moduleC , publisher = :publisher , price = :price , pages = :pages, status = :status , comments = :comments , soldDate = :soldDate  WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':moduleC', $data['moduleCode']);
            $stmt->bindParam(':publisher', $data['publisher']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':pages', $data['pages']);
            $stmt->bindParam(':status', $data['status']);
            $stmt->bindParam(':comments', $data['comments']);
            $stmt->bindParam(':soldDate', $data['soldDate']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->jsonResponse(201, ["message" => "Record updated successfully"]);
            } else {
                $this->errorResponse("Record not found", 404);
            }
        } catch (PDOException $e) {
            $this->errorResponse(400, "Failed to update record: " . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM books WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->jsonResponse(201, ["message" => "Record deleted successfully"]);
            } else {
                $this->errorResponse("Record not found", 404);
            }
        } catch (PDOException $e) {
            $this->errorResponse(400, "Failed to delete record: " . $e->getMessage());
        }
    }
}