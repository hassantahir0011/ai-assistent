<?php

namespace App\Http\Controllers;

use App\Entities\Notification;
use Illuminate\Http\Request;
use App\Http\Requests\RetryFailedWebhooksRequest;
use Session;

class NotificationsController extends Controller
{
    private $notification_model;

    public function __construct(Notification $notification_model)
    {
        $this->notification_model = $notification_model;
    }

    public function index(Request $request){
        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        $notifications = $this->notification_model->where('shop_id', $shop_id)->orderBy('id', 'desc')->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function marked_as_read(Request $request, $id){
        try {
            $notification = $this->notification_model->where('id', $id)->first();
            if($notification){
                $notification->marked_as_read = true;
                $notification->save();
                return response()->json(array("status" => "success", "message" => "Notification marked as read!"));
            }
            return response()->json(array("status" => "error", "message" => "Notification not found!"));
        }
        catch (\Exception $e){
            return response()->json(array("status" => "error", "message" => $e->getMessage()));
        }
    }

    public function delete(Request $request, $id){
        try {
            $notification = $this->notification_model->where('id', $id)->first();
            if ($notification) $notification->delete();
            return response()->json(array("status" => "success", "message" => "Notification deleted successfully!"));
        }
        catch (\Exception $e){
            return response()->json(array("status" => "error", "message" => $e->getMessage()));
        }
    }

    public function get_notifications(Request $request)
    {
        $shop = session('shop');
        $shop_id = $shop['shop_id'];
        $qry = $this->notification_model->where('shop_id', $shop_id);

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
                0 => 'marked_as_read', 3 => 'created_at'];
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
                $obj->title = $row->notification_title;
                $obj->message = $row->notification_body;
                $obj->marked_as_read = $row->marked_as_read;
                $obj->marked_as_read_action = route('notification.marked_as_read',$row->id);;
                $obj->delete_action =  route('notification.delete',$row->id);
                $obj->created_at = getCreatedAtAttribute($row->created_at, $shop);
                $obj->updated_at = humanDateFormat($row->updated_at);
                $obj->id = $row->id;
                $data[] = $obj;
            endforeach;

        }

        $count = $this->notification_model->where('shop_id', $shop_id)->count();

        $qry = $this->notification_model->where('shop_id', $shop_id);
        $filtered_count = $qry->count();
        return json_encode(array('data' => $data, 'recordsTotal' => $count, 'recordsFiltered' => $filtered_count));

    }
}
