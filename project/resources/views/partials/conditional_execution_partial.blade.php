<textarea name="execution_conditions" style="display: none;"
          class="execution_conditions"
>{{ old('execution_conditions')? old('execution_conditions'):$registered_webhook->execution_conditions??'' }}</textarea>

<style type="text/css">
    #conditional-selection .btn-success {
        margin-right: 4px;
    }
    .query-builder .rules-group-container {
        border: 1px dashed #ababab;
        background: rgba(251, 248, 241, 0.5);
    }
    #logic-collapseable{
        display: block !important;
    }
</style>
<div>
    <div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb; --p-frame-offset:0px;">
        <div class="card-style">
            <div class="Polaris-Card__Header">
                <h2 class="Polaris-Heading">Set conditions for your webhooks.</h2>
            </div>
            <div class="Polaris-Card__Section">
                <ul class="Polaris-List">
                    <li class="Polaris-List__Item"> Key points Filters are extra steps that act as traffic cops for your data.</li>
                    <li class="Polaris-List__Item">Workflows only continue if the conditions you pick are met.</li>
                    <li class="Polaris-List__Item">webhooks stop immediately when the requirements of a Filter are not met.</li>
                </ul>
                <p class="p-style">&nbsp;
                    NOTE: Any rules below will not apply to your <strong>Delete Webhook events</strong> because shopify don't post additional data on orders/delete,products/delete etc.
                </p>
            </div>
        </div>
    </div>


</div>
<div id="logic-collapseable" class="panel-collapse collapse in">
    <div class="panel-body">
        <div id="conditional-selection"></div>
    </div>
</div>