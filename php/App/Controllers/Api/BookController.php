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
            $stmt = $this->db->prepare("INSERT INTO books (userId,moduleCode, publisher, price, pages, status, photo, comments,soldDate ) VALUES (:title, :author, :isbn, :published_date)");
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':author', $data['author']);
            $stmt->bindParam(':isbn', $data['isbn']);
            $stmt->bindParam(':published_date', $data['published_date']);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->errorResponse(400, "Failed to create record: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE books SET title = :title, author = :author, isbn = :isbn, published_date = :published_date WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':author', $data['author']);
            $stmt->bindParam(':isbn', $data['isbn']);
            $stmt->bindParam(':published_date', $data['published_date']);
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