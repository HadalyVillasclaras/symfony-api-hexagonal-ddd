<?php

namespace App\MyDashboard\Shared\Domain\ValueObject;


use App\MyDashboard\Shared\Domain\Exceptions\ValueObjects\InvalidRoleException;

class Role
{
    private string $value;

    public function __construct(?string $role)
    {
        if (empty($role) || $role == null) {
            $role = "ROLE_USER";
        }

        if (!$this->isvalid($role)) {
            throw new InvalidRoleException();
        }

        $this->value = $role;
    }

    private function isValid($role): bool
    {
        if (in_array($role, $this->validRoles())) {
            return true;
        }

        return false;
    }

    public function validRoles()
    {
        return [
            'ROLE_USER',
            'ROLE_CUSTOMER',
        ];
    }

    public function value()
    {
        return $this->value;
    }
}
