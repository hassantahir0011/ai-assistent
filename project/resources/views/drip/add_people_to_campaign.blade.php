<div class="connector-setup-page-section">
    <h4 class="connector-heading">Subscribe someone to an Email Series Campaign</h4>
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
            <select id="drip-account-id" data-object="accounts" name="object_id" class="form-control channel_object_listing" data-rule-required="true">
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
                <label for="PolarisTextField2"
                       class="Polaris-Label__Text">Campaign
                    <span>(required)</span>
                </label>
            </div>
        </div>
        <div class="form-group">
            <input class="selected_channel_object_name"
                   name="api_fields[campaign_id_HiddenTextValue]" type="hidden"
                   value="{{ old('api_fields[campaign_id_HiddenTextValue]')?old('api_field[campaign_id_HiddenTextValue]'):$api_fields['campaign_id_HiddenTextValue']??'' }}">
            <select  data-object="campaigns" data-rule-required="true"
                     name="api_fields[campaign_id]" class="form-control channel_object_listing">

                <option value="{{ old('api_fields[campaign_id]')?old('api_fields[campaign_id]'):$api_fields['campaign_id']??'' }}">{{ old('api_fields[campaign_id_HiddenTextValue]')?old('api_fields[campaign_id_HiddenTextValue]'):$api_fields['campaign_id_HiddenTextValue']??'' }}</option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>Optional. The Email Series Campaign to add the subscriber.</span>
            <p><b>Note:</b>Choose Account first to lists its campaigns</p>
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
            The subscriber's email address
        </div>
    </div>
    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Double Optin
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            @php $double_optin=old('api_fields[double_optin]')?old('api_fields[double_optin]'):$api_fields['double_optin']??'';  @endphp
            <select name="api_fields[double_optin]" class="form-control">

                <option
                        @if($double_optin=="true") selected @endif
                value="true">True
                </option>
                <option
                        @if($double_optin=="false") selected @endif
                value="false">False
                </option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span> If true, the double opt-in confirmation email is sent; if false, the confirmation email is skipped. Defaults to the value set on the Email Series Campaign.</span>
        </div>
    </div>

    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Starting Email Index

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[starting_email_index]')?old('api_fields[starting_email_index]'):$api_fields['starting_email_index']??0 }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[starting_email_index]"
                          style="display: none;">{{ old('api_fields[starting_email_index]')?old('api_fields[starting_email_index]'):$api_fields['starting_email_index']??0 }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">
            The index (zero-based) of the email to send first. Defaults to 0.
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
                       class="Polaris-Label__Text">Reactivate If Removed?
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            @php $reactivate_if_removed=old('api_fields[reactivate_if_removed]')?old('api_fields[reactivate_if_removed]'):$api_fields['reactivate_if_removed']??'';  @endphp
            <select name="api_fields[reactivate_if_removed]" class="form-control">

                <option
                        @if($reactivate_if_removed=="true") selected @endif
                value="true">True
                </option>
                <option
                        @if($reactivate_if_removed=="false") selected @endif
                value="false">False
                </option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>If true, re-subscribe the subscriber to the Email Series Campaign if there is a removed subscriber in Drip with the same email address; otherwise, respond with 422 Unprocessable Entity. Defaults to true.</span>
        </div>
    </div>

    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Prospect
                    <span></span>
                </label>
            </div>
        </div>
        <div class="form-group">
            @php $prospect=old('api_fields[prospect]')?old('api_fields[prospect]'):$api_fields['prospect']??'';  @endphp
            <select name="api_fields[prospect]" class="form-control">

                <option
                        @if($prospect=="true") selected @endif
                value="true">True
                </option>
                <option
                        @if($prospect=="false") selected @endif
                value="false">False
                </option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>A Boolean specifiying whether we should attach a lead score to the subscriber (when lead scoring is enabled). Defaults to true. Note: This flag used to be called potential_lead, which we will continue to accept for backwards compatibility.</span>
        </div>
    </div>

    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Base Lead Score

                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[base_lead_score]')?old('api_fields[base_lead_score]'):$api_fields['base_lead_score']??'' }}</div>
                <textarea class="hidden_rich_textarea"
                          name="api_fields[base_lead_score]"
                          style="display: none;">{{ old('api_fields[base_lead_score]')?old('api_fields[base_lead_score]'):$api_fields['base_lead_score']??'' }}</textarea>
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
                                <div class="input-field-selection-textarea rich_textarea"
                                     contenteditable="true">{{ $api_fields['custom_field_keys'][$custom_field_index]??'' }}</div>
                                <textarea class="hidden_rich_textarea "
                                          name="api_fields[custom_field_keys][]"
                                          style="display: none;">{{ $api_fields['custom_field_keys'][$custom_field_index]??'' }}</textarea>
                            </div>
                            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_2">
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
                            <div class="input-field-selection-textarea rich_textarea"
                                 contenteditable="true"></div>
                            <textarea class="hidden_rich_textarea" name="api_fields[custom_field_keys][]" style="display: none;"></textarea>

                        </div>
                        <div class="Polaris-Connected__Item Polaris-Connected__Item--primary prop_input_div_2">
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