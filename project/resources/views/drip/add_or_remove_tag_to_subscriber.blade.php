<div class="connector-setup-page-section">
    <h4 class="connector-heading">Setup App</h4>
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
             Email Address to add or remove tag.
        </div>
    </div>

    <div class="fields-wrapper">
        <div class="Polaris-Labelled__LabelWrapper">
            <div class="Polaris-Label right-required-text-label">
                <label id="PolarisTextField2Label"
                       for="PolarisTextField2"
                       class="Polaris-Label__Text">Tag
                    <span>(required)</span>
                </label>
            </div>
        </div>
        <div class="Polaris-Connected">
            <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                <div class="input-field-selection-textarea rich_textarea"
                     contenteditable="true">{{ old('api_fields[tag]')?old('api_fields[tag]'):$api_fields['tag']??'' }}</div>
                <textarea class="hidden_rich_textarea" data-rule-required="true"
                          name="api_fields[tag]"
                          style="display: none;">{{ old('api_fields[tag]')?old('api_fields[tag]'):$api_fields['tag']??'' }}</textarea>
            </div>
        </div>
        <div class="Polaris-Labelled__HelpText">

        </div>
    </div>


</div>