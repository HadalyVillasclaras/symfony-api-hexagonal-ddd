<?php

namespace App\MyDashboard\Users\Domain;

interface ApiUserRepositoryInterface
{
    public function findByApiKey(string $apikey): ?ApiUser;
}
