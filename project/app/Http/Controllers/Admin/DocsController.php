<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Admin\Doc;
use App\Entities\Admin\DocMedia;
use App\Entities\DocsSetting;
use App\Entities\WebhookEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class DocsController extends Controller
{
    public function create()
    {
        $webhook_events = WebhookEvent::where('is_active', 1)->get();
        return view('admin.docs.create', compact('webhook_events'));
    }

    public function index()
    {
        $docs = Doc::get();
        return view('admin.docs.index', compact('docs'));
    }

    public function edit($id)
    {
        $doc = Doc::where('id', $id)->with('media')
            ->first();
        $webhook_events = WebhookEvent::where('is_active', 1)->get();
        return view('admin.docs.edit', compact('doc', 'webhook_events'));
    }

    public
    function delete($id)
    {

        if (!$id || empty($id)) {
            return response()->json(array('status' => 'error', 'message' => 'Unable to delete doc'));
        }
        DocMedia::where('doc_id', $id)->delete();
        Doc::where('id', $id)->delete();
        return response()->json(array('status' => 'success', 'message' => 'deleted successfully'));

    }


    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $doc = Doc::find($id);
        $doc->user_id = $user->id;
        $doc->note = $request->note;
        $doc->description = $request->description;
        $doc->thumbnail_url = $request->thumbnail_url;
        $doc->video_url = $request->video_url;
        $doc->tags = $request->tags;
        $doc->note = $request->note;
        $doc->webhook_event_id = $request->webhook_event_id;
        $doc->title = $request->title;
        if ($request->is_active == 'active') {
            Doc::where('webhook_event_id', $request->webhook_event_id)
                ->where('id', '!=', $id)
                ->update(['status' => 0]);

            $doc->status = 1;
        } else {
            $doc->status = 0;
        }
        $doc->save();
        //delete previous fields
        $doc->media()->delete();

        $media_urls = [];
        foreach ($request->media_url as $media_url):
            if ($media_url) {
                $obj = new DocMedia();
                $obj->media_url = $media_url;
                $media_urls[] = $obj;
            }
        endforeach;
        if (sizeof($media_urls))
            $doc->media()->saveMany($media_urls);


        Session::flash('Doc Updated Successfully');
        return redirect()->route('admin.docs.index');
    }

    public function store(Request $request)
    {

        $user = auth()->user();

        $doc = new Doc();
        $doc->user_id = $user->id;
        $doc->note = $request->note;
        $doc->description = $request->description;
        $doc->thumbnail_url = $request->thumbnail_url;
        $doc->video_url = $request->video_url;
        $doc->tags = $request->tags;
        $doc->note = $request->note;
        $doc->webhook_event_id = $request->webhook_event_id;
        $doc->title = $request->title;
        if ($request->is_active == 'active') {
            $doc->status = 1;
            Doc::where('webhook_event_id', $request->webhook_event_id)
                ->update(['status' => 0]);
        } else {
            $doc->status = 0;
        }
        $doc->save();


        $media_urls = [];
        foreach ($request->media_url as $media_url):
            if ($media_url) {
                $obj = new DocMedia();
                $obj->media_url = $media_url;
                $media_urls[] = $obj;
            }

        endforeach;
        if (sizeof($media_urls))
            $doc->media()->saveMany($media_urls);


        Session::flash('Doc Added Successfully');
        return redirect()->route('admin.docs.index');
    }


    public
    function webhook_event_doc(Request $request)
    {
        $settings = DocsSetting::first();
        if ($settings && $settings->use_production_docs == true && !empty($settings->production_url)) {
            $url = $settings->production_url."/webhook_event_doc";
            $params = ['webhook_event_id' => $request->webhook_event_id];
            $url = $url . '?' . http_build_query($params);
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_CUSTOMREQUEST => "GET",

            ));
            $response = curl_exec($ch);
            curl_close($ch);
            if ($response && !empty($response)) {
                return $response;
            }
        } else {
            $webhook_event = WebhookEvent::where('slug', $request->webhook_event_id)->where('is_active', 1)->first();
            $doc = Doc::where('status', 1)
                ->where('webhook_event_id', $webhook_event->id ?? $request->webhook_event_id)
                ->with('media')->first();
            return view('event_documentation', compact('doc'));
        }

    }


    public function save_settings(Request $request)
    {

        $settings = DocsSetting::firstOrNew(['id'=>1]);
        $settings->use_production_docs = $request->use_production_docs;
        $settings->production_url = $request->production_url;
        $settings->save();

        Session::flash('Settings saved successfully');
        return redirect()->route("admin.docs.settings");
    }


    public function settings()
    {
        $settings = DocsSetting::find(1);
        return view('admin.docs.settings', compact('settings'));
    }

}
