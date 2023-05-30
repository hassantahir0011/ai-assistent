
@extends('admin.layouts.master')
<?php
$asset_controls =
    ['sweetalert', 'datatable'
    ];
?>
@section('breadcrumb')
    <section class="content-header" style="display: flex; align-items: center; justify-content: space-between">
        <h1>
            Notify Customers on Api version Update
        </h1>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Add
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
                                <th class="all"> Title</th>
                                <th class="all"> Description</th>
                                <th> Status </th>
                                <th class="all"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($history as $h)
                                <tr>
                                    <td>{{ $h->id }}</td>
                                    <td>{{ $h->title }}</td>
                                    <td>{{ $h->description }}</td>
                                    <td>{{ $h->status }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary openEditModal" data-history-id="{{ $h->id }}" data-history-title="{{ $h->title }}" data-history-description="{{ $h->description }}" data-history-payload="{{ json_encode($h->payload) }}">Update</button>
                                    </td>
                                </tr>
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="notifcation_form" method="post" action="#">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Notify Customers on Api version Update</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-body">
                        <input type="hidden" class="form-group" name="id" id="id" value="0" />
                        <div class="form-group">
                            <label class="form-label input-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" />
                        </div>
                        <div class="form-group">
                            <label class="form-label input-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <table class="customRow table" >
                            <tr id="changes_0">
                                <td width="50">
                                    <label class="form-label select-label">Select Events</label>
                                    <select class="form-control webhook_event" name="webhook_events[]" id="webhook_events_id_0" data-id="0">
                                        <option value="" selected disabled>Select Event Name</option>
                                        @foreach($webhook_events as $webhook_event)
                                            <option value="{{ $webhook_event->id }}">{{ $webhook_event->event_name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td width="50">
                                    <label class="form-label select-label">Select Topics</label>
                                    <select class="form-control webhook_topic" multiple name="webhook_topics[]" id="webhook_topics_id_0">
                                        <option value="" selected disabled>Select Topics</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn" id="add-more">Add More</button>
                        <button class="btn btn-danger" id="remove-more">Remove</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" class="btn" id="notify">Notify</button>
                    <button type="button" class="btn btn-secondary" id="notify_and_email">Notify and Email</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@stop
@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var add_div_count = 0;
            $("#add-more").click(function (event){
                event.preventDefault();
                add_div_count++;
                $(".form-body table").append('' +
                    '<tr id="changes_'+add_div_count+'">\
                            <td width="50"><label class="form-label select-label">Select Events</label>\
                        <select class="form-control webhook_event" name="webhook_events[]" id="webhook_events_id_'+add_div_count+'"  data-id="'+add_div_count+'">\
                            <option value="" selected disabled>Select Event Name</option>\
                            @foreach($webhook_events as $webhook_event)\
                                <option value="{{ $webhook_event->id }}">{{ $webhook_event->event_name }}</option>\
                            @endforeach\
                        </select></td>\
                        <td  width="50"><label class="form-label select-label">Select Topics</label>\
                        <select class="form-control webhook_topic" multiple name="webhook_topics[]" id="webhook_topics_id_'+add_div_count+'">\
                            <option value="" selected disabled>Select Topics</option>\
                        </select></td>\
                    </tr>');

                $('#webhook_events_id_'+add_div_count).change(function (event) {
                    event.preventDefault();
                    onWebhookEventChange(this);
                });
            });
            $("#remove-more").click(function (event){
                event.preventDefault();
                if(add_div_count > 0) {
                    $("#changes_" + add_div_count).remove();
                    add_div_count--;
                }
                else{
                    swal('Failed to remove', 'At least one event is required', 'warning');
                }
            });

            $(".webhook_event").change(function (event) {
                event.preventDefault();
                onWebhookEventChange(this);
            });

            $(".openEditModal").click(function (event) {
                event.preventDefault();
                $('#id').val($(this).data('history-id'));
                $('#title').val($(this).data('history-title'));
                $('#description').val($(this).data('history-description'));
                let payload = $(this).data('history-payload');
                for(let i = 0; i < payload.length; i++){
                    let event = payload[i];
                    $('#webhook_events_id_'+i).val(event.webhook_event_id).trigger('change');
                    event.webhook_topics_id.map(topic => {
                        setTimeout(function(){
                            $('#webhook_topics_id_'+i).val(topic).trigger('change');
                        }, 1000);
                    });
                    if(i + 1 != payload.length) $('#add-more').trigger('click');
                }
                $('#exampleModal').modal('show');
            });

            function onWebhookEventChange(ref){
                var id = $(ref).attr('id');
                $.ajax({
                    url: '{{ route('admin.stores.notify.api_version.get.webhook_topics') }}',
                    type: 'GET',
                    data: {
                        _method: 'GET',
                        _token: "<?= Session::token() ?>",
                        id: $("#"+id).val()
                    },
                    cache: false,
                    success: function (result) {
                        if (result) {
                            var options = result.map(r => '<option value="'+r.id+'">'+r.topic_name+'</option>');
                            $("#webhook_topics_id_"+$(ref).data('id'))
                                .find('option')
                                .remove()
                                .end()
                            $("#webhook_topics_id_"+$(ref).data('id')).append('<option value="" selected disabled>Select Topic Name</option>' + options.toString());
                        }
                    }, error: function (response) {
                        swal('Warning', 'Failed to fetch webhook topics . Try again !!', 'warning');
                    },
                    timeout: 15000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");
                        //toastr.warning('Please Wait... Slow connection!');
                        //do something. Try again perhaps?
                    }
                });
            }

            $( "#notify_and_email" ).click(function( event ) {
                event.preventDefault();
                $('#exampleModal').modal('hide');
                var action = "{{ route('admin.stores.notify.api_version.update', 1) }}";

                let body = [];
                for (let i = 0; i <= add_div_count; i++){
                    let obj = {
                        "webhook_event_id": $('#webhook_events_id_'+i).val(),
                        "webhook_topics_id": $('#webhook_topics_id_'+i).val()
                    };
                    body.push(obj);
                }

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: {
                        _method: 'POST',
                        _token: "<?= Session::token() ?>",
                        payload: JSON.stringify(body),
                        id: $('#id').val(),
                        title: $('#title').val(),
                        description: $('#description').val()
                    },
                    cache: false,
                    success: function (result) {

                        if (result) {
                            swal(result.status, result.message, result.status);
                            location.reload();
                        }
                    }, error: function (response) {
                        swal('Warning', 'Failed to create . Try again !!', 'warning');
                    },
                    timeout: 15000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");
                        //toastr.warning('Please Wait... Slow connection!');
                        //do something. Try again perhaps?
                    }
                });
            });
            $( "#notify" ).click(function( event ) {
                event.preventDefault();
                $('#exampleModal').modal('hide');
                var action = "{{ route('admin.stores.notify.api_version.update', 0) }}";

                let body = [];
                for (let i = 0; i <= add_div_count; i++){
                    let obj = {
                        "webhook_event_id": $('#webhook_events_id_'+i).val(),
                        "webhook_topics_id": $('#webhook_topics_id_'+i).val()
                    };
                    body.push(obj);
                }

                $.ajax({
                    url: action,
                    type: 'POST',
                    data: {
                        _method: 'POST',
                        _token: "<?= Session::token() ?>",
                        payload: JSON.stringify(body),
                        id: $('#id').val(),
                        title: $('#title').val(),
                        description: $('#description').val()
                    },
                    cache: false,
                    success: function (result) {

                        if (result) {
                            swal(result.status, result.message, result.status);
                            location.reload();
                        }
                    }, error: function (response) {
                        swal('Warning', 'Failed to create . Try again !!', 'warning');
                    },
                    timeout: 15000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");
                        //toastr.warning('Please Wait... Slow connection!');
                        //do something. Try again perhaps?
                    }
                });
            });
        });
    </script>
@stop
