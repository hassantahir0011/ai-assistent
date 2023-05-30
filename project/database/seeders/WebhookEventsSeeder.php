<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Entities\WebhookEvent;

class WebhookEventsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $data = [
            ['slug' => 'cart', 'event_name'=>'Cart','is_active'=>0],
            ['slug' => 'checkout', 'event_name'=>'Checkout','is_active'=>0],
            ['slug' => 'collection', 'event_name'=>'Collection','is_active'=>0],
            ['slug' => 'collection-publication', 'event_name'=>'CollectionPublication','is_active'=>0],
            ['slug' => 'customer', 'event_name'=>'Customer','is_active'=>1],
            ['slug' => 'customer-saved-search', 'event_name'=>'CustomerSavedSearch','is_active'=>0],
            ['slug' => 'draft-order', 'event_name'=>'DraftOrder','is_active'=>0],
            ['slug' => 'fulfillment', 'event_name'=>'Fulfillment','is_active'=>0],
            ['slug' => 'fulfillment-event', 'event_name'=>'FulfillmentEvent','is_active'=>0],
            ['slug' => 'inventory-item', 'event_name'=>'InventoryItem','is_active'=>0],
            ['slug' => 'inventory-level', 'event_name'=>'InventoryLevel','is_active'=>0],
            ['slug' => 'location', 'event_name'=>'Location','is_active'=>0],
            ['slug' => 'order', 'event_name'=>'Order','is_active'=>1],
            ['slug' => 'order-transaction', 'event_name'=>'OrderTransaction','is_active'=>0],
            ['slug' => 'product', 'event_name'=>'Product','is_active'=>1],
            ['slug' => 'product-listing', 'event_name'=>'ProductListing','is_active'=>0],
            ['slug' => 'refund', 'event_name'=>'Refund','is_active'=>0],
            ['slug' => 'shop', 'event_name'=>'Shop','is_active'=>0],
            ['slug' => 'tender-transaction', 'event_name'=>'TenderTransaction','is_active'=>0],
            ['slug' => 'theme', 'event_name'=>'Theme','is_active'=>0],
            ['slug' => 'order-edit', 'event_name'=>'OrderEdit','is_active'=>0],
            ['slug' => 'shop-alternate-locale', 'event_name'=>'ShopAlternateLocale','is_active'=>0],
            ['slug' => 'dispute', 'event_name'=>'Dispute','is_active'=>0],
            ['slug' => 'subscription-contract', 'event_name'=>'SubscriptionContract','is_active'=>0],


        ];
        WebhookEvent::insert($data);
    }
}
