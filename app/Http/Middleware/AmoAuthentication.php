<?php

namespace App\Http\Middleware;

use App\Services\AmoApiServiceInterface;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AmoAuthentication
{
    public function __construct(
        private AmoApiServiceInterface $amoApiService
    ) {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->amoApiService->authenticate((int)$request->get('account_id'))) {
            return new RedirectResponse($this->amoApiService->getAuthorizeUrl());
        }

        return $next($request);
    }
}
