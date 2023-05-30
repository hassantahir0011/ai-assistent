<?php

return [
    /*
    |----------------------------------------------------------------------------
    | Constants variables
    |----------------------------------------------------------------------------
    */
    "appPath" =>env( 'APP_URL',"https://49a8edf0.ngrok.io") , // app base path

    "shopify_secret_key" => env( 'SHOPIFY_SECRET',"7781f2e65198f52d2c2d14a22f704ee9"), // Your app credentials (secret key)

    "shopify_api_key"=> env( 'SHOPIFY_APIKEY',"7781f2e65198f52d2c2d14a22f704ee9"),

    "scope"=>"write_products,write_script_tags,write_themes",

    "redirectUri"=> env( 'SHOPIFY_REDIRECT_URL',"/shopify_products_sync/public/shopifycallback"),
    "shopify_products_csv_header"=>"id,Product name,Columns(max-10),Converter(intocm/cmtoin/no),Conversion Columns(e-g 0/1/3),Enter table values separate with / symbol,Image url,Chart Description",
    "shopify_collections_csv_header"=>"id,Collection name,Columns(max-10),Converter(intocm/cmtoin/no),Conversion Columns(e-g 0/1/3),Enter table values separate with / symbol,Image url,Chart Description",

];
