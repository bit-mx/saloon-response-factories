<?php

use BitMx\SaloonResponseFactories\Commands\MakeSaloonResponseFactory;

use function Pest\Laravel\artisan;

it('generates a new SaloonResponseFactory', function () {
    $name = 'UserSaloonResponseFactory';

    artisan(MakeSaloonResponseFactory::class, ['name' => $name])
        ->assertSuccessful()
        ->execute();

    $this->assertFileExists(base_path("tests/SaloonResponseFactories/{$name}.php"));
});
