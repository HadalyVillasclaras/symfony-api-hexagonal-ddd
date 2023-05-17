<?php

namespace App\MyDashboard\Books\Domain;

interface BookRepositoryInterface
{
    public function findOneBy(array $criteria, ?array $orderBy = null);

    public function findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null);

    public function findAll();

    public function save(Book $book): void;

    public function delete(Book $book): void;

    public function findByCriteria(array $criteria, int $limit,  int $offset): array;
}
