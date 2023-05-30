<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="Z-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <style type="text/css">


        .container {
            border: 1px solid;
            /*max-width: 1000px;*/
            margin: 50px auto;
            font-size: 20px;
            padding: 30px 40px;
        }
        .headParentDiv {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
            display: flex;
        }
        .headleftDiv{
            -ms-flex: 0 0 60%;
            flex: 0 0 60%;
            max-width: 60%;
            display: flex;
        }
        .headleftDiv h4 {
            margin: 0;
            font-size: 16px;
            font-family: sans-serif;
            color: #40416f;
            padding: 11px 10px 0px;
        }
        .headleftDiv h4 span{
            display: block;
            font-size: 10px;
            color: #c5c5c5;
            font-family: sans-serif;
        }
        .headrightDiv{
            -ms-flex: 0 0 40%;
            flex: 0 0 40%;
            max-width: 40%;
        }
        .textStyle {
            margin-top: 10px;
            text-align: right;
        }
        .textStyle a {
            text-decoration: none;
            color: #40416f;
            font-size: 14px;
            font-weight: bold;
            font-family: sans-serif
        }
        .textStyle a:hover, .textStyle a:focus {
            /* background: #ccc; */
            /* font-weight: 600; */
            color: #40416f;
            text-decoration: underline;
        }
        .snipify_logo img {
            width: 100%;
        }
        .snipify_logo {
            width: 60px;
            height: 60px;
        }
        /*BodyContent Style***************/
        .bodyContent {
            border-bottom: 1px solid #ccc;
        }
        .bodyText {
            background: #f6f6f6;
            padding: 20px 20px;
            margin: 20px 0;
        }
        .bodyText h2 {
            text-align: left;
            color: #222222;
            font-size: 18px;
            font-weight: bold;
            font-family: sans-serif;
        }
        .bodyText ul {
            list-style: none;
            padding: 0;
        }
        .bodyText ul li{
            color: #7c7d80;
            font-size: 12px;
            font-weight: bold;
            line-height: 20px;
            text-align: justify;
            font-family: sans-serif;
            margin-left: 0px!important;
        }
        .bodyText ul li:nth-of-type(2) {
            padding: 20px 0;
        }
        .activate-btn {
            text-align: center;
        }
        .activate-btn a {
            color: #fff;
            text-decoration: none;
        }
        .activate-btn button {
            background: #40416f;
            padding: 15px 18px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: none;
            color: #fff;
            font-weight: 600;
        }
        /*Footer Style****************/
        .dFlex {
            display: flex;
            justify-content: space-between;
        }
        .myIcons {
            margin: 30px 20px;
            display: flex;

        }
        .myIcons a {
            padding: 0 4px;
            max-width: 40px;
        }
        .myIcons img {
            width: 100%;
            padding: 0 4px;
        }
        .leftDiv h3 {
            font-weight: bold;
            color: #40416f;
            font-size: 16px;
            font-family: sans-serif;
            text-decoration: underline;
        }
        .leftDiv ul {
            padding: 0;
            list-style: none;
        }
        .leftDiv ul li {
            color: #7c7d80;
            font-size: 14px;
            font-weight: bold;
            line-height: 20px;
            /*text-decoration: underline;*/
        }
        /*Media Quires***********/
        @media (max-width: 767px) {
            .container {
                max-width: 560px;
                padding: 20px 20px;
            }
        }
        @media (max-width: 580px) {
            .textStyle a {
                font-size: 12px;
                font-family: sans-serif;
            }
            .bodyText ul li {
                font-size: 12px;
            }
            .leftDiv ul li {
                font-size: 16px;
                line-height: 18px;
            }
            .dFlex {
                justify-content: center;
            }
            .leftDiv h3 {
                text-align: center;
            }
            .leftDiv ul {
                text-align: center;
            }

        }
    </style>
</head>
<body>

<div class="MainWrapper">
    <div class="container">
        <div class="headParentDiv">
            <div class="headleftDiv">
                <div class="snipify_logo">
                    <img alt="" src="https://connector.shopifypioneer.com/drip-app/cdn/icon.png">
                </div>
                <h4>{{ config('app.name') }}<span>Boohead, Inc.</span></h4>

            </div>
            {{--<div class="headrightDiv">--}}
                {{--<div class="textStyle"><a href="https://snipify.co/submission">View on store</a></div>--}}
            {{--</div>--}}

        </div>

        <!-- ContentArea -->
        <div class="bodyContent">
            <div class="bodyText">
                <h2>Hello {{ $shop->name }}!</h2>
                <ul>
                    <li>Thank you for installing and choosing {{ config('app.name') }}.</li>

                    <li>Have questions? Get in touch with us via Facebook or Twitter, or email our support
                        team.</li>

                    <li>Cheers</li>

                </ul>
                {{--<div class="activate-btn">--}}
                    {{--<button type="button"><a href="#" target="_blank">See app</a></button>--}}
                {{--</div>--}}
            </div>
        </div>

        <!-- Footer Content Area -->
        <div class="MainFooter">
            <div class="dFlex">
                <div class="leftDiv">
                    <h3>Best wishes</h3>
                    <ul>
                        <li>{{ env('MAIL_FROM_NAME','') }}</li>
                        {{--<li>{{ env('APP_NAME','Connectify') }}</li>--}}
                        <li>{{ env('MAIL_FROM_ADDRESS','support@connectify.co') }}</li>

                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>




