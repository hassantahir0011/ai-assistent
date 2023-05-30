@extends('layouts.master')
@section('content')
    <link href="{{ asset('/assets/image-picker/image-picker.css') }}" rel="stylesheet" type="text/css"/>
    <div class="overlay">
        <div id="loading-img"></div>
    </div>
    <div class="Polaris-Page designPage">

        <div class="Polaris-Page__MainContent ">


                <div class="Polaris-Page__Content">
                    <div class="Polaris-Layout">
                        <div class="Polaris-Layout__Section">
                            <ul class="Polaris-Tabs">
                                <li class="Polaris-Tabs__TabContainer">
                                    <button type="button" class="Polaris-Tabs__Tab {{ session('active_tab')==null || session('active_tab')=='size_chart'?'Polaris-Tabs__Tab--selected':'' }}"
                                            data-id="create-sizeChart-tab"><span
                                                class="Polaris-Tabs__Title">
                                            <span id="country-sizes-demo">Webhooks</span></span></button>
                                </li>

                            </ul>
                        </div>

                        <div class="Polaris-Layout__Section">
                            {{--<form id="StyleDesignForm">--}}
                            <div class="Polaris-Tabs__TabContent Polaris-Card">
                                <div id="create-sizeChart-tab" class="Polaris-Card__Section Polaris-Tabs__TabContainer">

<br>
                                        <form id="sizechartForm" method="post" action="{{ route('add_js_snippets') }}"
                                              enctype="multipart/form-data">
                                            <div style="margin-top: 35px;">

                                            @include('store_webhooks')
                                            </div>
                                    </form>

                                </div>




                            </div>
                            <div class="clear"></div>








                        </div>
                    </div>
                </div>

        </div>


    </div>

    <

@endsection

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
                    iDisplayLength:10,
                    sAjaxSource: '{{ route('store.webhooks') }}',
                    "columns": [
                        {
                            orderable: false,
                            className: 'select-checkbox',
                            targets:   0
                        },


                        {"data": "event_name"},
                        {
                            "data": "topic_name"
                            , "orderable": false
                        },
                        {
                            "data": "store_webhook_status"
                            , "orderable": false,
                            'render': function (data, type, row) {
                                return '<span class="label label-sm' + ( row.store_webhook_status === "disabled" ? ' label-warning' : ' label-primary') + '"> ' + row.store_webhook_status + ' </span>'
                            }
                        },

                        {
                            "data": "webhook_topic_url"
                            , "orderable": false
                        },


                    ],
                    select: {
                        style:    'os',
                        selector: 'td:first-child'
                    },
                    order: [],
                    "fnServerData": function (sSource, aoData, fnCallback) {
                        aoData.push({"name": "branch_id", "value": $('#branch_id').val()});
                        $.getJSON(sSource, aoData, function (json) {
                            fnCallback(json)
                        });
                    }
                });


            // Filters on change events
            $('#branch_id').on('keyup click change', function (e) {
                table.draw();
            });

            $('#button').click( function () {
                alert( table.rows('.selected').data().length +' row(s) selected' );
                console.log(table.rows('.selected').data());
            } );

//            var selectedIds = table.columns().checkboxes.selected();
//            console.log(selectedIds)
//
//            selectedIds.forEach(function(selectedId) {
//                alert(selectedId);
//            });

        });




    </script>

@endsection