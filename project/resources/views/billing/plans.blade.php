@extends('layouts.master')
<?php $asset_controls = ['sweetalert'];?>
    @section('content')
    <link href="{{ asset('/css/pricing-page.css') }}" rel="stylesheet" type="text/css"/>

            <section class="section plan-section">
                <div class="container">
                    <header class="page-header">
<!--                        <div class="section-main-heading">
                            <h4 class="">Plan Subscriptions</h4></div>-->
                        <h1>Choose a Plan That’s Right for Your Business. </h1>
                        <p>All payments are made through shopify app billings! </p>
                    </header>

                    <div class="bv-page__segment">
                        <div class="bv-page__segment-content">
                            <?php
                            $classes = ['basic' => '', 'professional' => '', 'elite' => ''];
                            $current_plan = $shop->current_plan_type;
                            $classes[$current_plan] = 'current';

                            if ($shop->current_plan_type == 'basic') {
                                $classes['professional'] .= ' featured';
                            } else {
                                $classes['elite'] .= ' featured';
                            }
                            ?>

                            <div>
                                <form id="update_pricing_plan" method="post" action="{{ route('update_pricing_plan') }}">
                                    {{ csrf_field() }}
                                    <div class="plans row">
                                        <div class="col-md-4 col-sm-6 col-12 mt-mobile">
                                            <div class="plan basic <?= $classes['basic'] ?>">
                                                <div class="box">
                                                    <header>
                                                        <h4 class="plan-title">Basic</h4>
                                                        <div class="plan-cost">
                                                            <span class="sup">$</span>
                                                            <span class="plan-price">0</span>
                                                            <span class="plan-type">/month</span>
                                                            <div class="muted">USD Billed Monthly </div>
                                                        </div>
                                                    </header>
                                                    <div class="text">
                                                        <p>Everything you need to start a automation.</p>
                                                    </div>
                                                    <div class="plan-select"><a href="#" class="btn basic-submit-btn">Activate</a><span class="current"><i class="ion-checkmark-circled"> </i> &nbsp; Current Plan</span></div>
                                                </div>
                                                <ul class="plan-features">
                                                    <li><i class="ion-checkmark"> </i>2 Active Webhooks</li>
                                                    <li><i class="ion-checkmark"> </i>200 tasks per month</li>
                                                    <li><i class="ion-checkmark"> </i>7 Days Log Retention</li>
                                                </ul>
                                                <input id="basic-submit-btn" style="display: none;" type="submit" name="plan_type" value="basic"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12 mt-mobile">
                                            <div class="plan professional <?= $classes['professional'] ?>">
                                                <div class="ribbon ribbon-top-right"><span>Featured</span></div>
                                                <div class="box">
                                                    <header>
                                                        <h4 class="plan-title">Professional</h4>
                                                        <div class="plan-cost">
                                                            <span class="sup">$</span>
                                                            <span class="plan-price">{{ env('Premium_Plan_PRICE', 5) }}</span>
                                                            <span class="plan-type">/month</span>
                                                            <div class="muted">USD Billed Monthly </div>
                                                        </div>
                                                    </header>
                                                    <div class="text">
                                                        <p>Suitable for Shopify Basic Store users.</p>
                                                    </div>
                                                    <div class="plan-select"><a href="#" class="btn professional-submit-btn">Activate</a><span class="current"><i class="ion-checkmark"> </i>Current Plan</span></div>
                                                </div>
                                                <ul class="plan-features">
                                                    <li><i class="ion-checkmark"> </i>10 Active Webhooks</li>
                                                    <li><i class="ion-checkmark"> </i>10000 tasks per month</li>
                                                    <li><i class="ion-checkmark"> </i>7 Days Log Retention</li>
                                                </ul>
                                                <input id="professional-submit-btn" style="display: none;" type="submit" name="plan_type" value="professional"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-12 mt-mobile">
                                            <div class="plan elite <?= $classes['elite'] ?>">
                                                <div class="ribbon ribbon-top-right"><span>Featured</span></div>
                                                    <div class="box">
                                                        <header>
                                                            <h4 class="plan-title">Elite</h4>
                                                            <div class="plan-cost">
                                                                <span class="sup">$</span>
                                                                <span class="plan-price">{{ env('Elite_Plan_PRICE', 9) }}</span>
                                                                <span class="plan-type">/month</span>
                                                                <div class="muted">USD Billed Monthly </div>
                                                            </div>
                                                        </header>
                                                        <div class="text">
                                                            <p>Suitable for Shopify Advanced and Plus Store users.</p>
                                                        </div>
                                                        <div class="plan-select"><a href="#" class="btn elite-submit-btn">Activate</a><span class="btn current"><i class="ion-checkmark"> </i>Current Plan</span></div>
                                                    </div>
                                                </div>
                                                <ul class="plan-features">
                                                    <li><i class="ion-checkmark"> </i>Unlimited Active Webhooks</li>
                                                    <li><i class="ion-checkmark"> </i>20000 tasks per month</li>
                                                    <li><i class="ion-checkmark"> </i>30 Days Log Retention</li>
                                                </ul>
                                                <input id="elite-submit-btn" style="display: none;" type="submit" name="plan_type" value="elite"/>
                                            </div>
                                        </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

@endsection
@section('last_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.basic-submit-btn', function () {
                swal({
                    title: "Are you sure to want to downgrade to Basic Plan?",
                    text: "You might need to disable or delete exceeding registered webhooks to perform this operation.Please visit Guides & FAQs for more information.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeModal: true,
                    buttons: true
                }).then((value) => {
                    if (value) {
                        $('#basic-submit-btn').click();

                    }
                });
            });
            $(document).on('click', '.professional-submit-btn', function () {

                swal({
                    title: "Are you sure to want choose this plan?",
                    text: "If you're dowgrading from Elite Plan,then you might need to disable or delete exceeding registered webhooks to perform this operation.Please visit Guides & FAQs for more information.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    closeModal: true,
                    buttons: true
                }).then((value) => {
                    if (value) {
                        $('#professional-submit-btn').click();
                        show_loading_img();
                    }
                });
            });
            $(document).on('click', '.elite-submit-btn', function () {
                $('#elite-submit-btn').click();
                show_loading_img();
            });
        });
    </script>

@endsection
