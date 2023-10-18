<?php

namespace App\Repositories;

use App\Models\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    public function get(int $accountId): ?AccessToken
    {
        return AccessToken::where('account_id', $accountId)->first();
    }

    public function save(array $data): void
    {
        if (($token = $this->get($data['account_id'])) === null) {
            $token = new AccessToken();
            $token->setAccountId($data['account_id']);
        }

        $token->setAccessToken($data['access_token']);
        $token->setRefreshToken($data['refresh_token']);
        $token->setExpires($data['expires']);
        $token->save();
    }

    public function saveAccessToken(int $accountId, AccessTokenInterface $accessToken): void
    {
        $this->save([
            'account_id' => $accountId,
            'access_token' => $accessToken->getToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'expires' => $accessToken->getExpires(),
        ]);
    }
}
