<?php

namespace App\Providers;

use Illuminate\Session\SessionServiceProvider as OriginalServiceProvider;

class CookielessSessionProvider extends OriginalServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register()
    {
        parent::register();
        $this->registerSessionManager();

        $this->registerSessionDriver();

        $this->app->singleton(\App\Http\Middleware\StartCookielessSession::class);
    }
}