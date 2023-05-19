<?php

namespace App\mydashboard\Users\Domain;

interface ApiUserRepositoryInterface
{
    public function findById(string $id): ?ApiUser;

    public function findByEmail(string $email): ?ApiUser;

    public function findByApiKey(string $apikey): ?ApiUser;
}
