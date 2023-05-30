<?php

namespace App\Console;

use App\Entities\WebhookLog;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //   clear table incoming webhooks
        $schedule->call(function () {
            DB::table('incoming_shopify_webhooks')
                ->where('created_at', '<', \Carbon\Carbon::now()->subMinute(100))->delete();
        //refresh processed jobs per shop every month end
            if(\Carbon\Carbon::now()->endOfMonth()->isToday()){
                DB::table("processed_jobs")->truncate();
            }
        })->evenInMaintenanceMode();

        // clear logs
        $schedule->call(function () {
            // delete logs of past 7 days for basic plan
            WebhookLog::where('webhook_logs.created_at', '<', \Carbon\Carbon::now()->subDays(7))
                ->join('shops', 'webhook_logs.shop_id', '=', 'shops.shop_id', 'inner')
                ->whereIn('shops.current_plan_type', ['basic', 'professional'])
                ->delete();
            // delete logs of past 30 days for non basic plans
            WebhookLog::where('webhook_logs.created_at', '<', \Carbon\Carbon::now()->subDays(30))
                ->join('shops', 'webhook_logs.shop_id', '=', 'shops.shop_id', 'inner')
                ->where('shops.current_plan_type', 'elite')
                ->delete();
        });


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
