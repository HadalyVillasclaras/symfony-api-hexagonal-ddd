<?php

namespace App\mydashboard\Users\Domain;

interface EmployeeRepositoryInterface
{
    public function findById(int $id): ?Employee;

    public function findByEmail(string $email): ?Employee;

    /**
     * findAll
     *
     * @return null|Employee[]
     */
    public function findAll(): ?array;
}
