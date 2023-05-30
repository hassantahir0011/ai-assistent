                            <label class="Polaris-Choice" for="PolarisCheckbox2" style="margin-top: 10px">
                                <span class="Polaris-Choice__Control">
                                    <span class="Polaris-Checkbox">
                                                <input id="PolarisCheckbox2" type="checkbox" name="send_system_defined_notifcation"
                                                       class="send_custom_notification Polaris-Checkbox__Input send_system_defined_notifcation"
                                                       aria-invalid="false" role="checkbox" aria-checked="false"
                                                       {{ $registered_webhook && $registered_webhook->send_system_defined_notifcation==1?"checked":'' }}
                                                       value="1"/><span class="Polaris-Checkbox__Backdrop"></span>
                                                <span class="Polaris-Checkbox__Icon">
                                                    <span class="Polaris-Icon">
                                                        <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg"
                                                             focusable="false" aria-hidden="true">
                                                            <path d="M8.315 13.859l-3.182-3.417a.506.506 0 0 1 0-.684l.643-.683a.437.437 0 0 1 .642 0l2.22 2.393 4.942-5.327a.436.436 0 0 1 .643 0l.643.684a.504.504 0 0 1 0 .683l-5.91 6.35a.437.437 0 0 1-.642 0"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                     <label id="PolarisTextField2Label" for="PolarisTextField3"
                           class="Polaris-Label__Text"> Send System Defined Notification
                             <span class="connectify-tooltip-container">
                                        <i class="fa fa-info-circle"></i>
                                            <span class="connectify-tooltip ">
                                            <h5>Send notification,mail or message defined by system in raw format.e-g</h5>
                                                  <li>
                                                      For new customers.you'll get notification in this format.
                                                  </li>
                                                 <p>Dear Merchant,
                                            <br> A new customer has signed up in your shopify livid-store store.
                                            <br> Customer ID : 3611726839877
                                                 <br>Customer name : aa aa
                                                      <br>   Email :bob@biller.com
                                                 <br> Phone :923007000000
                                                     <br>State : disabled
                                                 </p>
                                            </span>
                                        </span>

    </label>
</label>

<div class="custom-notification-message-section interlink-fields" style="{{ $registered_webhook && $registered_webhook->send_system_defined_notifcation==1?'display:none':'' }}">

    <div class="">
        <h4 class="interlink-field-heading">Write custom message title and body</h4>
        <div class="fields-wrapper input-fields-toggle">
            <div class="Polaris-Labelled__LabelWrapper">
                <div class="Polaris-Label right-required-text-label">
                    <label id="PolarisTextField2Label"
                           for="PolarisTextField2"
                           class="Polaris-Label__Text"> Message Title
                        <span>(required)</span>
                    </label>
                </div>
            </div>
            <div class="Polaris-Connected">
                <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                    <div class="input-field-selection-textarea rich_textarea custom-notification-message-inputs"
                         contenteditable="true">{{ old('message_title') ? old('message_title') : ($registered_webhook?$registered_webhook->message_title:'') }}</div>
                    <textarea class="hidden_rich_textarea" name="message_title" id="custom_message_title"
                              data-rule-zeroWideSpace="true"
                              style="display: none;">{{ old('message_title') ? old('message_title') : ($registered_webhook?$registered_webhook->message_title:'') }}</textarea>
                </div>
            </div>
            <div class="Polaris-Labelled__HelpText">
                <span>Title of the message,email or web notification.Search shopify variables by writing @ or click on textarea to choose from list.e-g @order name.</span>
            </div>
        </div>

        <div class="fields-wrapper input-fields-toggle">
            <div class="Polaris-Labelled__LabelWrapper">
                <div class="Polaris-Label right-required-text-label">
                    <label id="PolarisTextField2Label"
                           for="PolarisTextField2"
                           class="Polaris-Label__Text"> Message Body
                        <span>(required)</span>
                    </label>
                </div>
            </div>
            <div class="Polaris-Connected">
                <div class="Polaris-Connected__Item Polaris-Connected__Item--primary">
                    <div class="input-field-selection-textarea rich_textarea custom-notification-message-inputs msg-body-style"
                         contenteditable="true">{{ old('message_body') ? old('message_body') : ($registered_webhook?$registered_webhook->message_body:'') }}</div>
                    <textarea class="hidden_rich_textarea" name="message_body" id="custom_message_body"
                              data-rule-zeroWideSpace="true"
                              style="display: none;">{{ old('message_body') ? old('message_body') : ($registered_webhook?$registered_webhook->message_body:'') }}</textarea>
                </div>
            </div>
            <div class="Polaris-Labelled__HelpText">
                <span>Message body of the message,email or web notification.Search shopify variables by writing @ or click on textarea to choose from list.e-g @first_name</span>
            </div>
        </div>
    </div>
</div>
