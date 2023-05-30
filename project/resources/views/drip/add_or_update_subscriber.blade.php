<div class="connector-setup-page-section">
    <h4 class="connector-heading">Setup fields </h4>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label for="PolarisTextField2"
                       class="Polaris-Label__Text">Account
                    <span>(required)</span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <input data-rule-required="true"
                   name="object_text" class="selected_channel_object_name" type="hidden"
                   value="{{ old('object_text')?old('object_text'):$channel_event_settings->object_text??'' }}">
            <select data-object="accounts" name="object_id" class="form-control channel_object_listing" data-rule-required="true">
                <option value="{{ old('object_id')?old('object_id'):$channel_event_settings->object_id??'' }}">{{ old('object_text')?old('object_text'):$channel_event_settings->object_text??'' }}</option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>The account to associate this subscriber.</span>
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Initial status
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            @php $status=old('api_fields[status]')?old('api_fields[status]'):$api_fields['status']??'';  @endphp
            <select name="api_fields[status]" class="form-control">

                <option
                        @if($status=="active") selected @endif
                value="active">Active
                </option>
                <option
                        @if($status=="unsubscribed") selected @endif
                value="unsubscribed">Un subscribed
                </option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>subscriber's status.Either active or unsubscribed.</span>
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Email
                    <span>(required)</span>
                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[email]')?old('api_fields[email]'):$api_fields['email']??'' }}</div>
                <textarea class="hidden_rich_textarea" data-rule-required="true"
                          name="api_fields[email]"
                          style="display: none;">{{ old('api_fields[email]')?old('api_fields[email]'):$api_fields['email']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            Subscriber Email Address.
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">First Name

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[first_name]')?old('api_fields[first_name]'):$api_fields['first_name']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[first_name]"
                          style="display: none;">{{ old('api_fields[first_name]')?old('api_fields[first_name]'):$api_fields['first_name']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Last Name

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[last_name]')?old('api_fields[last_name]'):$api_fields['last_name']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[last_name]"
                          style="display: none;">{{ old('api_fields[last_name]')?old('api_fields[last_name]'):$api_fields['last_name']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Tags

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[tags]')?old('api_fields[tags]'):$api_fields['tags']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[tags]"
                          style="display: none;">{{ old('api_fields[tags]')?old('api_fields[tags]'):$api_fields['tags']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            Array of tags ,use this format
            ["tag1","tag2"]

        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Time Zone

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[time_zone]')?old('api_fields[time_zone]'):$api_fields['time_zone']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[time_zone]"
                          style="display: none;">{{ old('api_fields[time_zone]')?old('api_fields[time_zone]'):$api_fields['time_zone']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            The subscriber's time zone (in Olson format). Defaults to Etc/UTC
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Phone

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[phone]')?old('api_fields[phone]'):$api_fields['phone']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[phone]"
                          style="display: none;">{{ old('api_fields[phone]')?old('api_fields[phone]'):$api_fields['phone']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            The subscriber's primary phone number.
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Address 1

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[address1]')?old('api_fields[address1]'):$api_fields['address1']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[address1]"
                          style="display: none;">{{ old('api_fields[address1]')?old('api_fields[address1]'):$api_fields['address1']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Country

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[country]')?old('api_fields[country]'):$api_fields['country']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[country]"
                          style="display: none;">{{ old('api_fields[country]')?old('api_fields[country]'):$api_fields['country']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Zip

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[zip]')?old('api_fields[zip]'):$api_fields['zip']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[zip]"
                          style="display: none;">{{ old('api_fields[zip]')?old('api_fields[zip]'):$api_fields['zip']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">State

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[state]')?old('api_fields[state]'):$api_fields['state']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[state]"
                          style="display: none;">{{ old('api_fields[state]')?old('api_fields[state]'):$api_fields['state']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">New Email

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[new_email]')?old('api_fields[new_email]'):$api_fields['new_email']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[new_email]"
                          style="display: none;">{{ old('api_fields[new_email]')?old('api_fields[new_email]'):$api_fields['new_email']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            Optional. A new email address for the subscriber. If provided and a subscriber with the email above does not exist, this address will be used to create a new subscriber.
        </div>
    </div>

    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text"> Custom Fields
                    <span></span>
                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="container" style="padding: 0">
                @if(isset($api_fields['custom_field_keys']) && !empty($api_fields['custom_field_keys']))
                    @foreach($api_fields['custom_field_keys'] as $custom_field_index => $custom_field_key)
                        <div class='appending-row properties_inputs_fields appendable-parent-div-margin' id="appendablediv_{{ $custom_field_index }}">
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_1">
                                @if($custom_field_index==0)
                                <span>Field Key</span>
                                @endif
                                <div class="input-field-selection-textarea rich_textarea"
                                     contenteditable="true">{{ $api_fields['custom_field_keys'][$custom_field_index]??'' }}</div>
                                <textarea class="hidden_rich_textarea "
                                          name="api_fields[custom_field_keys][]"
                                          style="display: none;">{{ $api_fields['custom_field_keys'][$custom_field_index]??'' }}</textarea>
                            </div>
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_2">
                                @if($custom_field_index==0)
                                <span>Field Value</span>
                                @endif
                                <div class="input-field-selection-textarea rich_textarea"
                                     contenteditable="true">{{ $api_fields['custom_field_values'][$custom_field_index]??'' }}</div>
                                <textarea class="hidden_rich_textarea "
                                          name="api_fields[custom_field_values][]"
                                          style="display: none;">{{ $api_fields['custom_field_values'][$custom_field_index]??'' }}</textarea>
                            </div>
                            @if($custom_field_index==0)
                                <span class='prop_add_btn'><i class="fa fa-plus"></i> </span>
                            @else
                                <span id="remove_2" class="prop_remove_btn"><i class="fa fa-trash"></i></span>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class='appending-row properties_inputs_fields' id='appendablediv_1'>
                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_1">
                           <span>Field Key</span>
                            <div class="input-field-selection-textarea rich_textarea"
                                 contenteditable="true"></div>
                            <textarea class="hidden_rich_textarea" name="api_fields[custom_field_keys][]" style="display: none;"></textarea>

                        </div>
                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_2">
                            <span>Field Value</span>
                            <div class="input-field-selection-textarea rich_textarea"
                                 contenteditable="true"></div>
                            <textarea class="hidden_rich_textarea" name="api_fields[custom_field_values][]" style="display: none;"></textarea>
                        </div>
                        <span class='prop_add_btn'><i class="fa fa-plus"></i> </span>
                    </div>
                @endif
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>Custom contact field like companyname, customernumber, city etc.Enter field name on left text box of each row while its value on right textbox.

            </span>
            <p><b>Note:</b> Rows with empty key or value will be ignored.</p>
        </div>
    </div>

</div>