
@extends('admin.layouts.master')
<?php
$asset_controls =
    ['sweetalert', 'datatable'
    ];
?>
@section('breadcrumb')
    <section class="content-header">
        <h1>
           App User Stores
        </h1>

    </section>
@stop

@section('content')

<form>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label> Plans </label>
                <select id="connector_channel_id"
                        name="channel" class="form-control connector_channel_id custom-select2">
                    <option value="">Select Plan</option>
                    <option value="basic">Basic</option>
                    <option value="professional">Professional</option>
                    <option value="elite">Elite</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label> Status </label>
                <select class="form-control select2 webhook_status" id="webhook_status"
                        name="webhook_status">
                    <option value="">Select status</option>
                    <option value="false">Active</option>
                    <option value="true">In-Active</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label> Installed At </label>
                <input type="date" dateformat="yyyy-mm-dd" name="trigger_at" class="form-control"
                       id="trigger_at" placeholder="Trigger At">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group" style="padding-top: 24px">
                <button type="button" style="background: #66bf97 !important;" class="btn btn-success" id="clearLogFilters">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

</form>
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
                                <th class="all"> Name</th>
                                <th class="all"> MyShopify Domain</th>
                                <th> Domain</th>
                                <th class="all"> Status</th>
                                <th class="all"> Owner Email</th>
                                <th> User Plan</th>
                                <th> Installed At</th>
                                <th> Uninstalled At</th>
                                <th class="all"> Actions</th>
                            </tr>
                        </thead>
                        <tbody>

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
            var table = $('#sample_1').DataTable(
                {
                    processing: true,
                    serverSide: true,
                    "searching": true,
                    "paging": true,
                    'bSortable': true,
                    "bInfo": true,
                    iDisplayLength: 10,
                    "lengthChange": true,
                    "autoWidth": false,
                    responsive: true,
                    sAjaxSource: '{{ route('stores_listing_ajax') }}',
                    "columns": [
                        {
                            "data": "serial_no"
                        },
                        {
                            "data": "name"
                        },
                        {
                            "data": "myshopify_domain"
                        },
                        {
                            "data": "domain"
                        },
                        {
                            "data": "status",
                             "orderable": true,
                            render: function(data, type, row){
                                return (!row.is_deleted?'<span class="badge badge-primary">Active</span>':'<span class="badge badge-warning">Inactive</span>')
                            }
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "user_plan"
                        },
                        {
                            "data": "created_at"
                            , "orderable": true
                        },
                        {
                            "data": "uninstalled_at",
                            "orderable": true
                        },
                        {
                            "data": "view_route",
                            "orderable": false,
                            render: function(data, type, row){
                                return '<a target="_blank" style="color:blue;" href="'+row.view_route+'">View Details</a>';
                            }
                        }

                    ],
                    columnDefs: [
                        { responsivePriority: 1, targets: 4 },
                        { responsivePriority: 2, targets: 5 }
                    ],
                    order: [[4, "desc"]],
                    language: {
                        paginate: {
                            next: '&#8594;', // or '→'
                            previous: '&#8592;' // or '←'
                        },
                        "emptyTable": "No stores Available.",
                        "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>',
                        searchPlaceholder: 'Search by store name or domain.',
                        processing: "<small>Loading stores...</small>",
                        "sLengthMenu": '<span class="per-page-label cc">per page</span><select class="per_page_length form-control input-sm input-xsmall input-inline">' +
                        '<option value="10">10</option>' +
                        '<option value="30">30</option>' +
                        '<option value="50">50</option>' +
                        '</select>'
                    },
                    drawCallback: function () {
                        var pageInfo = this.api().page.info();
                        var multiPage = pageInfo.pages > 1;
                        $('#sample_1_paginate').toggle(multiPage);
                        if (!multiPage && pageInfo.recordsTotal == pageInfo.recordsDisplay) {
                            $('#sample_1_info').text('Showing all ' + pageInfo.recordsTotal + ' entries');
                        }
                        if (pageInfo.recordsTotal == 0) {
                            $('#sample_1_info').text('');
                        }
                    },
                    // highlight ordered column

                    "oSearch": {"sSearch": "{{session('shopSearch')}}"},
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        $.getJSON(sSource, aoData, function (json) {
                            $('#sample_1').show();
                            fnCallback(json)
                        });
                    }, "fnServerParams": function (aoData) {
                        aoData.push(
                            {"name": "plan", "value": $('#connector_channel_id :selected').val()},
                            {"name": "store_status", "value": $('#webhook_status :selected').val()},
                            {"name": "installed_at", "value": $('#trigger_at').val()}
                        )
                    },
                    "dom": ' <"search-filter"f><"length-dropdown"l>rt<"bottom"ip><"clear">'
                });


            $('#connector_channel_id,#webhook_status,#trigger_at').on('change', function () {
                table.draw();
            });

            $('#clearLogFilters').on('click', function () {
                $('#webhook_status').val('');
                $('#trigger_at').val('');
                $("#connector_channel_id").val('');
                table.search("").draw();
            });

        });
    </script>
@stop
