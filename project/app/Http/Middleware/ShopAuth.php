<?php

namespace App\Http\Middleware;

use Closure;

class ShopAuth
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
        if (!session('shop')) {
            $notice = 'Your sesssion has been expired!';
            $message = 'Please restart the app from app sections in shopify admin panel';
            if ($request->ajax())
                return response()->json(['status' => 'error', 'message' => $notice . $message]);
            return response()->view('errors.un_verrified_shopify_request', compact('notice', 'message'));
        }

        return $next($request);
    }
}
