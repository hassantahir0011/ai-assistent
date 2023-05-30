@extends('layouts.master')
<?php
$asset_controls = [
    'datatable', 'sweetalert', 'select2'
];
?>

@section('head')
    <style>
        #sample_1 tr td:first-child {
            padding-right: 0;
        }

        #sample_1 .Polaris-Choice__Control {
            margin: 0 !important;
        }

        @media only screen and (max-width: 768px) {

            .table-scroll {
                width: 100%;
                overflow-x: auto;
            }

            table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before, table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
                top: 28px;
                left: -1px;
            }
        }

        @media only screen and (max-width: 680px) {

            #sample_1 th:first-child, #sample_1 td:first-child {
                padding-left: 4px;
            }
        }

        @media only screen and (max-width: 580px) {
            /*.channel_icon{margin-left: 15px;}*/
        }

        @media only screen and (max-width: 380px) {
            #sample_1 th, #sample_1 td {
                /*padding-left: 0px !important;*/
            }
        }


    </style>
    <link href="{{ URL::asset('css/datatable.css?v=1') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet" type="text/css"/>


@endsection

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-main-heading">
                <h4>Notifications</h4>

                <ul class="faq-list notification">
                    @foreach($notifications as $notification)
                        <li class="mark-as-read-notification">

                            <div class="question" data-target-action="{{ route('notification.marked_as_read',$notification->id) }}">
                                <i class="un-read {{ $notification->marked_as_read ? 'fal' : 'fas' }} fa-circle text-success"></i>
                                <div>{{ $notification->notification_title }}</div>
                                <small class="text-muted">{{ $notification->updated_at }}</small>
                            </div>

                            <div class="answer">
                                <p>{!! $notification->notification_body !!}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="d-flex justify-content-center pt-5 pb-5">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>

    </section>
@endsection

@section('last_scripts')
    <script type="text/template" id="checkbox-template">
        <label class="Polaris-Choice" for="PolarisCheckbox_@id" style="display:inline-block">
            <span class="Polaris-Choice__Control">
                <span class="Polaris-Checkbox">
                    <input id="PolarisCheckbox_@id" value="@id" type="checkbox" class="Polaris-Checkbox__Input"
                           aria-invalid="false" role="checkbox" aria-checked="false"><span
                            class="Polaris-Checkbox__Backdrop"></span>
                    <span class="Polaris-Checkbox__Icon">
                        <span class="Polaris-Icon">
                            <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
                                <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.437.437 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                            </svg>
                        </span></span></span></span>
        </label></script>
    <script type="text/javascript">
        function clearLogFilters() {
            $('#webhook_status').val('');
            $('#trigger_at').val('');
            $("#connector_channel_id").empty().trigger('change');
            table.search("").draw();
        }

        $(document).on('click', '.retry-failed-job-button', function () {
                let action_obj = $(this);
                action_obj.attr('disabled', true);
                var url = action_obj.data('retry-action');
                show_loading_img();
                $("#test-action-response").html('');
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "<?= Session::token() ?>"
                    },
                    dataType: "JSON",
                    data: [],
                    cache: false,
                    success: function (response) {
                        hide_loading_img();
                        if (response.retries_left <= 0) {
                            action_obj.hide();
                        }

                        action_obj.attr('disabled', false);
                        if (response.status == "error" || response.status == false) {
                            toastr.error(response.message);
                        } else {
                            toastr.success(response.message);
                        }

                    }, error: function (result) {
                        hide_loading_img();
                        toastr.error('Unable to re-trigger webhook.');
                        $('.test-action-response').hide();
                        action_obj.attr('disabled', false);
                    },
                    timeout: 1000000
                }).fail(function (jqXHR, textStatus) {
                    hide_loading_img();
                    toastr.error('Unable to re-trigger webhook.');
                    $('.test-action-response').hide();
                    action_obj.attr('disabled', false);

                });
            });

    </script>

    <script type="text/javascript">
        $(document).on('click', '#delete-logs', function () {
            let log_ids = [];

            if (table.rows('.selected').data().length == 0) {
                toastr.error('Please select the log(s) to delete first.');
            } else {
                let snippet_ids = [];
                $.each(table.rows('.selected').data(), function (key, value) {
                    log_ids.push(value.id);
//
                });

                show_loading_img();
                $.ajax({
                    url: '{{ route('delete_logs') }}',
                    type: 'POST',
                    data: {
                        _method: 'POST',
                        _token: "<?= Session::token() ?>",
                        log_ids: log_ids,

                    },
                    cache: false,
                    success: function (result) {
                        if (result && result.status == 'success') {
                            swal(result.status, result.message, 'success');
                            $('th.selectAll input').prop("checked", false);
                            $("div.top-bar-action-list").toggleClass("hidden");
                            table.draw();
                        } else {

                            swal(result.status, result.message, 'error');

                        }
                        hide_loading_img();
                    }, error: function (response) {
                        swal('Warning', 'Failed to update . Try again !!', 'warning');

                        hide_loading_img();
                    },
                    timeout: 15000
                }).fail(function (jqXHR, textStatus) {
                    if (textStatus === 'timeout') {
                        swal("Sorry", 'Please Wait... Slow connection!', "error");

                    }
                    hide_loading_img();
                });

            }

        });


        $(document).on('click', '.top-bar-action-button', function () {
            $("div.top-bar-action-list").toggleClass("hidden");
        });

        function getExt(filename) {
            return filename.split('.').pop().split("?")[0].split("#")[0];
        }

        var checkboxTemplate = $('#checkbox-template').text();

        function getPolarisCheckbox(id) {
            return checkboxTemplate.replace(/@id/g, id);
        }

        function getFormattedDate() {
            var date = new Date();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var hour = date.getHours();
            var min = date.getMinutes();
            var sec = date.getSeconds();

            month = (month < 10 ? "0" : "") + month;
            day = (day < 10 ? "0" : "") + day;
            hour = (hour < 10 ? "0" : "") + hour;
            min = (min < 10 ? "0" : "") + min;
            sec = (sec < 10 ? "0" : "") + sec;

            return date.getFullYear() + "-" + month + "-" + day + "_" + hour + ":" + min + ":" + sec;
        }

        $('th.selectAll').html(getPolarisCheckbox('selectAll'))
        var table = $('#sample_1').DataTable(
            {
                processing: true,
                serverSide: true,
                "searching": false,
                "paging": true,
                'bSortable': true,
                "bInfo": true,
                iDisplayLength: 10,
                "lengthChange": true,
//                    dom: 'fBlrtip',
                "autoWidth": false,
                responsive: true,
//                    "dom":' <"search-filter"f><"length-dropdown"l>Brt<"bottom"ip><"clear">',
//                    dom: 'lrtip',
                dom: "Bftlrtip",
                "columnDefs": [
                    {"width": "10px", "targets": 0},
                    {"width": "120px", "targets": 1},
                    {"width": "200px", "targets": 2},
                    {"width": "60px", "targets": 3},
                    {"width": "70px", "targets": 4}
                ],
                buttons: [],
                sAjaxSource: '{{ route('notification.get_all') }}',
                "columns": [
                    {
                        "data": "marked_as_read"
                        , "orderable": true,
                        'render': function (data, type, row) {
                            //     // return row.status == false ? '<button class="btn btn-primary" onclick="retry_failed_webhook('+row.id+')">Retry</button>' : ''
                            //     // return row.status == false ? '<button class="btn btn-primary retry-failed-job-button" data-retry-action='+row.retry_action+' >Retry</button>' : ''
                            return row.marked_as_read == false ? '<i class="fas fa-circle" aria-hidden="true"></i>' : ''
                        }
                    },
                    {
                        "data": "title"
                        , "orderable": false
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
                        "data": "action"
                        , "orderable": false,
                        'render': function (data, type, row) {
                        //     // return row.status == false ? '<button class="btn btn-primary" onclick="retry_failed_webhook('+row.id+')">Retry</button>' : ''
                        //     // return row.status == false ? '<button class="btn btn-primary retry-failed-job-button" data-retry-action='+row.retry_action+' >Retry</button>' : ''
                            return (row.marked_as_read == false ? '<button style="background: #66bf97 !important;" class="btn btn-success mark-as-read-notification" data-action-target=' + row.marked_as_read_action + ' ><i class="fal fa-envelope-open" aria-hidden="true"></i></button>' : '') + '<button class="btn btn-danger delete-notification" data-action-target=' + row.delete_action + ' ><i class="fal fa-trash"></i></button>'
                        }
                    }
                ],
                order: [[3, "desc"]],
                language: {
                    paginate: {
                        next: '&#8594;', // or '→'
                        previous: '&#8592;' // or '←'
                    },
                    "emptyTable": "No notification available.",
                    processing: "<small>Loading Logs...</small>",
                    "sLengthMenu": '<span class="per-page-label cc">Per Page</span><select class="per_page_length form-control input-sm input-xsmall input-inline">' +
                        '<option value="10">10</option>' +
                        '<option value="30">30</option>' +
                        '<option value="50">50</option>' +
                        //                        '<option value="-1">All</option>'+
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
                orderClasses: false,
                "oSearch": {"sSearch": "{{session('sSearch')}}"},
                "fnServerData": function (sSource, aoData, fnCallback) {
                    $.getJSON(sSource, aoData, function (json) {
                        $('#sample_1').show();
                        fnCallback(json)
                    });
                }
                //                    "dom":' <"search-filter"f><"length-dropdown"l>rt<"bottom"ip><"clear">'
            });

        table.buttons().container()
            .appendTo('#example_wrapper .col-sm-6:eq(0)');



        $('#sample_1').on('click', '.mark-as-read-notification', function () {
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
                title: "Confirm",
                text: "Are you sure to want to mark this notification as read?",
                icon: "warning",
                dangerMode: true,
                closeModal: false,
                buttons: true
            }).then((value) =>{
                    if(value) {
                        markAsReadSingleTemplate(data_action_target);}
                }
            ) ;


        });

        $(document).on('click', '.question', function (e) {
            e.preventDefault();
            markAsReadSingleTemplate($(this).attr('data-target-action'))

            let i = $(this).children('.un-read');
            i.removeClass('fas');
            i.removeClass('fal');
            i.addClass(' fal ');
        });


        $('#sample_1').on('click', '.delete-notification', function () {
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
                title: "Are you sure to want to delete this notification?",
                text: "Notification will be deleted permanently",
                icon: "warning",
                dangerMode: true,
                closeModal: false,
                buttons: true
            }).then((value) =>{
                    if(value) {
                        deleteSingleTemplate(data_action_target, tr, e);}
                }
            ) ;


        });

        function deleteSingleTemplate(data_action_target, tr, e) {

            $.ajax({
                url: data_action_target,
                type: 'GET',
                data: {
                    _method: 'GET',
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

        function markAsReadSingleTemplate(data_action_target) {
            $.ajax({
                url: data_action_target,
                type: 'GET',
                data: {
                    _method: 'GET',
                    _token: "<?= Session::token() ?>"
                },
                cache: false,
                success: function (result) {

                    if (result) {
                        // swal(result.status, result.message, 'success');
                        // if(result.status == 'success') $(ref).remove();
                    }
                }, error: function (response) {
                    swal('Warning', 'Failed to mark as read . Try again !!', 'warning');
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

        $("th.selectAll .Polaris-Checkbox__Input").on("click", function (e) {
            if ($(this).is(":checked")) {
                table.rows().select();
                $('#sample_1 tbody .Polaris-Checkbox__Input').prop('checked', true)

            } else {
                table.rows().deselect();
                $('#sample_1 tbody .Polaris-Checkbox__Input').prop('checked', false)
            }
        });


        $(".per_page_length").on("change", function (e) {
            $('th.selectAll input').prop("checked", false);
        });
        $('#sample_1 tbody').on('click', 'input', function (e) {
            var checked = $(this).prop('checked');
            var row = table.rows($(this).closest('tr').get()[0]);
            if (checked) {
                row.select()
            } else {
                $("th.selectAll input").prop('checked', false);
                row.deselect()
            }
            e.stopPropagation();
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

        $('#connector_channel_id,#webhook_status,#trigger_at').on('change', function () {
            table.draw();
        });

        get_channels();


    </script>
    <script type="text/javascript">
        $(function () {
            // handle clicking of questions -- toggle display of answer
            $('.faq-list').on('click', '.question', function (e) {
                $(this).parent().toggleClass('expanded')
            })

            // handle of expand and collapse all buttons
            $('.faq-list').on('click', 'button', function (e) {
                $('.faq-list li').toggleClass('expanded', $(this).hasClass('expand'))
            })
        })

    </script>
@endsection