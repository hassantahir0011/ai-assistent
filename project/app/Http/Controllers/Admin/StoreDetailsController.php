<?php

namespace App\Http\Controllers\Admin;

use App\Entities\FavoriteConnectorWithWebhookEvent;
use App\Entities\Shop;
use App\Entities\WebhookEvent;
use App\Entities\WebhookLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class StoreDetailsController extends Controller
{
    public function stores_select2_format(Request $request)
    {
        $final_array = [];
        $stores = Shop::where('id', '!=', 0)->limit(50);
        if ($request->search) {
            $search = $request->search;
            $stores = $stores->where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%' . $search . '%');
                $query->orWhere('myshopify_domain', 'LIKE', '%' . $search . '%');
                $query->orWhere('domain', 'LIKE', '%' . $search . '%');
            });
        }
        $stores = $stores->get();
        foreach ($stores as $key => $store) {
            $final_array[$key]['text'] = $store->name . " (" . $store->myshopify_domain . " )";
            $final_array[$key]['id'] = $store->shop_id;
        }
        return ['results' => $final_array];
    }

    public function logs()
    {
        return view('admin.logs.index');
    }

    public
    function store_logs_listing_ajax()
    {

        $qry = WebhookLog::orderBy('id', "desc")
            ->join('webhook_topics', 'webhook_logs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')
            ->select('shops.name as shop_name', 'shops.myshopify_domain', 'webhook_logs.*', 'webhook_topics.webhook_event_id', 'webhook_topics.topic_name')
            ->join('shops', 'shops.shop_id', '=', 'webhook_logs.shop_id', 'inner');
        if (!empty($_REQUEST['sSearch'])) {
            session()->put('storeLogSearch', $_REQUEST['sSearch']);
            $search = $_REQUEST['sSearch'];
            $qry->where(function ($query) use ($search) {
                $query->orWhere('webhook_topics.topic_name', 'LIKE', '%' . $search . '%');
            });
        } else {
            session()->forget('storeLogSearch');
        }
        if (!empty($_REQUEST['shop_id']) && $_REQUEST['shop_id']!=="all") {
            $qry->where('webhook_logs.shop_id', $_REQUEST['shop_id']);
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
                5 => 'created_at', 3 => 'status', 1 => 'channel_name'];
            if (!array_key_exists($sort_column_number, $sort_column)) {
                $column = 'id';
                $sort_order = 'desc';
            } else {
                $column = $sort_column[$sort_column_number];
            }
            $qry->orderBy($column, $sort_order);
        }
        if ($_REQUEST['webhook_status']) {
            $webhook_status = $_REQUEST['webhook_status'];
            $qry->where("webhook_logs.status", $webhook_status);
        }
        if ($_REQUEST['trigger_at']) {
            $trigger_at = $_REQUEST['trigger_at'];
            $qry->whereDate("webhook_logs.created_at", $trigger_at);
        }
        $store_snippets = $qry->get();
        $data = [];
        if (count($store_snippets) > 0) {
            $serial = $_REQUEST['iDisplayStart'];
            foreach ($store_snippets as $row):
                $serial++;
                $obj = new \stdClass;
                $obj->serial_no = $serial;
                $obj->shop_name = $row->shop_name;
                $obj->myshopify_domain = $row->myshopify_domain;
                $obj->topic_name = $row->topic_name;
                $obj->status = $row->status;
                $obj->channel_name = ucwords(str_replace('_', ' ', config('channel.name')));
                $obj->icon_path = config('channel.icon_path');
                $obj->message = $row->message;
                $obj->created_at =getDateWithTimeZone($row->created_at,"Asia/Karachi");
                $obj->id = $row->id;
                $data[] = $obj;
            endforeach;

        }
        $qry = WebhookLog::orderBy('id', "desc")
            ->join('webhook_topics', 'webhook_logs.webhook_topic_id', '=', 'webhook_topics.id', 'inner');

        if (!empty($_REQUEST['sSearch'])) {
            $search = $_REQUEST['sSearch'];
            $qry->where(function ($query) use ($search) {
                $query->orWhere('webhook_topics.topic_name', 'LIKE', '%' . $search . '%');
            });
        }
        if (!empty($_REQUEST['shop_id']) && $_REQUEST['shop_id']!=="all") {
            $qry->where('webhook_logs.shop_id', $_REQUEST['shop_id']);
        }

        $filtered_count = $qry->count();

        $count = WebhookLog::join('webhook_topics', 'webhook_logs.webhook_topic_id', '=', 'webhook_topics.id', 'inner')->count();
        return json_encode(array('data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => $filtered_count));

    }

    public function index()
    {
        return view('admin.stores.index');
    }

    public function favoriteConnectorWithWebhookEvent()
    {
        $webhook_events = WebhookEvent::all();
        $favorites = FavoriteConnectorWithWebhookEvent::all();
        return view('admin.stores.favorite_connector_with_webhook_event', compact('webhook_events', 'favorites'));
    }

    public function createFavoriteConnectorWithWebhookEvent(Request $request)
    {
        $favorite = new FavoriteConnectorWithWebhookEvent();
        $favorite->webhook_event_id = $request->webhook_event_id;
        $favorite->message = $request->message;
        $favorite->save();

        return redirect()->route('admin.stores.favoriteconnectorwithwebhookevent');
    }

    public function updateFavoriteConnectorWithWebhookEvent(Request $request, $id)
    {
        $favorite = FavoriteConnectorWithWebhookEvent::find($id);
        $favorite->webhook_event_id = $request->webhook_event_id;
        $favorite->message = $request->message;
        $favorite->save();

        return redirect()->route('admin.stores.favoriteconnectorwithwebhookevent');
    }

    public function deleteFavoriteConnectorWithWebhookEvent(Request $request, $id)
    {
        FavoriteConnectorWithWebhookEvent::find($id)->delete();

        return redirect()->route('admin.stores.favoriteconnectorwithwebhookevent');
    }

    public
    function stores_listing_ajax()
    {
        $shop = session('shop');
        $qry = Shop::where('id', "!=", 0);
        if (!empty($_REQUEST['sSearch'])) {
            session()->put('shopSearch', $_REQUEST['sSearch']);
            $search = $_REQUEST['sSearch'];
            $qry->where(function ($query) use ($search) {
                $query->orWhere('shops.email', 'LIKE', '%' . $search . '%');
                $query->orWhere('shops.domain', 'LIKE', '%' . $search . '%');
                $query->orWhere('shops.myshopify_domain', 'LIKE', '%' . $search . '%');
            });
        } else {
            session()->forget('shopSearch');
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
                7 => 'created_at', 4 => 'is_deleted', 8 => 'uninstalled_at'];
            if (!array_key_exists($sort_column_number, $sort_column)) {
                $column = 'id';
                $sort_order = 'desc';
            } else {
                $column = $sort_column[$sort_column_number];
            }
            $qry->orderBy($column, $sort_order);
        }
        if ($_REQUEST['plan']) {
            $plan = $_REQUEST['plan'];
            $qry->where("current_plan_type", $plan);
        }
        if ($_REQUEST['store_status']) {
            $store_status = $_REQUEST['store_status'];
            $qry->where("is_deleted", $store_status);
        }
        if ($_REQUEST['installed_at']) {
            $installed_at = $_REQUEST['installed_at'];
            $qry->whereDate("created_at", $installed_at);
        }
        $stores = $qry->get();
        $data = [];
        if (count($stores) > 0) {
            $serial = $_REQUEST['iDisplayStart'];
            foreach ($stores as $row):
                $serial++;
                $obj = new \stdClass;
                $obj->serial_no = $serial;
                $obj->name = $row->name;
                $obj->myshopify_domain = $row->myshopify_domain;
                $obj->domain = $row->domain;
                $obj->email = $row->email;
                $obj->is_deleted = $row->is_deleted;
                $obj->user_plan = $row->current_plan_type;
                $obj->created_at = humanDateFormat($row->created_at);
                $obj->uninstalled_at = humanDateFormat($row->uninstalled_at);
                $obj->id = $row->id;
                $obj->view_route = route("admin.stores.view", ["id" => $row->id]);

                $data[] = $obj;
            endforeach;

        }
        $qry = Shop::where('id', "!=", 0);
        if (!empty($_REQUEST['sSearch'])) {
            $search = $_REQUEST['sSearch'];
            $qry->where(function ($query) use ($search) {
                $query->orWhere('shops.email', 'LIKE', '%' . $search . '%');
                $query->orWhere('shops.domain', 'LIKE', '%' . $search . '%');
                $query->orWhere('shops.myshopify_domain', 'LIKE', '%' . $search . '%');
            });
        }
        $filtered_count = $qry->count();

        $count = Shop::where('id', "!=", 0)->count();
        return json_encode(array('data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => $filtered_count));

    }

    public function store_details($id)
    {
        $store = Shop::where("id", $id)->first();
        if ($store) {
            return view("admin.stores.view", compact("store"));
        }
    }

}
