<?php

namespace BitMx\SaloonResponseFactories\Factories;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Arr;
use Saloon\Http\Faking\MockResponse;

abstract class SaloonResponseFactory
{
    protected Generator $faker;

    /**
     * @param  array<array-key, mixed>  $attributes
     * @param  array<array-key, mixed>  $without
     * @param  array<array-key, mixed>  $headers
     */
    final public function __construct(
        protected readonly array $attributes = [],
        protected readonly array $without = [],
        protected readonly int $status = 200,
        protected readonly array $headers = [],
        protected readonly int $times = 1,
    ) {
        $this->faker = Factory::create();
    }

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public function create(array $attributes = []): MockResponse
    {
        return (new CreateFactoryData)($this->state($attributes), $this->times);
    }

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public function state(array $attributes): static
    {
        return $this->newInstance(
            attributes: $attributes,
        );
    }

    /**
     * @param  array<array-key, mixed>  $attributes
     * @param  array<array-key, mixed>  $without
     * @param  array<array-key, mixed>  $headers
     */
    protected function newInstance(
        array $attributes = [],
        array $without = [],
        int $status = 200,
        array $headers = [],
        int $times = 1,
    ): static {
        return new static(
            attributes: array_replace_recursive(
                $this->attributes,
                $attributes,
            ),
            without: array_merge(
                $this->without,
                $without,
            ),
            status: $status,
            headers: array_replace_recursive($this->headers, $headers),
            times: $times,
        );
    }

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function new(
        array $attributes = [],
    ): static {
        return (new static())->state($attributes)->newInstance();
    }

    public function getTimes(): int
    {
        return $this->times;
    }

    /**
     * @param  array<array-key, mixed>  $headers
     */
    public function headers(array $headers): static
    {
        return $this->newInstance(
            headers: $headers,
        );
    }

    public function status(int $status): static
    {
        return $this->newInstance(
            status: $status,
        );
    }

    public function count(int $times): static
    {
        return $this->newInstance(
            times: $times,
        );
    }

    public function getFactoryData(): FactoryData
    {
        return new FactoryData(
            definition: $this->definition(),
            attributes: $this->attributes,
            definedHeaders: $this->withHeaders(),
            headers: $this->headers,
            without: $this->without,
            status: $this->status ?? 200,
            wrap: $this->defaultWrap(),
            metadata: $this->metadata(),
        );
    }

    /**
     * @return array<array-key, mixed>
     */
    abstract public function definition(): array;

    /**
     * @return array<array-key, mixed>
     */
    public function withHeaders(): array
    {
        return [];
    }

    public function defaultWrap(): string
    {
        return '';
    }

    /**
     * @return array<array-key, mixed>
     */
    public function metadata(): array
    {
        return [];
    }

    /**
     * @param  array<array-key, mixed>|string  $attributes
     */
    final public function without(array|string $attributes): static
    {
        return $this->newInstance(
            without: Arr::wrap($attributes),
        );
    }
}
