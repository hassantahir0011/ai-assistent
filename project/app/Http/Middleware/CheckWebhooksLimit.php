<?php

namespace App\Http\Middleware;

use App\Entities\ChannelConfig;
use Closure;
use DB;

class CheckWebhooksLimit
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
        // mrsindhu attention required
        $shop = session('shop');
        $shop_id = $shop['shop_id'] ?? 0;
        if ($shop && $shop_id) {
//           if no plan selected
            if (!session('current_plan_type')){
                if ($request->ajax()) {
                    return response()->json(['status' => "error", 'message' => "Please choose pricing plan to continue."]);
                } else {
                    return redirect()->route('plans_listing');
                }
            }


            $t_active_webhooks = ChannelConfig::where('shop_id', $shop_id)
                ->where('status', 1)
                ->count();
            $t_channels_used = 0;
            if ($request->route('channel_id'))
                if (!in_array($request->route('channel_id'), []))
                    $t_channels_used++;
            // call this middleware piece of code in case of updating webhook only
            if (!is_null($request->route('id'))) {
                $webhook = ChannelConfig::where('id', $request->route('id'))
                    ->where('shop_id', $shop_id)
                    ->select('status')->first();
                // check if stored webhook was enabled or current request has disabled status
                if (($webhook && $webhook->status == 1) || !in_array($request->status, ['enabled', "1"])){
                    $t_active_webhooks--;
                    $t_channels_used=0;
                }

            }

            $message = "Your plan's maximum allowed number of <b><em>Webhooks</em></b> or <b><em>Channels</em></b>  has been reached.<br/> Please upgrade your plan to continue to install more webhooks.";
            if ((session('current_plan_type') == 'basic' && ($t_active_webhooks >= 2 || $t_channels_used > 2)) || (session('current_plan_type') == 'professional' && ($t_active_webhooks >= 10 || $t_channels_used > 6))) {
                if ($request->ajax()) {
                    return response()->json(['status' => "error", 'message' => $message]);
                } else {
                    return response()->view('billing.plan_downgrade_error', compact('message'));
                }

            }
        }
        return $next($request);
    }
}
