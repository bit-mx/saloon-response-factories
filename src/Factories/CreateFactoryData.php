<?php

namespace BitMx\SaloonResponseFactories\Factories;

use Saloon\Http\Faking\MockResponse;

class CreateFactoryData
{
    public function __invoke(
        SaloonResponseFactory $factory,
        int $times = 1,
    ): MockResponse {
        return MockResponse::make(
            body: $factory->getFactoryData()->getBody($times),
            status: $factory->getFactoryData()->getStatus(),
            headers: $factory->getFactoryData()->getHeaders(),
        );
    }
}
