@extends('admin.layouts.master')
<?php
$asset_controls =
    ['sweetalert', 'ckeditor', 'validation', 'select2'];

?>
<style>
    .breadcrumb {
        margin: 0 !important;
    }

    .my-style {
        background: #fff;
        border-top: 2px solid #30aad9;
        padding: 0 !important;
    }

    .wraper {
        background: #fff;
        padding: 10px;
    }

    .top-head h4 {
        margin: 0;
        padding: 10px 10px;
        border-bottom: 1px solid #ccc;
    }

    .content-div .row {
        margin: 0;
    }

    .lable-style {
        text-align: right;
        line-height: 2.4;
        margin: 0;
        font-weight: bold;
        padding-right: 40px !important;
    }

    .appendable-btns {
        display: flex;
        justify-content: space-between;
    }

    .parent-div {
        display: flex;
    }

    .add_button {
        margin-left: 10px;
    }

    .parent-div-append {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 25px;
    }

    .parent-div-append input {
        width: 100%;
        max-width: 766px;
        margin-right: 11px;

    }

    .parent-div-append a {
        margin: 0 14px 0 0px;
    }

    .tag-input-style .bootstrap-tagsinput {
        display: block;
    }

    .sub-btn {
        text-align: center;
    }

    /*Tags css */


</style>
@section('breadcrumb')
    <section class="content-header">
        <h1>
            Docs
        </h1>
        <ul class="breadcrumb">

            <li> Docs <i class="fa fa-minus" aria-hidden="true"></i></li>
            <li class="active">Create</li>
        </ul>
    </section>
@stop
@section('content')
    {{--write code here--}}
    <div class="container-fluid my-style">

        {!! Form::open(['route'=> ['admin.docs.update',$doc->id],'method'=>'post','id'=>'form-doc-create']) !!}
        <div class="wraper">

            <div class="content-div">

                    <div class="form-group row">
                        <label for="title-id"
                               class="col-sm-2 col-form-label col-form-label-sm lable-style">Title</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control form-control-sm input-style"
                                   id="title-id" placeholder="Title" value="{{ $doc->title }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="video_link_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Enter Video
                            ID</label>
                        <div class="col-sm-10">
                            <input value="{{ $doc->video_url }}" type="text" name="video_url"
                                   class="form-control form-control-sm input-style"
                                   id="video_link_id" placeholder="video Link here..">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="thumbnal_link_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Thumbnail
                            Link</label>
                        <div class="col-sm-10">
                            <input value="{{ $doc->thumbnail_url }}" type="url" name="thumbnail_url"
                                   class="form-control form-control-sm input-style"
                                   id="thumbnal_link_id" placeholder="Thumbnal Link here..">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="node_editor_id"
                               class="col-sm-2 col-form-label col-form-label-sm lable-style">Note</label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-control-sm ckeditor" name="note" id="node_editor_id"
                                      rows="3">{{ $doc->note }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tags_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Tags</label>
                        <div class="col-sm-10 tag-input-style">
                            <input value="{{ $doc->tags }}" type="text" name="tags" id="tags_id" data-role="tagsinput"
                                   placeholder="tags here..">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="des_editor_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Description</label>
                        <div class="col-sm-10">
                            <textarea rows="10" class="form-control form-control-sm" name="description"
                                      id="des_editor_id"
                                      placeholder="Description here..">{{ $doc->description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status_id"
                               class="col-sm-2 col-form-label col-form-label-sm lable-style">Status</label>
                        <div class="col-sm-10">
                            <select id="status_id" name="is_active" class="form-control form-control-sm">
                                <option>Choose Status...</option>
                                <option
                                        {{ $doc->status==1?"selected":'' }}

                                        value="active">Active
                                </option>
                                <option {{ $doc->status==0?"selected":'' }} value="draft">Draft</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="webhook_event_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Webhook
                            Events</label>
                        <div class="col-sm-10">
                            @php
                                    $media=$doc->media;
                            @endphp
                            <select id="webhook_event_id" name="webhook_event_id" class="form-control form-control-sm">
                                @foreach($webhook_events as $webhook_event )
                                    <option value="{{ $webhook_event->id }}" data-doc="{{ $doc->webhook_event_id }}"
                                            {{  $doc->webhook_event_id === $webhook_event->id ?'selected':'' }}
                                            >{{ $webhook_event->event_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="main-div-sm">
                        @if($media->isNotEmpty())

                            @foreach($media as $key=>  $media_obj)
                           <div class="form-group row">
                            @if($key==0)
                            <label for="image_url_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Image
                                Url</label>
                            @endif

                                  <div class="{{$key==0?'col-sm-10': '' }}">
                                        <div class=" {{$key==0?'parent-div': 'parent-div-append' }}">

                                            <input type="text" name="media_url[]"
                                                   class="form-control form-control-sm input-style" id="image_url_id"
                                                   value="{{ $media_obj->media_url }}"
                                                   placeholder="Image url here..">
                                            @if($key==0)
                                                <a class="btn btn-primary add_button">
                                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                </a>
                                            @else
                                                <a class="btn btn-danger remove_button"> <span
                                                            class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                                                </a>
                                            @endif

                                        </div>
                                    </div>



                               </div>
                            @endforeach
                                @else
                                    <div class="form-group row">
                                        <label for="image_url_id" class="col-sm-2 col-form-label col-form-label-sm lable-style">Image
                                            Url</label>
                                        <div class="col-sm-10">
                                            <div class="parent-div">
                                                <input type="text" name="media_url[]"
                                                       class="form-control form-control-sm input-style" id="image_url_id" value=""
                                                       placeholder="Image url here..">

                                                <a class="btn btn-primary add_button">
                                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                        @endif
                    </div>
                    <div class="sub-btn">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>

            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop
@section('last_scripts')
    <script>
        $(document).ready(function () {
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.main-div-sm'); //Input field wrapper
            var fieldHTML = '<div class="parent-div-append"> <input type="text" name="media_url[]" class="form-control form-control-sm input-style" id="image_url_id" value="" placeholder="Image url here.."><a class="btn btn-danger remove_button"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </a></div>'; //New input field html

            //Once add button is clicked
            $(addButton).click(function () {
                $(wrapper).append(fieldHTML); //Add field html
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function (e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

    </script>
@stop
