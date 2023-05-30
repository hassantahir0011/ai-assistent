<script type="text/javascript">
    var is_loaded_guide_tab_data=false;
    $(document).ready(function () {
        @if($webhook_event_conditions)
        $("#event-form").submit(function (e) {
            e.preventDefault();
            let conditions_applied = $('#conditional-selection').queryBuilder('getRules', {
                get_flags: true,
                skip_empty: true
            });
            //console.log(conditions_applied);
            if (conditions_applied == null)
                $('.execution_conditions').val("");
            else if (conditions_applied)
                $('.execution_conditions').val(JSON.stringify(conditions_applied));
        });

        $('#conditional-selection').queryBuilder({
            plugins: ['bt-tooltip-errors'],
            default_group_flags: {
                no_add_group: false, max_rules: 2,
                max_groups: 3
            },

            filters: [
                    @foreach($webhook_event_conditions as $filter_key =>$filter_value)
                {
//                        readonly: true,
                    id: "{{ $filter_value['id'] }}",
                    label: "{{ $filter_value['label'] }}",
                    type: "{{ $filter_value['type'] }}",
                    operators: @php echo '["' . implode('", "', $filter_value['operators']) . '"]' @endphp,
                    input: "{{ $filter_value['input'] }}",
                    @if(!empty($filter_value['plugin']))
                    plugin: "{{ $filter_value['plugin'] }}",
                    @if($filter_value['plugin']=='select2')
                    plugin_config: {  // All options supported by the select2 plugin
                        placeholder: "{{ $filter_value['label'] }}",
                        width: "100%",
                        allowClear: true
                    },
                    @elseif($filter_value['plugin']=='datepicker')
                    plugin_config: {
                        format: 'yyyy-mm-dd',
                        todayBtn: 'linked',
                        todayHighlight: true,
                        autoclose: true
                    },
                    @endif

                            @endif
                    values: {
        @foreach($filter_value['values'] as $filter_sub_value_index=> $filter_sub_value)
        @if($filter_sub_value_index !=(sizeof($filter_value['values'])-1))
        {{ $filter_sub_value_index }}:
        '{{ $filter_sub_value }}',
        @else
        {{ $filter_sub_value_index }}:
        '{{ $filter_sub_value }}'
        @endif

        @endforeach
    }
    }
        @if($filter_key !=(sizeof($webhook_event_conditions)-1))
    ,
        @endif
        @endforeach
    ]
        @if(isset($registered_webhook) && $registered_webhook->execution_conditions)
    ,
        rules:{!! $registered_webhook->execution_conditions !!}
                @endif
            }
    )
        ;

        $('#conditional-selection').on('change.queryBuilder', function (e, rule, value) {
            if ($('#conditional-selection').queryBuilder('getRules', {get_flags: true, skip_empty: true}) != null) {
                $('.condition-section-title').addClass('condition-tab-color');
                $('.only-if-conditions').show()
            }
        });
        $('#conditional-selection').on('afterDeleteRule.queryBuilder', function (e, rule, value) {

            if ($('#conditional-selection').queryBuilder('getRules') == null) {
                $('.condition-section-title').removeClass('condition-tab-color');
                $('.only-if-conditions').hide()
            }
        });

        @endif


        $(document).on('click', '#install-webhook-btn', function () {
            $(".Polaris-Tabs button").first().click();
        });
        var load_guide_details = function () {
            show_loading_img();
            $("#guide-overview-section").html('');
            $.ajax({
                url: "{{ route('webhook_event_doc')}}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': "<?= Session::token() ?>"
                },
                dataType: "TEXT",
                data: {
                    webhook_event_id: '{{ Request::segment(2) }}'
                },
                cache: false,
                success: function (response) {
                    is_loaded_guide_tab_data = true;
                    $("#guide-overview-section").html(response);
                    hide_loading_img();
                    $('.lg-actions').html('<span class="lg-prev lg-icon"></span><span class="lg-next lg-icon"></span>');
                }, error: function (result) {
                    hide_loading_img();
                    toastr.error('Unable to load documentation.please try in a moment');

                },
                timeout: 1000000
            }).fail(function (jqXHR, textStatus) {
                hide_loading_img();
                toastr.error('Unable to load documentation.please try in a moment');

            });
        }
        $(document).on('click', '.guide-tab-btn', function () {
            if (is_loaded_guide_tab_data == false) {
                load_guide_details();
            }
        });
        oric_Validation_application("event-form");
        $('.rename-div').css('display', 'none');

        @if($registered_webhook)
        $('.close-test-action-btn').on('click', function () {
            $('.test-action-response').hide();

        });
        $('.test-action-btn').on('click', function () {
            let action_obj = $(this);
            action_obj.attr('disabled', true);
            let webhook_topic_name = '{{ $registered_webhook->webhook_topic->topic_name }}';
            show_loading_img();
            $("#test-action-response").html('');
            $.ajax({
                url: "{{ route('test_registered_webhook')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "<?= Session::token() ?>"
                },
                dataType: "JSON",
                data: {
                    config_id: '{{ $registered_webhook->id }}'
                },
                cache: false,
                success: function (response) {
                    hide_loading_img();
                    action_obj.attr('disabled', false);
                    if (response.status == "error" || response.status == false) {
                        $('.test-action-response').removeClass('alert-success').addClass('alert-danger');
                    } else {
                        $('.test-action-response').removeClass('alert-danger').addClass('alert-success');
                    }
                    $("#test-action-status").text(response.status ? 'Success:' : 'Failed:');
                    $("#test-action-message").html(response.message ? ( response.message + " <span style='color: #000;'><b>(Event Type</b>: " + webhook_topic_name + ")<span>") : 'Something went wrong.');
                    $('.test-action-response').show();
                    $("html, body").animate({scrollTop: 0}, "slow");

                }, error: function (result) {
                    hide_loading_img();
                    toastr.error('Unable to trigger test webhook.');
                    $('.test-action-response').hide();
                    action_obj.attr('disabled', false);

                },
                timeout: 1000000
            }).fail(function (jqXHR, textStatus) {
                hide_loading_img();
                toastr.error('Unable to trigger test webhook.');
                $('.test-action-response').hide();
                action_obj.attr('disabled', false);

            });
        })
        @endif
        // js for partial file paritals.custom_nitification_message_body.blade.php
        // in order to make shopify variables searchable in textarea
        $('.send_custom_notification').click(function () {
            $('.custom-notification-message-inputs').text('');
            $(".custom-notification-message-section").toggle(!$(this).is(':checked'));

        });
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
        if( $("#custom_message_body").length>0 &&  $("#custom_message_title").length>0){
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

        $("#custom_message_body").rules('add', {
            required: {
                depends: function (element) {
                    return !($(".send_system_defined_notifcation").is(":checked"));
                }
            },
            messages: {
                required: "Please write message title."

            }
        });
        $("#custom_message_title").rules('add', {
            required: {
                depends: function (element) {
                    return !($(".send_system_defined_notifcation").is(":checked"));
                }
            },
            messages: {
                required: "Please write message body."

            }
        });
    }

    });
    $(function () {
        $('.Polaris-Tabs button').on('click', function () {
            var $this = $(this);
            if($this.hasClass('guide-tab-btn'))
                $('#snippet-install-action-bar').hide();
            else
                $('#snippet-install-action-bar').show();
            var selectedClass = 'Polaris-Tabs__Tab--selected';
            var $parent = $this.parents('.Polaris-Tabs');
            $parent.find('button').each(function (i, btn) {
                $(btn).removeClass(selectedClass);
                $('#' + $(btn).data('id')).hide();
            });
            $this.addClass(selectedClass);
            $('#' + $this.data('id')).show();
        });
//            $('.Polaris-Tabs button').first().click();
        $('.Polaris-Tabs__Tab--selected').click();

    });
    function open_rename_div() {
        $('.rename-div').slideToggle('slow');
    }

</script>
<script type="text/javascript">
    $(document).ready(function () {
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
                    if(response.retries_left <= 0){
                        action_obj.hide();
                    }
                    action_obj.attr('disabled', false);
                    if (response.status == "error" || response.status == false) {
                        $('.test-action-response').removeClass('alert-success').addClass('alert-danger');
                    } else {
                        $('.test-action-response').removeClass('alert-danger').addClass('alert-success');
                    }
                    $("#test-action-status").text(response.status ? 'Success:' : 'Failed:');
                    $("#test-action-message").html(response.message ? response.message  : 'Something went wrong.');
                    $('.test-action-response').show();
                    $("html, body").animate({scrollTop: 0}, "slow");

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
    });
</script>