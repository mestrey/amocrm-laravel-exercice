<?php

namespace App\Services;

use AmoCRM\Collections\Leads\LeadsCollection;
use League\OAuth2\Client\Token\AccessTokenInterface;

interface AmoApiServiceInterface
{
    public function authenticate(int $accountId): bool;

    public function getAuthorizeUrl(): string;
    public function getAccountId(): int;
    public function getAccessTokenByCode(string $code): AccessTokenInterface;

    public function setAccountBaseDomain(string $referer): void;
    public function setToken(AccessTokenInterface $accessToken): void;

    public function getLeadsByPage(int $page): ?LeadsCollection;
}
