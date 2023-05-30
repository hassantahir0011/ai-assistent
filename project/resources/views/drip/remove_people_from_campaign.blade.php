<div class="connector-setup-page-section">
    <h4 class="connector-heading">Remove a subscriber from one or all Email Series Campaigns</h4>
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
                </label>
            </div>
        </div>
        <div class="form-group">
            <input class="selected_channel_object_name"
                   name="api_fields[campaign_id_HiddenTextValue]" type="hidden"
                   value="{{ old('api_fields[campaign_id_HiddenTextValue]')?old('api_field[campaign_id_HiddenTextValue]'):$api_fields['campaign_id_HiddenTextValue']??'' }}">
            <select  data-object="campaigns"
                     name="api_fields[campaign_id]" class="form-control channel_object_listing">

                <option value="{{ old('api_fields[campaign_id]')?old('api_fields[campaign_id]'):$api_fields['campaign_id']??'' }}">{{ old('api_fields[campaign_id_HiddenTextValue]')?old('api_fields[campaign_id_HiddenTextValue]'):$api_fields['campaign_id_HiddenTextValue']??'' }}</option>
            </select>
        </div>
        <div class="Polaris-Labelled__HelpText">
            <span>Optional. The Email Series Campaign from which to remove the subscriber. Defaults to all..</span>
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
             Email Address to remove/unsubscribe.
        </div>
    </div>


</div>