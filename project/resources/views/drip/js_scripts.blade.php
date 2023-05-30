<script type="text/javascript">
    var shopify_sample_data = [
            @foreach($shopify_event_request_fields as $shopify_event_request_field_key=>$shopify_event_request_field_value)
        {
            label: '<span class="ui-button ui-state-default ui-widget ui-corner-all ui-button-text-only ui-textarea-dropdown"> <span class="dropdown-shopify-img-span"><div class="shopify-img dropdown-img-size"></div></span> <span class="field-key">{{ $shopify_event_request_field_value }}</span> <span class="field-value"></span> </span>',
            value: {
                value: '{{ $shopify_event_request_field_key }}',
                content: '<span contenteditable="false" data-value="{{ $shopify_event_request_field_key }}" class="ui-button ui-state-default ui-widget ui-corner-all ui-button-text-only field-text-parent"> <span class="shopify-img-span"><div class="shopify-img shopify-img-size"></div></span> <span class="field-key">{{ $shopify_event_request_field_value }}</span> <span class="field-value"></span> </span>'
            }
        },
        @endforeach
    ];
    $(document).ready(function () {
        var drip_query_param = {
            channel_account_id: "{{ $_GET['channel_account_id']??0 }}",
            page:1,
            search:"",
            channel_object:"",
            drip_account_id:0

        }
        function get_drip_objects() {
            $('.channel_object_listing').select2({
                placeholder: "Select "+($(this).data("object") || "drip object"),
                ajax: {
                    url: "{{ route('get_drip_resources') }}",
                    minimumInputLength: 1,
                    cache: true,
                    data: function (params) {
                        drip_query_param.channel_object=$(this).data("object");
                        drip_query_param.drip_account_id=$("#drip-account-id option:selected").val() || 0;
                        drip_query_param.page =  params.page || 1;
                        drip_query_param.search =  params.search || "";
                        return drip_query_param;
                    },
                    processResults: function (data, params) {
                        drip_query_param.page = data.page || 0;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination? (data.pagination.more || false):false
                            }

                        };
                    }
                }
            }).on('select2:close', function (e) {
                drip_query_param.page = 1;
                drip_query_param.drip_account_id = 0;
                drip_query_param.search = "";
            });
        }
        $(document).on('change','.channel_object_listing',function(){
            $(this).prev('input.selected_channel_object_name').val($('option:selected',this).text());
        });
        $(document).on('change', '#channel_event_id', function () {
            load_drip_fields_section();
        });
        function load_drip_fields_section(drip_event_setting_id) {
            if (!$('#channel_event_id').val())
                return;
            show_loading_img();
            $.ajax({
                url: "{{ route('load_drip_fields_section')}}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': "<?= Session::token() ?>"
                },
                dataType: "TEXT",
                data: {
                    channel_account_id: "{{ $_GET['channel_account_id']??0 }}",
                    webhook_event_name: $('#webhook_topic_id').data("webhook-event-name"),
                    drip_event_setting_id: drip_event_setting_id,
                    topic_name: $("#webhook_topic_id option:selected").text(),
                    channel_event_id: $('#channel_event_id').val()
                },
                cache: false,
                success: function (response) {
                    $('#channel-fields-section').html(response);
                    $('.rich_textarea').rich_textarea(
                        {
                            shopify_sample_data: shopify_sample_data,
                            triggers: [
                                {
                                    trigger: '@',
                                    callback: function (term, response) {
                                        response($.ui.autocomplete.filter(shopify_sample_data, term));

                                    }	// end of callback
                                }]
                        });
                    hide_loading_img();
                    get_drip_objects();
                }, error: function (result) {
                    hide_loading_img();
                    toastr.error('Unable to fetch details.Please refresh page');

                },
                timeout: 1000000
            }).fail(function (jqXHR, textStatus) {
                hide_loading_img();
                toastr.error('Unable to fetch details.Please refresh page');
            });
        }
        @if($channel_event_settings && $channel_event_settings->id)
        load_drip_fields_section({{ $channel_event_settings->id }})
        @endif
        $(document).on('change','.multiple-resource-Ids',function(){
            $(this).prev('input.multiple-resource-Names').val(JSON.stringify( make_multiple_input_value_array($(this).attr('id'))));
        });

        //appendable rows script
        $(document).on('click',".prop_add_btn",function(){
            // last <div> with element class id
            var lastid = $(".appending-row:last").attr("id");
            var split_id = lastid.split("_");
            var nextindex = Number(split_id[1]) + 1;

            // Adding new div container after last occurance of element class
            $(".appending-row:last").after("<div class='appending-row properties_inputs_fields appendable-parent-div-margin' id='appendablediv_"+ nextindex +"'></div>");

            $("#appendablediv_" + nextindex).append("<div class='Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_1'><div class='input-field-selection-textarea rich_textarea' contenteditable='true'></div><textarea class='hidden_rich_textarea' name='api_fields[custom_field_keys][]' style='display: none;'></textarea></div>");
            $("#appendablediv_" + nextindex).append("<div class='Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_2'><div class='input-field-selection-textarea  rich_textarea' contenteditable='true'></div><textarea class='hidden_rich_textarea' name='api_fields[custom_field_values][]' style='display: none;'></textarea></div>&nbsp;<span id='remove_" + nextindex + "' class='prop_remove_btn'><i class='fa fa-trash'></i></span>");
            if($('.rich_textarea').length){
                $('.rich_textarea').rich_textarea(
                    {
                        shopify_sample_data: shopify_sample_data,
                        placeholder:' ',
                        triggers: [
                            {
                                trigger: '@',
                                callback: function (term, response) {
                                    response($.ui.autocomplete.filter(shopify_sample_data, term));

                                }	// end of callback
                            }]
                    });
            }
        });

        // Remove element
        $(document).on('click',".prop_remove_btn",function(){
            var id = this.id;
            var split_id = id.split("_");
            var deleteindex = split_id[1];

            // Remove <div> with id
            $("#appendablediv_" + deleteindex).remove();

        });

    });
</script>