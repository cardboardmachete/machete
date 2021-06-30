<?php

namespace Machete;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class MacheteServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        if ($this->app->runningInConsole()) {
            if (!class_exists('CreateAccountsTable')) {
                $this->publishes([
                    __DIR__ . '/../database/migrations/create_accounts_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_accounts_table'),
                    __DIR__ . '/../database/migrations/create_characters_table.php.stub' => $this->getMigrationFileName($filesystem, 'create_characters_table'),
                    // ...
                ], 'migrations');
            }
        }
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     */
    protected function getMigrationFileName(Filesystem $filesystem, string $fileName): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath() . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem, $fileName) {
                return $filesystem->glob("{$path}*_{$fileName}.php");
            })->push($this->app->databasePath() . "/migrations/{$timestamp}_{$fileName}.php")
            ->first();
    }
}
