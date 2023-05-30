
@extends('admin.layouts.master')
@section('head')
<style>
    .channel_icon img{width: 20px;}
</style>
@endsection
<?php
$asset_controls =
    ['sweetalert', 'datatable','select2'
    ];
?>
@section('breadcrumb')
    <section class="content-header">
        <h1>
         Store Webhook Logs
        </h1>

    </section>
@stop

@section('content')
<form>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label> Channels </label>
                <select id="connector_channel_id"
                        name="channel" class="form-control connector_channel_id custom-select2">
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label> Status </label>
                <select class="form-control select2 webhook_status" id="webhook_status"
                        name="webhook_status">
                    <option value="">Select status</option>
                    <option value="true">Success</option>
                    <option value="false">Failed</option>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label> Triggered At </label>
                <input type="date" dateformat="yyyy-mm-dd" name="trigger_at" class="form-control"
                       id="trigger_at" placeholder="Trigger At">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group" style="padding-top: 24px">
                <button type="button" style="background: #66bf97 !important;" class="btn btn-success"
                        onclick="clearLogFilters();">Clear Filters
                </button>
            </div>
        </div>
    </div>

</form>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-4">
                        <select class="form-control select2-multiple" name="stores" id="shop_id">
                            <option value="all">All Stores</option>
                         </select>
                    </div>
                </div>

                <div class="table-scrollable">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="sample_1" role="grid" aria-describedby="sample_1_info">
                        <thead>
                            <tr role="row">
                            <tr >
                                <th> #</th>
                                <th class="all"> Channel </th>
                                <th class="all"> Topic Name</th>
                                <th class="all"> Status</th>
                                <th class="all"> Message</th>
                                <th> Triggered At</th>
                                <th> Shop Domain</th>
                                <th> Shop Name</th>

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
                    iDisplayLength: 50,
                    "lengthChange": true,
                    "autoWidth": false,
                    responsive: true,
                    sAjaxSource: '{{ route('store_logs_listing_ajax') }}',
                    "columns": [
                        {
                            "data": "id",
                            orderable: false
                        },
                        {
                            "data": "channel_name",
                            "orderable": true,
                            'render': function (data, type, row) {
                                return '<div class="channel_icon"> <img alt="' + row.channel_name + '"  src="' + row.icon_path + '"  class=""/><a  href="javascript:"  class="">' + row.channel_name + '</a> </div>';
                            }
                        },
                        {
                            "data": "topic_name"
                            , "orderable": true
                        },

                        {
                            "data": "status"
                            , "orderable": true,
                            'render': function (data, type, row) {
                                return '<span class="badge' + ( row.status === false ? ' badge-warning' : ' badge-primary') + '"> ' + ( row.status === false ? ' Failed' : ' Success') + ' </span>'
                            }
                        },
                        {
                            "data": "message"
                            , "orderable": false
                        },

                        {
                            "data": "created_at"
                            , "orderable": true
                        },
                        {
                            "data": "myshopify_domain"
                            , "orderable": false
                        },
                        {
                            "data": "shop_name"
                            , "orderable": false
                        }

                    ],
                    order: [[5, "desc"]],
                    language: {
                        paginate: {
                            next: '&#8594;', // or '→'
                            previous: '&#8592;' // or '←'
                        },
                        "emptyTable": "No logs Available.",
                        "sSearch": '<i class="fa fa-search" aria-hidden="true"></i>',
                        searchPlaceholder: 'Search by channel ,description.',
                        processing: "<small>Loading logs...</small>",
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

                    "oSearch": {"sSearch": "{{session('storeLogSearch')}}"},
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        aoData.push({"name": "shop_id", "value": $('#shop_id').val()});
                        $.getJSON(sSource, aoData, function (json) {
                            $('#sample_1').show();
                            fnCallback(json)
                        });
                    }, "fnServerParams": function (aoData) {
                        aoData.push(
                            {"name": "channel", "value": $('#connector_channel_id :selected').val()},
                            {"name": "webhook_status", "value": $('#webhook_status :selected').val()},
                            {"name": "trigger_at", "value": $('#trigger_at').val()}
                        )
                    },
                    "dom": ' <"search-filter"f><"length-dropdown"l>rt<"bottom"ip><"clear">'
                });


            // Filters on change events
            $('#shop_id').on('keyup click change', function (e) {
                table.draw();
            });

            $('#connector_channel_id,#webhook_status,#trigger_at').on('change', function () {
                table.draw();
            });

            $('#shop_id').select2({
                placeholder: "Select shop",
                ajax: {
                    url: "{{ route('stores_select2_format') }}",
                    minimumInputLength: 1,
                    cache: true,
                    data: function (params) {
                        var query = {
                            search: params.term
                        }
                        return query;
                    }
                }
            });

        });


        var channel_query_param = {
            offset: "",
            search: "",
        }
        function get_channels() {
            $('.connector_channel_id').select2({
                placeholder: "Select Channel",
                allowClear: true,
                ajax: {
                    url: "{{ route('get_channels') }}",
                    minimumInputLength: 1,
                    cache: true,
                    data: function (params) {
                        return channel_query_param;
                    },
                    processResults: function (data, params) {
                        channel_query_param.offset = data.offset || "";
                        channel_query_param.search = params.term || "";
                        return {
                            results: data.results,
                            pagination: {
                                more: (data.pagination && data.pagination.more) ? data.pagination.more : false
                            }

                        };
                    }
                }
            }).on('select2:close', function (e) {
                channel_query_param.offset = "";
                channel_query_param.search = "";
            });
        }

        get_channels();

        function clearLogFilters() {
            $('#webhook_status').val('');
            $('#trigger_at').val('');
            $("#connector_channel_id").empty().trigger('change');
            table.search("").draw();
        }
    </script>
@stop
