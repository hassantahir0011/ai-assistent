<?php

namespace App\Http\Controllers\Admin;

use App\Entities\ChannelConfig;
use App\Entities\ShopifyApiVersionUpdate;
use App\Entities\WebhookEvent;
use App\Entities\WebhookTopic;
use App\Http\Controllers\Controller;
use App\Jobs\ApiVersionUpdateNotification;
use Illuminate\Http\Request;
use Microsoft\Graph\Model\SharedPCAccountDeletionPolicyType;
use Session;

class NotificationsController extends Controller
{
    public function notifyApiVersionUpdateView(Request $request){
        $webhook_events = WebhookEvent::where('is_active', true)->get();
        $history = ShopifyApiVersionUpdate::orderBy('id', 'desc')->get();
        return view('admin.notifications.notify_api_version_update', compact('webhook_events', 'history'));
    }

    public function notifyApiVersionUpdate(Request $request, $send_email = false){
        try {
            $payload = json_decode($request->input('payload'));
            $record = ShopifyApiVersionUpdate::updateOrCreate(["id" => $request->input('id')], ["title" => $request->input('title'), "description" => $request->input('description'), "payload" => $payload, "status" => "pending" ]);
            $job = new ApiVersionUpdateNotification($record->id, $request->input('title'), $payload, $send_email);
            dispatch($job->onQueue('notification'));
            return response()->json(array("status" => "success", "message" => "Job created successfully!"));
        }
        catch (\Exception $e){
            return response()->json(array("status" => "error", "message" => $e->getMessage()));
        }
    }

    public function notifyApiVersionGetWebhookEvents(Request $request){
        return WebhookEvent::where('is_active', true)->get();
    }

    public function notifyApiVersionGetWebhookTopics(Request $request){
        $webhook_event_id = $request->input('id') ?? false;
        return $webhook_event_id ? WebhookTopic::where('webhook_event_id', $webhook_event_id)->where('topic_status', 'enabled')->get() : WebhookTopic::where('topic_status', 'enabled')->get();
    }

}
