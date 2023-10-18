<?php

namespace App\Http\Controllers;

use App\Repositories\AccessTokenRepositoryInterface;
use App\Services\AmoApiServiceInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TokenController extends Controller
{
    public function __construct(
        private AmoApiServiceInterface $amoApiService,
        private AccessTokenRepositoryInterface $tokenRepository,
    ) {
    }

    public function handle(Request $request)
    {
        if ($request->has('referer') and $request->has('code')) {
            $this->amoApiService->setAccountBaseDomain($request->get('referer'));
        } else {
            return response()->json(['error' => 'Invalid request!']);
        }

        try {
            $accessToken = $this->amoApiService->getAccessTokenByCode($request->get('code'));
            $this->amoApiService->setToken($accessToken);

            $accountId = $this->amoApiService->getAccountId();
            $this->tokenRepository->saveAccessToken($accountId, $accessToken);
        } catch (Exception $e) {
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }

        return Redirect::route('home', ['account_id' => $accountId]);
    }
}
