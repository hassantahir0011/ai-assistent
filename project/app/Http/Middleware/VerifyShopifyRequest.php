<?php

namespace App\Http\Middleware;

use Closure;
use Oseintow\Shopify\Facades\Shopify;

class VerifyShopifyRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Shopify::verifyWebHook($request->getContent(), $request->server('HTTP_X_SHOPIFY_HMAC_SHA256'))) {
            return response()->json(['error' => 1, 'message' => 'Unverified Request'],401);
        }
        return $next($request);
    }
}
