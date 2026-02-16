<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MergeCart
{
    public function __construct(private CartService $cartService)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $this->cartService->mergeAfterLogin();
        return $next($request);
    }
}
