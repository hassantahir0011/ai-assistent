<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Entities\WebhookTopic;;

class WebhookTopicsSeeder extends Seeder
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

            ['webhook_event_id'=>1,'topic_name'=>'carts/create',
                'webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>1,'topic_name'=>'carts/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>2,'topic_name'=>'checkouts/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>2,'topic_name'=>'checkouts/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>2,'topic_name'=>'checkouts/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'   ],

            ['webhook_event_id'=>3,'topic_name'=>'collections/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'  ],
            ['webhook_event_id'=>3,'topic_name'=>'collections/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'  ],
            ['webhook_event_id'=>3,'topic_name'=>'collections/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'  ],

            ['webhook_event_id'=>4,'topic_name'=>'collection_listings/add','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>4,'topic_name'=>'collection_listings/remove','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>4,'topic_name'=>'collection_listings/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],



            ['webhook_event_id'=>5,'topic_name'=>'customers/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>5,'topic_name'=>'customers/disable','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>5,'topic_name'=>'customers/enable','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>5,'topic_name'=>'customers/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>5,'topic_name'=>'customers/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],


            ['webhook_event_id'=>6,'topic_name'=>'customer_groups/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled' ],
            ['webhook_event_id'=>6,'topic_name'=>'customer_groups/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled' ],
            ['webhook_event_id'=>6,'topic_name'=>'customer_groups/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled' ],





            ['webhook_event_id'=>7,'topic_name'=>'draft_orders/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>7,'topic_name'=>'draft_orders/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>7,'topic_name'=>'draft_orders/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],


            ['webhook_event_id'=>8,'topic_name'=>'fulfillments/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>8,'topic_name'=>'fulfillments/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled' ],


            ['webhook_event_id'=>9,'topic_name'=>'fulfillment_events/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>9,'topic_name'=>'fulfillment_events/delete','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>10,'topic_name'=>'inventory_items/create','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>10,'topic_name'=>'inventory_items/update','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>10,'topic_name'=>'inventory_items/delete','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],


            ['webhook_event_id'=>11,'topic_name'=>'inventory_levels/connect','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>11,'topic_name'=>'inventory_levels/update','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>11,'topic_name'=>'inventory_levels/disconnect','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>12,'topic_name'=>'locations/create','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>12,'topic_name'=>'locations/update','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>12,'topic_name'=>'locations/delete','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],



            ['webhook_event_id'=>13,'topic_name'=>'orders/cancelled','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/fulfilled','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/paid','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/partially_fulfilled','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/updated','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>13,'topic_name'=>'orders/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled'],




            ['webhook_event_id'=>14,'topic_name'=>'order_transactions/create',
                'webhook_topic_url'=>'process_shopify_webhooks',
                'topic_status'=>'disabled'],


            ['webhook_event_id'=>15,'topic_name'=>'products/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled' ],
            ['webhook_event_id'=>15,'topic_name'=>'products/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled'],
            ['webhook_event_id'=>15,'topic_name'=>'products/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'enabled'],




            ['webhook_event_id'=>16,'topic_name'=>'product_listings/add',
                'webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>16,'topic_name'=>'product_listings/remove','webhook_topic_url'
            =>'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>16,'topic_name'=>'product_listings/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>17,'topic_name'=>'refunds/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],


            ['webhook_event_id'=>18,'topic_name'=>'app/uninstalled','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'

            ],
            ['webhook_event_id'=>18,'topic_name'=>'shop/update','webhook_topic_url'=>'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>19,'topic_name'=>'tender_transactions/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'
            ],

            ['webhook_event_id'=>20,'topic_name'=>'themes/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>20,'topic_name'=>'themes/publish','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>20,'topic_name'=>'themes/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>20,'topic_name'=>'themes/delete','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>21,'topic_name'=>'orders/edited','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],

            ['webhook_event_id'=>22,'topic_name'=>'locales/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            ['webhook_event_id'=>22,'topic_name'=>'locales/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],

            [
                'webhook_event_id'=>23,'topic_name'=>'disputes/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            [
                'webhook_event_id'=>23,'topic_name'=>'disputes/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            [
                'webhook_event_id'=>24,'topic_name'=>'subscription_contracts/create','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled'],
            [
                'webhook_event_id'=>24,'topic_name'=>'subscription_contracts/update','webhook_topic_url'=>
                'process_shopify_webhooks','topic_status'=>'disabled']

        ];
        WebhookTopic::insert($data);
    }
}
