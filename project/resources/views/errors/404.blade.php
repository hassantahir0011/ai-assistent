<!doctype html>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta http-equiv="X-UA-Compatible" content="ie=edge"/>
<title>{{ config('app.name') }} - Not Found</title>
<link rel="icon" href="{{ asset('cdn/icon-16x16.jpg') }}" type="image/jpg" sizes="16x16">
<style>
    html {
        box-sizing: border-box;
        overflow: auto !important;
    }

    *, *:before, *:after {
        box-sizing: inherit;
    }

    * {
        max-height: 1000000px;
    }

    body {
        font: 14px/20px Helvetica, sans-serif;
        color: #333;
        text-align: center;
        padding: 150px;
        position: relative;
        overflow: hidden;
        width: 100%;
        min-height: 100vh;
        margin: 0;
        -webkit-transition: all ease 0.3s;
        -moz-transition: all ease 0.3s;
        -ms-transition: all ease 0.3s;
        -o-transition: all ease 0.3s;
        transition: all ease 0.3s;
        background: url("https://appscorridor.com/webhook_setup_stage/css/appdesign/images/bg-img.png") no-repeat;
        background-size: cover;
        background-position: center center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    article {
        max-width: 500px;
        padding: 50px;
        background: #fff;
        border-radius: 25px;
        box-shadow: 0 0 10px -5px rgba(0, 0, 0, 0.3);
    }

    h1 {
        font-size: 40px;
        line-height: 46px;
    }

    a {
        color: #66bf97;
        text-decoration: none;
    }

    a:hover {
        color: #03694e;
        text-decoration: none;
    }

    p {
        margin-bottom: 30px;
    }

    .btn {
        position: relative;
        height: 36px;
        line-height: 32px;
        font-size: 12px;
        border: 1px solid transparent;
        padding: 0 25px;
        text-align: center;
        border-radius: 5px;
        color: #fff;
        text-transform: uppercase;
        background: #66bf97;
        -webkit-transition: all ease 0.3s;
        -moz-transition: all ease 0.3s;
        -ms-transition: all ease 0.3s;
        -o-transition: all ease 0.3s;
        transition: all ease 0.3s;
        font-weight: bold;
        max-width: 200px;
        margin: 0 auto;
        display: block;
    }

    .btn:hover {
        color: #fff;
        background: #03694e;
    }


</style>

<body>
<article>
    <h1>Lost Your Way?</h1>
    <div>
        <p>Sorry, we can't find that page! Don't worry though, everything is STILL AWESOME!</p>
        <a href="{{ route('dashboard') }}" class="btn">Go Home
            <svg width="18" height="10" viewBox="0 0 18 28" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 class="Icon__StyledSVG-sc-lm07h6-0 jkUmZk Chevronstyles__ChevronIcon-sc-1qql32m-0 cEWHhy LinkWithChevron__StyledChevron-sc-1r4vyna-2 gzqkOi">
                <path d="M1.825 28L18 14 1.825 0 0 1.715 14.196 14 0 26.285z" fill="currentColor"></path>
            </svg>
        </a>
    </div>
</article>
</body>