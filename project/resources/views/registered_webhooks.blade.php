@extends('layouts.master')
<?php
$asset_controls = [
    'datatable', 'sweetalert'
];
?>
@section('head')
    <style>
        @media screen and (max-width: 680px){
            .registered-webhook-table tbody tr td:first-child {
                padding: 6px 0 0 30px !important;
                text-align: left !important;
            }
            #sample_1 th, #sample_1 td{
                text-align: center;
            }
            .table-scroll{
                /*width: 100%;*/
                /*overflow-x: auto;*/
            }
            #sample_1 tr.child td ul li{
                display: block !important;
            }
            .table-scroll .dataTables_paginate{
                display: flex;
                justify-content: center;
            }
        }
    </style>
    <link href="{{ URL::asset('css/datatable.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <section class="section">
       <div class="container">
           <div  class="section-main-heading" style="--top-bar-background:#00848e; --top-bar-color:#f9fafb; --top-bar-background-lighter:#1d9ba4;">
               <h4>Configured Webhooks</h4>
           </div>
           <div class="reg-webhooks-page table-scroll">
               <table class="registered-webhook-table responsive table table-hover table-checkable order-column dataTable no-footer dtr-inline"
                      id="sample_1" >
                   <thead>
                   <tr class="">
                       <th> Channel</th>
                       <th> Topic Name</th>
                       <th> Event Name</th>
                       <th> Status</th>
                       <th> Last modified</th>
                       <th> Created At</th>
                       <th> Description</th>

                   </tr>
                   </thead>
                   <tbody>

                   </tbody>
               </table>
           </div>
       </div>
    </section>

@endsection

@section('last_scripts')

    <script type="text/javascript">

        $(document).ready(function () {

            $(document).on('change', '.update-webhook-status', function () {
                var element=$(this);
                if ($(this).prop('checked')) {
                    var status=1;
                }else{
                    var status=0;
                }

                show_loading_img();


                $.ajax({
                    url: element.attr('data-action-target'),
                    type: 'POST',
                    data: {
                        _method: 'POST',
                        _token: "<?= Session::token() ?>",
                        status:status,
                        id:element.data('id')
                    },
                    cache: false,
                    success: function (result) {
                        if (result && result.status=='success') {
                            callSwalWithHTML(result.status, result.message, 'success');
                        }else{
                            callSwalWithHTML(result.status, result.message, 'error');
                            element.prop('checked', status==1?false:true);
                        }
                        hide_loading_img();
                    }, error: function (response) {
                        swal('Warning', 'Failed to update . Try again !!', 'warning');
                        element.prop('checked', status==1?false:true);
                        hide_loading_img();},
                    timeout: 15000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");
                        element.prop('checked', status==1?false:true);
                    }hide_loading_img();
                });




            })
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
                    sAjaxSource: '{{ route('registered_webhooks_ajax') }}',
                    "columnDefs": [
                        { "width": "120px", "targets": 0 },
                        { "width": "120px", "targets": 1 },
                        { "width": "120px", "targets": 2 },
                        { "width": "60px", "targets": 3 },
                        { "width": "60px", "targets": 4 },
                        { "width": "60px", "targets": 5 },
                        { "width": "60px", "targets": 6 }


                    ],
                    "columns": [
                        {
                            "data": "channel_name",
                            "orderable": true,
                            'render': function (data, type, row) {
                                return '<div class="channel_icon"> <img alt="' + row.channel_name + '"  src="' + row.icon_path + '"  class=""/><a  href="' + row.edit_route + '"  class="">' + row.channel_name + '</a><br></div> <div class="editDell_btn"> <a href="' + row.edit_route + '"  class="snippet-action-btns">Edit</a><div class="vl"></div> <a  data-action-target="' + row.delete_route + '" href="javascript:" class="snippet-action-btns delete-webhook">Delete</a> </div>';
                            }
                        },
                        {
                            "data": "topic_name"
                            , "orderable": true
                        },
                        {
                            "data": "channel_event_name"
                            , "orderable": true
                        },
                        {
                            "data": "status"
                            , "orderable": true,
                            'render': function (data, type, row) {
                                return '<label class="switch"><input data-action-target="' + row.update_status_route + '" type="checkbox" data-id="' + row.id + '" class="update-webhook-status" ' + ( row.status === true ? 'checked' : '') + '><div class="slider round" id="' + row.id + '"><span class="on">ON</span><span class="off">OFF</span></div> </label>'
                            }
                        },
                        {
                            "data": "updated_at"
                            , "orderable": true
                        },

                        {
                            "data": "created_at"
                            , "orderable": true
                        },

                        {
                            "data": "description",
                            "orderable": false,
                            render: function(data, type, row){
                                let description=  row.description;
                                return (description && description.length > 70)?description.substring(0, 70)+'...':description;
                            }
                        }

                    ],

                    order: [[3, "desc"]],
                    language: {
                        paginate: {
                            next: '&#85943;', // or '→'
                            previous: '&#8592;' // or '←'
                        },
                        "emptyTable": "No webhooks have been registered yet. Click <a href='{{ route('automate') }}' >Register webhooks</a> to get started.",
                        "sSearch": '',
                        searchPlaceholder: 'Search',
                        processing: "<small>Loading webhooks...</small>",
                        "sLengthMenu": '<span class="per-page-label cc">per page</span><select class="per_page_length form-control input-sm input-xsmall input-inline">' +
                            '<option value="10">10</option>' +
                            '<option value="30">30</option>' +
                            '<option value="50">50</option>' +
                            '<option value="-1">All</option>' +
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

                    "oSearch": {"sSearch": "{{session('sSearch_hooks')}}"},
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        $.getJSON(sSource, aoData, function (json) {
                            $('#sample_1').show();
                            fnCallback(json)
                        });
                    },
                    "dom": ' <"search-filter"f><"length-dropdown"l>rt<"bottom"ip><"clear">'

                });

            $('#sample_1').on('click', '.delete-webhook', function () {
                var tr = $(this).closest('tr'),
                    data_action_target = $(this).attr('data-action-target');
                var table = $('#sample_1').DataTable();
                if ($('#sample_1').hasClass("collapsed")) {
                    var e = table.row(this).index();
                }
                else {
                    e = null;
                }
                // $(this).html( '<input type="text" placeholder="Search" style="width: 100%" /

                swal({
                    title: "Are you sure to want to delete this webhook?",
                    text: "Webhook will be deleted permanently",
                    icon: "warning",
                    dangerMode: true,
                    closeModal: false,
                    buttons: true
                }).then((value) =>{
                        if(value) {
                            DeleteSingleTemplate(data_action_target, tr, e);}
                    }
                ) ;


            });

            function DeleteSingleTemplate(data_action_target, tr, e) {

                $.ajax({
                    url: data_action_target,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: "<?= Session::token() ?>"
                    },
                    cache: false,
                    success: function (result) {

                        if (result) {
                            swal(result.status, result.message, 'success');
                            RemoveTableRow('sample_1', tr, e)
                        }
                    }, error: function (response) {
                        swal('Warning', 'Failed to delete . Try again !!', 'warning');
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
        });
    </script>
@endsection