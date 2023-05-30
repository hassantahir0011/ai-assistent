<?php

namespace App\Http\Controllers;

use App\Entities\Shop;
use App\Services\ShopifyService;
use Illuminate\Http\Request;
use Oseintow\Shopify\Facades\Shopify;


class ProductController extends Controller
{
    private $shopify_service;
    private $api_version;

    public function __construct(ShopifyService $shopify_service)
    {
        $this->shopify_service = $shopify_service;
        $this->api_version = config('shopify.api_version');
    }

    public function product_list()
    {

        $shop = Session('shop');
        $shop = Shop::where('shop_id', $shop->shop_id)
            ->first();
        $shopUrl = $shop->domain;
        $accessToken = Session('shopify_token');
        $products = [];
        $last_id = 0;
        do{
            $products_json = Shopify::setShopUrl($shopUrl)->setAccessToken($accessToken)->get("admin/api/$this->api_version/products.json",["since_id" => $last_id]);
            $response_products = json_decode(json_encode($products_json),true);

            if (!count($response_products))continue;
            $index = count($response_products)-1;
            $last_id = $response_products[$index]['id'];
            $products = array_merge($products,$response_products);
        }while(count($response_products) > 0);
        dd($products);
    }

}
