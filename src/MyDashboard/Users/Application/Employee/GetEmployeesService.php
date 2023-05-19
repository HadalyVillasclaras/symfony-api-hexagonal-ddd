<?php

declare(strict_types=1);

namespace App\mydashboard\Users\Application\Employee;

use App\mydashboard\Users\Domain\Employee;

class GetEmployeesService extends EmployeeService
{
    /**
     * @var null|Employee[]
     */
    private $employees;

    public function execute(GetEmployeesRequest $getEmployeesRequest): array
    {
        $this->employees = $this->employeeRepository->findAll();

        return $this->serialize();
    }

    private function serialize()
    {
        $employees = [];

        foreach ($this->employees as $employee) {
            $employees[] = [
                'id' => $employee->getId(),
                'name' => $employee->getName(),
                'username' => $employee->getUsername(),
                'email' => $employee->getEmail(),
                'roles' => $employee->getRoles()
            ];
        }

        return $employees;
    }
}
