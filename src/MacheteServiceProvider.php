<?php

namespace Machete;

use Illuminate\Support\ServiceProvider;

class MacheteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateAccountsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_accounts_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_accounts_table.php'),
                    // ...
                ], 'migrations');
            }
        }
    }
}
