@if($upgrade_plan_notice=session('upgrade_plan_message'))
    <div id="alert-wrap-div" class="Polaris-Page "
        @if(session('upgrade_plan_message_hide'))
            style="display:none"
        @endif
    >
        <div class="Polaris-Page__Content" >
            <div class="plan-upgrade-alert">
                <div class="Polaris-Banner Polaris-Banner--statusInfo Polaris-Banner--hasDismiss Polaris-Banner--withinPage"
                     tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner29Heading"
                     aria-describedby="Banner29Content">
                    <div onclick="javascript:getElementById('alert-wrap-div').style.display='none';" class="Polaris-Banner__Dismiss">
                        <button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly"
                                aria-label="Dismiss notification">
                            <span class="Polaris-Button__Content"><span
                                        class="Polaris-Button__Icon"><span class="Polaris-Icon">
                                        <svg viewBox="0 0 20 20"
                                             class="Polaris-Icon__Svg"
                                             focusable="false"
                                             aria-hidden="true">
                <path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z"
                      fill-rule="evenodd"></path>
              </svg></span></span></span></button>
                    </div>
                    <div class="Polaris-Banner__Ribbon">
                        <span
                                class="Polaris-Icon Polaris-Icon--colorTealDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg
                                    viewBox="0 0 20 20"
                                    class="Polaris-Icon__Svg" focusable="false" aria-hidden="true">
          <circle cx="10" cy="10" r="9" fill="currentColor">

          </circle>
          <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m1-5v-3a1 1 0 0 0-1-1H9a1 1 0 1 0 0 2v3a1 1 0 0 0 1 1h1a1 1 0 1 0 0-2m-1-5.9a1.1 1.1 0 1 0 0-2.2 1.1 1.1 0 0 0 0 2.2"></path>
        </svg>
                        </span>
                    </div>
                    <div>
                        <div class="Polaris-Banner__Heading" id="Banner29Heading">
                            <p class="Polaris-Heading">
                                    @if($upgrade_button_hide=session('upgrade_button_hide'))
                                    Script Tags
                                        @else Upgrade your plan
                                    @endif
                                    </p>
                        </div>
                        <div class="Polaris-Banner__Content" id="Banner29Content">
                            <p>{!! $upgrade_plan_notice !!}</p>
                            <div  class="Polaris-Banner__Actions"
                                  @if($upgrade_button_hide)
                                  style="display:none"
                                    @endif
                            >
                                <div class="Polaris-ButtonGroup">
                                    <div class="Polaris-ButtonGroup__Item">
                                        <div class="Polaris-Banner__PrimaryAction">
                                            <button type="button"
                                                    onclick="location.href='{{ route('plans_listing') }}';"

                                                    class="Polaris-Button Polaris-Button--outline"><span
                                                        class="Polaris-Button__Content"><span
                                                            class="Polaris-Button__Text">Upgrade Plan</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endif