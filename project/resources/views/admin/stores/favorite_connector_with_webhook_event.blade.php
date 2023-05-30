
@extends('admin.layouts.master')
<?php
$asset_controls =
    ['sweetalert', 'datatable'
    ];
?>
@section('breadcrumb')
    <section class="content-header">
        <h1>
            Favorite Connector with Webhook Topic
        </h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add Favorite
        </button>

    </section>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">
                            <thead>
                            <tr role="row">
                            <tr >
                                <th> #</th>
                                <th class="all"> Connector Name</th>
                                <th class="all"> Webhook Topic</th>
                                <th> Message </th>
                                <th class="all"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($favorites as $favorite)
                                    <form action="{{ route('admin.stores.favoriteconnectorwithwebhookevent.update', [$favorite->id]) }}" method="post">
                                        <tr>
                                            <td>{{ $favorite->id }}</td>
                                            <td>
                                                <select name="webhook_event_id" id="webhook_event_id">
                                                    @foreach($webhook_events as $webhook_event)
                                                        <option value="{{ $webhook_event->id }}" {{ $favorite->webhook_event_id == $webhook_event->id ? "selected" : "" }}>{{ $webhook_event->event_name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <textarea name="message" id="message" cols="30" rows="3" value="{{ $favorite->message }}">{{ $favorite->message }}</textarea></td>
                                            <td>
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ route('admin.stores.favoriteconnectorwithwebhookevent.delete', [$favorite->id]) }}" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form action="{{ route('admin.stores.favoriteconnectorwithwebhookevent.create') }}" method="post">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Favorite Widgets</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <select name="webhook_event_id" id="webhook_event_id">
                            @foreach($webhook_events as $webhook_event)
                                <option value="{{ $webhook_event->id }}">{{ $webhook_event->event_name }}</option>
                            @endforeach
                        </select>
                        <textarea name="message" id="message" cols="30" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@stop
