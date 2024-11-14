<?php
namespace BatoiBook\Controllers\Api;

use \PDO;
use \PDOException;
use BatoiBook\Controllers\Api\ApiController;
use BatoiBook\Services\DBService;

class CourseController extends ApiController
{
    protected PDO $db;
    public function __construct()
    {
        $this->db = DBService::connect();
    }

    public function getAll(): void
    {
        $stmt = $this->db->prepare("SELECT * FROM courses");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $this->jsonResponse(201,$stmt->fetchAll());
    }

    public function getOne(int $id): void
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $record = $stmt->fetch(PDO::FETCH_CLASS);

        if ($record) {
            $this->jsonResponse(201,$record);
        } else {
            $this->errorResponse(404,"Record not found" );
        }
    }

    public function create(array $data): int
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO courses (code,cliteral,vliteral,courseId) VALUES (:code,:cliteral,:vliteral,:courseId)");
            $stmt->bindParam(':code', $data['code']);
            $stmt->bindParam(':cliteral', $data['cliteral']);
            $stmt->bindParam(':vliteral', $data['vliteral']);
            $stmt->bindParam(':courseId', $data['courseId']);
            $stmt->execute();
            return $this->db->lastInsertId();
         } catch (PDOException $e) {
            $this->errorResponse(400,"Failed to create record: " . $e->getMessage());
        }
    }

    public function update(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("UPDATE courses SET cliteral = :cliteral, vliteral = :vliteral, courseId = :courseId WHERE code = :code");
            $stmt->bindParam(':code', $data['code']);
            $stmt->bindParam(':cliteral', $data['cliteral']);
            $stmt->bindParam(':vliteral', $data['vliteral']);
            $stmt->bindParam(':courseId', $data['courseId']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->jsonResponse(201,["message" => "Record updated successfully"]);
            } else {
                $this->errorResponse("Record not found", 404);
            }
        } catch (PDOException $e) {
            $this->errorResponse(400,"Failed to update record: " . $e->getMessage());
        }
    }

    public function delete(int $id): void
    {
        try{
            $stmt = $this->db->prepare("DELETE FROM courses WHERE code = :code");
            $stmt->bindParam(':code', $id);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $this->jsonResponse(201,["message" => "Record deleted successfully"]);
            } else {
                $this->errorResponse("Record not found", 404);
            }
        }catch(PDOException $e){
            $this->errorResponse(400,"Failed to delete record: " . $e->getMessage());
        }
        
    }
}