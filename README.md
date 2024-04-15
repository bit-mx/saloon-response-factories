# Saloon Response Factories

## Table of Contents

- [Installation](#installation)
- [Requirements](#requirements)
- [Use](#use)
- [Headers](#headers)
- [Status](#status)
- [Create a new factory](#create-a-new-factory)

### Installation

You can install the package via composer:

```bash
composer require bitmx/saloon-response-factories
```

### Requirements

This package requires Laravel 10.0 or higher and PHP 8.1 or higher.

### Use

You can use factories to create fake data for your Saloon tests

```php
namespace Tests\SaloonResponseFactories;

use BitMx\SaloonResponseFactories\Factories\SaloonResponseFactory;

class PostResponseFactoryFactory extends SaloonResponseFactory
{
    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
}
```

To create a factory you should extend the SaloonResponseFactory class and implement the definition method.

You can use the faker property to generate fake data.

```php

use Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->create(),
    ]);
});
```

You can also use the count method to create an array of fake data.

```php

use Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->count(5)->create(),
    ]);
});
```

This code create a MockResponse like this:

```php
\Saloon\Http\Faking\MockResponse::make([
    [
        'id' => 1,
        'title' => 'Title 1',
        'content' => 'Content 1',
    ],
    [
        'id' => 2,
        'title' => 'Title 2',
        'content' => 'Content 2',
    ],
    [
        'id' => 3,
        'title' => 'Title 3',
        'content' => 'Content 3',
    ],
    [
        'id' => 4,
        'title' => 'Title 4',
        'content' => 'Content 4',
    ],
    [
        'id' => 5,
        'title' => 'Title 5',
        'content' => 'Content 5',
    ],
]);
```

You can use the state method to change the default values of the factory.

```php

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->state([
            'title' => 'Custom Title',
        ])->create(),
    ]);
});
```

Or create a new method in the factory to change the default values.

```php
namespace Tests\SaloonResponseFactories;

use BitMx\SaloonResponseFactories\Factories\SaloonResponseFactory;

class PostResponseFactoryFactory extends SaloonResponseFactory
{
    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
    
    public function withCustomTitle(): self
    {
        return $this->state([
            'title' => 'Custom Title',
        ]);
    }
}


```

```php

se Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->withCustomTitle()->create(),
    ]);
});
```

## Headers

You can use the headers method to add headers to the response.

```php
namespace Tests\SaloonResponseFactories;

use BitMx\SaloonResponseFactories\Factories\SaloonResponseFactory;

class PostResponseFactoryFactory extends SaloonResponseFactory
{
    /**
     * {@inheritDoc}
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraph(),
        ];
    }
    
    public function withCustomTitle(): self
    {
        return $this->state([
            'title' => 'Custom Title',
        ]);
    }
    
    public function withHeaders(): self
    {
        return $this->headers([
            'X-Custom-Header' => 'Custom Value',
        ]);
    }
}
```

```php

use Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->withHeaders()->create(),
    ]);
});
```

You can also use the headers method to add multiple headers.

```php
namespace Tests\SaloonResponseFactories;

use Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->headers([
            'X-Custom-Header' => 'Custom Value',
            'X-Another-Header' => 'Another Value',
        ])->create(),
    ]);
});
```

## Status

You can use the status method to change the status code of the response.

```php
use Tests\SaloonResponseFactories\PostResponseFactoryFactory;

it('should get the post', function () {
    Saloon::fake([
        GetPostsRequest::class => PostResponseFactoryFactory::new()->status(404)->create(),
    ]);
});

```

### Create a new factory

You can create a new factory using the artisan command.

```bash
php artisan make:saloon-response-factory PostResponseFactory
```

This command will create a new factory in the `tests/SaloonResponseFactories` directory.
