<?php

namespace BitMx\SaloonResponseFactories\Tests;

use BitMx\SaloonResponseFactories\SaloonResponseFactoriesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            SaloonResponseFactoriesServiceProvider::class,
        ];
    }
}
