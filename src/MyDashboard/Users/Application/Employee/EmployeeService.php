<?php

declare(strict_types=1);

namespace App\mydashboard\Users\Application\Employee;

use App\mydashboard\Users\Domain\EmployeeRepositoryInterface;

abstract class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }
}
