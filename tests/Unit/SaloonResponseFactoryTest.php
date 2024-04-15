<?php

use BitMx\SaloonResponseFactories\Factories\SaloonResponseFactory;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->factory = new class extends SaloonResponseFactory
    {
        public function definition(): array
        {
            return [
                'name' => 'John Doe',
            ];
        }
    };
});

it('creates a new instance of SaloonResponseFactory', function () {
    expect($this->factory)->toBeInstanceOf(SaloonResponseFactory::class);
});

it('gets the definition from the factory', function () {

    expect($this->factory->create())->toBeInstanceOf(MockResponse::class)
        ->and($this->factory->create()->body()->all())->toBe(['name' => 'John Doe']);
});

it('creates a new state', function () {
    $factory = $this->factory->state(['name' => 'Jane Doe']);

    expect($factory->create()->body()->all())->toBe(['name' => 'Jane Doe']);
});

it('creates a array with n times the definition', function () {
    $factory = $this->factory->count(3);

    expect($factory->create()->body()->all())->toBe([
        ['name' => 'John Doe'],
        ['name' => 'John Doe'],
        ['name' => 'John Doe'],
    ]);
});

it('get the data without the specified keys', function () {
    $factory = $this->factory->without(['name']);

    expect($factory->create()->body()->all())->toBe([]);
});

it('get attributes  merged with definition', function () {
    $factory = $this->factory
        ->state([
            'email' => 'test@example.com',
            'last_name' => 'Doey',
        ])
        ->without(['last_name']);

    expect($factory->create()->body()->all())->toBe([
        'name' => 'John Doe',
        'email' => 'test@example.com',
    ]);
});

it('overrides the definition with the attributes', function () {
    $factory = $this->factory
        ->state([
            'name' => 'Jane Doe',
        ]);

    expect($factory->create()->body()->all())->toBe(['name' => 'Jane Doe']);

});

it('overrides the definition with the attributes and the array on creates method', function () {
    $data = $this->factory
        ->state([
            'name' => 'Jane Doe',
        ])
        ->create(['name' => 'Elon Musk']);

    expect($data->body()->all())->toBe(['name' => 'Elon Musk']);

});

it('add headers to response', function () {
    $factory = new class extends SaloonResponseFactory
    {
        public function definition(): array
        {
            return [
                'name' => 'John Doe',
            ];
        }

        public function withHeaders(): array
        {
            return [
                'Content-Type' => 'application/json',
            ];
        }
    };

    expect($factory->create()->headers()->all())->toBe(['Content-Type' => 'application/json']);

});

it('overrides the headers with the headers array', function () {
    $factory = new class extends SaloonResponseFactory
    {
        public function definition(): array
        {
            return [
                'name' => 'John Doe',
            ];
        }

        public function withHeaders(): array
        {
            return [
                'Content-Type' => 'application/json',
            ];
        }
    };

    $data = $factory
        ->headers([
            'Content-Type' => 'application/xml',
            'X-Header' => 'test',
        ])
        ->create();

    expect($data->headers()->all())->toBe([
        'Content-Type' => 'application/xml',
        'X-Header' => 'test',
    ]);

});
