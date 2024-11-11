<?php

abstract class ApiCRUDController extends ApiController
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
}