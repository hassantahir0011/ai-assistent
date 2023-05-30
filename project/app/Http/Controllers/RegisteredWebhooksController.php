<?php

namespace App\Http\Controllers;

use App\Entities\ChannelConfig;
use App\Services\WebhookLogs;
use Redirect;
use Session;
use App\Services\ShopifyService;
use DB;
use URL;


class RegisteredWebhooksController extends Controller
{
    private $shopify_service;

    private $webhook_logs;

    public function __construct(ShopifyService $shopify_service,  WebhookLogs $webhook_logs)
    {
        $this->webhook_logs = $webhook_logs;
        $this->shopify_service = $shopify_service;
    }
    public
    function registered_webhooks_ajax()
    {
        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        $qry = ChannelConfig::where('shop_id', $shop_id)
            ->join('webhook_topics', 'channel_configs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')
            ->join('webhook_events', 'webhook_topics.webhook_event_id', '=', 'webhook_events.id', 'inner')
            ->select('channel_configs.*', 'webhook_topics.webhook_event_id','webhook_topics.topic_name', 'webhook_events.event_name as webhook_event_name', 'webhook_events.slug as webhook_event_slug');
        if (!empty($_REQUEST['sSearch'])) {
            session()->put('sSearch_hooks', $_REQUEST['sSearch']);
            $search = $_REQUEST['sSearch'];
            //$qry->where(DB::raw("CONCAT('channels.name','webhook_topics.topic_name') LIKE '% $search %'"));
            $qry->where(function ($query) use ($search) {
                $query->orWhere('webhook_topics.topic_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('channel_configs.description', 'LIKE', '%' . $search . '%');
            });
        } else {
            session()->forget('sSearch_hooks');
        }
        if ($_REQUEST['iDisplayStart']) {
            $offset = $_REQUEST['iDisplayStart'];
            $qry->offset($offset);
        }
        if ($_REQUEST['iDisplayLength']) {
            $limit = $_REQUEST['iDisplayLength'];
            $qry->limit($limit);
        }
        if (isset($_REQUEST['iSortCol_0']) && isset($_REQUEST['sSortDir_0'])) {
            $sort_order = $_REQUEST['sSortDir_0'];
            $sort_column_number = $_REQUEST['iSortCol_0'];
            $sort_column = [
                4 => 'created_at',   3 => 'updated_at', 1 => 'topic_name', 2 => 'status', 0 => 'channel_name'];
            if (!array_key_exists($sort_column_number, $sort_column)) {
                $column = 'id';
                $sort_order = 'desc';
            } else {
                $column = $sort_column[$sort_column_number];
            }
            $qry->orderBy($column, $sort_order);
        }
        $store_snippets = $qry->get();
        $data = [];
        if (count($store_snippets) > 0) {
            $serial = $_REQUEST['iDisplayStart'];
            foreach ($store_snippets as $row):
                $serial++;
                $obj = new \stdClass;
                $obj->serial_no = $serial;
                $obj->topic_name = $row->topic_name;
                $obj->post_url = $row->post_url;
                $obj->status = $row->status;
                $obj->channel_name = ucwords(str_replace('_',' ',config('channel.name')));
                $obj->description = $row->description;
                $obj->icon_path = config('channel.icon_path');
                $obj->edit_route = route('channel_config'  ,[$row->webhook_event_slug,$row->id]);
                $obj->update_status_route = route('update_event_status'  ,[$row->id]);
                $obj->updated_at = humanDateFormat($row->updated_at);
                $obj->created_at = humanDateFormat($row->created_at);
                $obj->channel_event_name = $row->channel_event_settings->channel_event->name ?? ($row->channel_event_settings->object_text) ?? '';
                $obj->id = $row->id;
                $obj->delete_route = route('delete_registered_webhook', [$row->id]);
                $data[] = $obj;
            endforeach;

        }
        $qry = ChannelConfig::where('shop_id', $shop_id)
            ->join('webhook_topics', 'channel_configs.webhook_topic_id', '=', 'webhook_topics.id', 'inner');

        if (!empty($_REQUEST['sSearch'])) {
            $search = $_REQUEST['sSearch'];
            $qry->where(function ($query) use ($search) {
                $query->orWhere('webhook_topics.topic_name', 'LIKE', '%' . $search . '%');
                $query->orWhere('channel_configs.description', 'LIKE', '%' . $search . '%');
            });
        }
        $filtered_count = $qry->count();
        $count = ChannelConfig::where('shop_id', $shop_id)->count();
        return json_encode(array('data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => $filtered_count));

    }
    public function index()
    {
        $shop = session('shop');
        return view('registered_webhooks', compact('shop'));

    }


}
