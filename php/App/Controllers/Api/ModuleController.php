<?php
namespace BatoiBook\Controllers\Api;

use \PDO;
use \PDOException;
use BatoiBook\Controllers\Api\ApiController;
use BatoiBook\Services\DBService;
use BatoiBook\Models\Module;

class ModuleController extends ApiController
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = DBService::connect();
    }

    public function getAll(): void
    {
        $stmt = $this->db->prepare("SELECT * FROM modules");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Module::class);

        $this->jsonResponse(201, $stmt->fetchAll());
    }

    public function getOne(int $id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM modules WHERE code = :code");
        $stmt->bindParam(':code', $id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, Module::class);
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
            $stmt = $this->db->prepare("INSERT INTO modules (code, cliteral, vliteral, courseId) VALUES (:code, :cliteral, :vliteral, :courseId)");
            $stmt->bindParam(':code', $data['code']);
            $stmt->bindParam(':cliteral', $data['cliteral']);
            $stmt->bindParam(':vliteral', $data['vliteral']);
            $stmt->bindParam(':courseId', $data['courseId']);
            $stmt->execute();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            $this->errorResponse(400, "Failed to create record: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE modules SET cliteral = :cliteral, vliteral = :vliteral, courseId = :courseId WHERE code = :code");
            $stmt->bindParam(':code', $data['code']);
            $stmt->bindParam(':cliteral', $data['cliteral']);
            $stmt->bindParam(':vliteral', $data['vliteral']);
            $stmt->bindParam(':courseId', $data['courseId']);
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
            $stmt = $this->db->prepare("DELETE FROM modules WHERE code = :code");
            $stmt->bindParam(':code', $id);
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