<?php

namespace App\Services;

use AmoCRM\Client\AmoCRMApiClient;
use AmoCRM\Client\AmoCRMApiClientFactory;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Filters\LeadsFilter;
use AmoCRM\Models\CatalogElementModel;
use AmoCRM\Models\LeadModel;
use AmoCRM\Models\Leads\Pipelines\PipelineModel;
use App\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

class AmoApiService implements AmoApiServiceInterface
{
    private AccessTokenInterface $accessToken;
    private AmoCRMApiClient $amo;

    public function __construct(
        private AccessTokenRepositoryInterface $tokenRepository,
        AmoCRMApiClientFactory $amoClientFactory
    ) {
        $this->amo = $amoClientFactory->make();
    }

    public function getLeadsByPage(int $page): ?LeadsCollection
    {
        $filter = new LeadsFilter();
        $filter->setLimit(50);
        $filter->setPage($page);

        return $this->amo->leads()->get($filter);
    }

    public function getCatalogElementById(int $catalogId, int $id): ?CatalogElementModel
    {
        return $this->amo->catalogElements($catalogId)->getOne($id);
    }

    public function getPipelineById(int $id): ?PipelineModel
    {
        return $this->amo->pipelines()->getOne($id);
    }

    public function getLeadById(int $id): ?LeadModel
    {
        return $this->amo->leads()->getOne($id, [
            LeadModel::CATALOG_ELEMENTS
        ]);
    }

    public function catalogElementsSyncOne(int $catalogId, CatalogElementModel $catalogElement): ?CatalogElementModel
    {
        return $this->amo->catalogElements($catalogId)->syncOne($catalogElement);
    }

    public function authenticate(int $accountId): bool
    {
        $token = $this->tokenRepository->get($accountId);

        if ($token === null) {
            return false;
        }

        $this->setToken($token->toAccessToken());

        return true;
    }

    public function getAuthorizeUrl(): string
    {
        return $this->amo->getOAuthClient()->getAuthorizeUrl([
            'state' => bin2hex(random_bytes(16)),
            'mode' => 'post_message',
        ]);
    }

    public function getAccountId(): int
    {
        return $this->amo->account()->getCurrent()->getId();
    }

    public function getAccessTokenByCode(string $code): AccessTokenInterface
    {
        return $this->amo->getOAuthClient()->getAccessTokenByCode($code);
    }

    public function setAccountBaseDomain(string $referer): void
    {
        $this->amo->setAccountBaseDomain($referer);
    }

    public function setToken(AccessTokenInterface $accessToken): void
    {
        $this->amo->setAccessToken($accessToken)->setAccountBaseDomain(
            $this->amo->getOAuthClient()->getAccountDomain($accessToken)->getDomain()
        );

        $this->amo->onAccessTokenRefresh(function (AccessTokenInterface $accessToken, string $baseDomain) {
            $this->tokenRepository->saveAccessToken($this->getAccountId(), $accessToken);
        });

        $this->accessToken = $accessToken;
    }
}
