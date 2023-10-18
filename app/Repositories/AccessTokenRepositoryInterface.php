<?php

namespace App\Repositories;

use App\Models\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface AccessTokenRepositoryInterface
{
    public function get(int $accountId): ?AccessToken;
    public function save(array $data): void;
    public function saveAccessToken(int $accountId, AccessTokenInterface $accessToken): void;
}
