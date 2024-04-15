<?php

namespace BitMx\SaloonResponseFactories;

use Illuminate\Support\ServiceProvider;

class SaloonResponseFactoriesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {

    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
        }
    }

    protected function registerCommands(): void
    {
        $this->commands([
            Commands\MakeSaloonResponseFactory::class,
        ]);
    }
}
