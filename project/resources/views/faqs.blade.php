@extends('layouts.master')
@section('content')
    <link href="{{ asset('/css/faq.css') }}" rel="stylesheet" type="text/css"/>
    <section class="section">
        <div class="container">
            <div class="section-main-heading">
                <h4>Guides & FAQs</h4>

                <ul class="faq-list">
                    <div>
                        <button class="expand">expand all</button>
                        <button class="collapse-all">collapse all</button>
                    </div>
                    <li>
                        <div class="question">
                            <span>What is {{ config('app.name') }} and how does it work?</span>
                        </div>
                        <div class="answer">

                            <p><strong>{{ config('app.name') }}</strong> is an automation tool that auto triggers all shopify store
                                events
                                and send to Drip with simplicity and ease. You can connect your shopify
                                stores with Drip without coding or relying on developers to build the
                                integration.</p>
                            <p>Simply register any event from Webhook Setup page by clicking Connect Button next to
                                it.Follow the guides within configuration page and fill required information and
                                save.E-g
                                Set up automated email campaigns for abandoned carts, welcome series, post-purchase follow-ups, and more.</p>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What are logs?</span>
                        </div>
                        <div class="answer">
                            <p>
                                Log is a file that contains information about events that have occurred within a shopify
                                store and {{ config('app.name') }}. They can include errors and warnings as well as informational
                                events.E-g
                            </p>
                            <ul class="privacy-bullet-points">
                                <li>A new subscriber was added to your Drip list from your Shopify store.
                                </li>
                                <li>The {{ config('app.name') }} successfully synced customer data between Shopify and Drip.
                                </li>
                            </ul>

                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What to do if all webhook logs showing failed status?</span>
                        </div>
                        <div class="answer">
                            <p>If error is related to Drip, copy and paste
                                the
                                error message on google search engine with channel name or make sure you’ve followed the
                                guide carefully.If problem persists, reach to us we would love to help integrating
                                events
                                with you.
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What is conditions tab in event registration screen?</span>
                        </div>
                        <div class="answer">
                            <p>You can apply filters and set conditions on events for particular channels.For
                                example,</p>
                            <ul class="privacy-bullet-points">
                                <li>When a new customer creates an account add as a subscriber in Drip.</li>
                                <li>Add customers who make a purchase to add in Campaign of Drip.</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>How and when to contact support?</span>
                        </div>
                        <div class="answer">
                            <p>Follow the guides carefully with the event registration for a particular channel.Watch
                                video
                                if available, Make sure you've added required headers, inputs or other details as
                                suggested
                                in guides.If you still face any problem in webhook bindings then reach to us via live
                                support widget or email us at support@connectify.co</p>

                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What to do if I want to uninstall or reinstall the app?</span>
                        </div>
                        <div class="answer">
                            <p>
                                Simply remove the app from apps listing page in the shopify admin panel.All your store
                                webhooks will be removed automatically.If you again install the app,you would need to
                                enable
                                all your registered events again from the ‘Registered Webhooks’ screen by toggling the
                                status button.

                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What to downgrade the plan?</span>
                        </div>
                        <div class="answer">

                            <p>App pricing plans are based on number of active webhook events.If you want to downgrade
                                the
                                plan but have more active number of webhooks, then you have to first disable or delete
                                that
                                exceeding webhook events to
                                its limit from the <strong><a href="{{ route('registered_webhooks') }}">Registered
                                        Webhooks</a></strong> screen.See plan's pricing page for more details.</p>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>Data privacy at {{ config('app.name') }}</span>
                        </div>
                        <div class="answer">

                            <p>We take the security of your credentials and data very seriously.</p>
                            <ul class="privacy-bullet-points">
                                <li>Credentials that you use to connect your accounts to {{ config('app.name') }} are protected with
                                    high-level encryption.
                                </li>
                                <li>
                                    All encrypted values are encrypted using OpenSSL and the AES-256-CBC cipher.
                                    Furthermore, all encrypted values are signed with a message authentication code
                                    (MAC). The integrated message authentication code will prevent the decryption of any
                                    values that have been tampered with by malicious users.
                                </li>
                                <li>
                                    Account access credentials
                                    saved by {{ config('app.name') }} are encrypted with AES-256-CBC cipher and stored in a database.
                                    Of course, {{ config('app.name') }} has the decryption keys on hand so we can use the credentials
                                    but they are stored and maintained separately.
                                </li>
                                <li>
                                    We don’t store your customers,orders or any other shopify store data except your
                                    shop's basic information. Instead we trigger it directly to other platforms you
                                    registered for.
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What is [ ] sign in shopify variables and how arrays are handled in {{ config('app.name') }}?</span>
                        </div>
                        <div class="answer">
                            <p>We take the security of your credentials and data very seriously.</p>
                            <ul class="privacy-bullet-points">
                                <li>Credentials that you use to connect your accounts to {{ config('app.name') }} are protected with
                                    high-level encryption.
                                </li>
                                <li>
                                    All encrypted values are encrypted using OpenSSL and the AES-256-CBC cipher.
                                    Furthermore, all encrypted values are signed with a message authentication code
                                    (MAC). The integrated message authentication code will prevent the decryption of any
                                    values that have been tampered with by malicious users.
                                </li>
                                <li>
                                    Account access credentials
                                    saved by {{ config('app.name') }} are encrypted with AES-256-CBC cipher and stored in a database.
                                    Of course, {{ config('app.name') }} has the decryption keys on hand so we can use the credentials
                                    but they are stored and maintained separately.
                                </li>
                                <li>
                                    We don’t store your customers,orders or any other shopify store data except your
                                    shop's basic information. Instead we trigger it directly to other platforms you
                                    registered for.
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>What is [ ] sign in shopify variables and how arrays are handled in {{ config('app.name') }}?</span>
                        </div>
                        <div class="answer">

                            <p><strong>[ ]</strong> Symbol shows that this shopify variable contains array of elements
                                in it meaning there can be more than one value of this variable,e-g each order can have
                                multiple line items or each product can have multiple variants in it.So if you choose
                                Line Item <strong>Quantity</strong> or Variant <strong>Price</strong> variables in your
                                input fields,it means this variable will contain quantities or prices of all line items
                                or variants in an order or product respectively.</p>
                            <p>All array values are concatenated by comma between them.lets say you choose shopify
                                product variant prices and product contain 3 variants in it, then their prices will be
                                posted in this format 21.01,22.02,23.03</p>
{{--                            <p>Some connectors like quickbooks support multiple line items in some of their--}}
{{--                                modules/events.Similarly few shopify webhooks also contain multiple line items e-g--}}
{{--                                Order,Cart,Refund ,Checkout.In such connectors if you map shopify line item variables--}}
{{--                                with connector fields,then same number of line items will be inserted into the connector--}}
{{--                                event as available in shopify webhook data. </p>--}}
                        </div>
                    </li>
                    <li>
                        <div class="question">
                            <span>Retry failed jobs</span>
                        </div>
                        <div class="answer">
                            <p>Jobs mostly fail due to misconfiguration in registered events ,wrong mapping of connector
                                and Shopify fields,missing required fields or due to connector account limitations.</p>
                            <p>Failed jobs that appear in logs can be retried upto 3 times. If event fails multiple
                                times , try updating the field values according to exception or contact administration
                                for support.</p>
                            <p><strong>Note:</strong><br/> Each retry deducts 1 count from your plan's allowed tasks per
                                month.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <script>

    </script>

@endsection
@section('last_scripts')
    <script type="text/javascript">
        $(function () {
            // handle clicking of questions -- toggle display of answer
            $('.faq-list').on('click', '.question', function (e) {
                $(this).parent().toggleClass('expanded')
            })

            // handle of expand and collapse all buttons
            $('.faq-list').on('click', 'button', function (e) {
                $('.faq-list li').toggleClass('expanded', $(this).hasClass('expand'))
            })
        })

    </script>

@endsection