<html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('cdn/icon-16x16.jpg') }}" type="image/jpg" sizes="16x16">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://sdks.shopifycdn.com/polaris/3.5.0/polaris.min.css" rel="stylesheet" type="text/css"/>
    {{--<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="{{ URL::asset('css/appdesign/css/login.css', null, true) }}" rel="stylesheet" type="text/css" />
    <style>

        /*******************************************************/

        body {
            background: #F1F2F3;
        }

        .parent-div-login-page {
            /*height: 100%;*/
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
        }

        .wrapper-div-login-page {
            display: flex;
            justify-content: center;
            height: 100%;
            align-items: center;
            /*margin: 30px 0;*/
        }

        .header_content {
            padding: 10px 0 10px 20px;
            margin: 10px 0;
            text-align: center;
        }

        .header_content h2 > span {
            padding-right: 5px;
        }
        .header_content p:nth-of-type(1){
            padding: 18px 0;
        }

        .login-form-style form {
            margin: 0;
        }

        .header_content a{
            color: #66bf97;
        }
        .main-content-div-login-page {
            /* border: 1px solid #efecec; */
            border-radius: 10px;
            box-shadow: 0 10px -5px 0 rgba(0, 0, 0, 0.3);
            background: #fff;
            margin: 0 !important;
            padding: 0 !important;
        }

        .login-form-wraper {
            padding: 1.5em;
        }
        .switch_screen_header::before {
            display: block;
            background: #f3f3f3 !important;
            position: absolute;
            content: "";
            top: 54%;
            bottom: 0px;
            left: 15px;
            width: 100%;
            max-width: 750px !important;
            height: 2px;
            display: none;
        }
        .app-logo {
            margin: 0 auto;
            width: 200px;
            height: 35px;

        }

        .app-logo img {
            width: 100%;
        }


        .login-form-style {
            /*padding: 10px 0 0px;*/
            margin-top: 50px;
        }

        .login-form-style .form-title {
            font-size: 22px;
            line-height: 30px;
            padding-bottom: 30px;
            text-align: center;
        }

        .login-form-style .form-title h4 {
            font-weight: 700;
            text-transform: uppercase;
        }

        .login-form-style .form-body {
            /*margin-bottom: 20px;*/
        }

        .login-form-style .form-body p {
            font-size: 12px;
            color: #333;
        }

        .input-style-login-page {
            margin: 0 0 15px !important;
        }

        .login-form-style .input-style-login-page input {
            border: 1px solid rgba(0,0,0,0.1);
            height: 50px;
            box-shadow: none;
            float: left;
            border-radius: 6px 0 0 6px;
            padding: 0 20px;

        }

        .inner-input-login-page {
            width: 75%;
        }

        .login-form-style .input-style-login-page input:focus, .login-form-style .input-style-login-page input:hover {

            background-color: #fff;
        }

        .wrapper-div-login-page .login-btn input {
            padding: 10px 15px;
            font-size: 15px;
            border: none;
            width: 25%;
            font-weight: 500;
            letter-spacing: 0;
            background: #66bf97;
            /* background: no-repeat; */
            color: #fff;
            border-left: 1px solid #ccc;
            border-radius: 0 6px 6px 0;
        }

        .wrapper-div-login-page .login-btn input:hover {
            background: #66bf97;
        }

        .wrapper-div-login-page .form-footer {
            background: rgba(0, 128, 96, 0.07);
            padding: 20px 40px;
            border-radius-right-bottom: 10px;
            width: 100%;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        @media screen and (max-width: 480px) {
            .login-form-wraper {
                padding: 1em;
            }

            .header_content h2 {
                font-size: 12px;
            }

            .wrapper-div-login-page .form-footer {
                padding: 20px 15px;
                font-size: 12px;
            }

            .input-style-login-page {
                display: flex;
            }

            .inner-input-login-page {
                width: 100%;
            }

            .login-form-style .input-style-login-page input {
                height: 40px;
                padding: 6px 10px;
            }

            .wrapper-div-login-page .login-btn input {
                padding: 6px 10px;
                width: auto;
            }

        }

    </style>
</head>
<body>
<div class="loginWrapper">
    <div class="container parent-div-login-page">
        <div class="row">
            <div class="wrapper-div-login-page">

                <div class="col-md-6 col-12">
                    <div class="main-content-div-login-page">
                        <div class="login-form-wraper">
                            <div class="switch_screen_header">
                                <div class="app-logo">
                                    <img src="{{ asset('cdn/icon.png') }}">
                                </div>
                                {{--div for swtich store account--}}
                            </div>
                            <div class="login-form-style">
                                <div class="form-title">
                                    <h4 class="">Login to your Shopify Store for Shopify-{{ ucwords(str_replace('_', '-', config('channel.name')))  }} Integration </h4>
                                </div>
                                <div class="form-body">
                                    <form class="form-horizontal" role="form" action="{{ route('install') }}"
                                          method="get">
                                        <p>Enter your Shopify URL to continue. (like this: myshop.myshopify.com)</p>

                                        <div class="form-group input-style-login-page">
                                            <div class="inner-input-login-page">
                                                <input type="text" name="shop" id="shop" class="form-control"
                                                       required="" placeholder="myshop.myshopify.com">
                                            </div>
                                            <div class="login-btn">
                                                <input type="submit" value="Login or Install"
                                                       class="btn btn-success btn-sm">

                                            </div>
                                        </div>

                                    </form>
                                    @if(session('shop'))
                                        <div class="header_content">
                                            <h2>
                                                <span><b>Switch accounts</b></span>
                                            </h2>
                                            <p>Current Shop: <b>{{ session('shop')->myshopify_domain??"" }}</b></p>
                                            <p><a href="{{ route('dashboard') }}">Back to dashboard</a></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</div>


</body>
</html>
