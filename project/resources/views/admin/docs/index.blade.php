
@extends('admin.layouts.master')
<?php
$asset_controls =
    ['sweetalert', 'datatable', 'select2'
    ];
?>
@section('breadcrumb')
    <section class="content-header">
        <h1>
            Design Form Fields
        </h1>
        <ul class="breadcrumb">

            <li> Docs <i class="fa fa-minus" aria-hidden="true"></i></li>
        </ul>
    </section>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject"> Docs</span>
                </div>
                <div class="actions">
                    <a class="btn btn-sm btn-circle" href="{{ route('admin.docs.create') }}" title="Add new doc"><i class="fa fa-plus"></i> Add Doc</a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="doc_table" role="grid" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                            <tr >
                                <th> #</th>
                                <th> Webhook Event</th>
                                <th> Channel</th>
                                <th> Title</th>
                                <th> Status</th>
                                <th> Created At</th>
                                <th> Updated At</th>
                                <th> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (isset($docs)):
                        $i = 1;
                        foreach ($docs as $doc): ?>
                            <tr class="gradeX odd" role="row">
                                <td> {{ $i++ }}</td>

                                <td>{{ $doc->event->event_name }}</td>
                                <td>{{ ucwords(str_replace('_',' ',config('channel.name'))) }}</td>

                                <td>{{ $doc->title }}</td>
                                <td>
                                    <span class="badge badge-{{ $doc->status==true?'success':'dark' }}">{{ $doc->status==true?'active':'draft' }}</span>
                                </td>
                                <td>{{ humanDateFormat($doc->created_at) }}</td>
                                <td>{{ humanDateFormat($doc->updated_at) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-xs gray dropdown-toggle" type="button"
                                                data-toggle="dropdown" aria-expanded="false"> <i class="fa fa-fa fa-ellipsis-h"></i>
                                        </button>
                                        <ul class="dropdown-menu" style="left: -50px;" role="menu">
                                            <li>
                                                <a href="{{ route('admin.docs.edit', [$doc->id]) }}">
                                                <i class="fa fa-pencil"></i> Edit </a>
                                            </li>
                                                <li>
                                                    <a class="delete_item delete_doc" data-action-target="{{ route('admin.docs.delete', [$doc->id]) }}">
                                                        <i class="fa fa-trash"></i> Delete </a>
                                                </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#doc_table').on('click', '.delete_doc', function () {
                var tr = $(this).closest('tr'),
                    data_action_target = $(this).attr('data-action-target');
                var table = $('#doc_table').DataTable();
                if ($('#doc_table').hasClass("collapsed")) {
                    var e = table.cell(this).index().row;
                }
                else {
                    e = null;
                }
                swal({
                    title: "Deleting Doc",
                    text: "Data associated with this doc will also deleted",
                    icon: "warning",
                    dangerMode: true,
                    closeModal: false,
                    buttons: true
                }).then((value) => {
                    if(value) {
                        DeleteDoc(data_action_target, tr, e);
                    }
                });


            });

            function DeleteDoc(data_action_target, tr, e) {

                $.ajax({
                    url: data_action_target,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: "<?= Session::token() ?>"
                    },
                    cache: false,
                    success: function (result) {
                        if (result.status=='success') {
                            swal(result.status, result.message, 'success');

                            RemoveTableRow('doc_table', tr, e)
                        } else {
                            swal(result.status, result.message, 'success');

                        }

                    }, error: function () {

                        swal("Soryy!", "Server error!", "error");
                    },
                    timeout: 3000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");
                    }
                });
            }

            var datatable = $('#doc_table').dataTable();

        });
    </script>
@stop
