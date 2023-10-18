<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use League\OAuth2\Client\Token\AccessToken as OAuthAccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AccessToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'access_token',
        'refresh_token',
        'expires',
    ];

    public function toAccessToken(): AccessTokenInterface
    {
        return new OAuthAccessToken($this->toArray());
    }

    public function getAccountId(): int
    {
        return $this->getAttributeFromArray('account_id');
    }

    public function setAccountId(int $value): void
    {
        $this->setAttribute('account_id', $value);
    }

    public function getAccessToken(): string
    {
        return $this->getAttributeFromArray('access_token');
    }

    public function setAccessToken(string $value): void
    {
        $this->setAttribute('access_token', $value);
    }

    public function getRefreshToken(): string
    {
        return $this->getAttributeFromArray('refresh_token');
    }

    public function setRefreshToken(string $value): void
    {
        $this->setAttribute('refresh_token', $value);
    }

    public function getExpires(): int
    {
        return $this->getAttributeFromArray('expires');
    }

    public function setExpires(int $value): void
    {
        $this->setAttribute('expires', $value);
    }
}
