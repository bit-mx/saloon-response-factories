<?php

namespace BitMx\SaloonResponseFactories\Factories;

class FactoryData
{
    /**
     * @param  array<array-key, mixed>  $definition
     * @param  array<array-key, mixed>  $attributes
     * @param  array<array-key, mixed>  $definedHeaders
     * @param  array<array-key, mixed>  $headers
     * @param  array<array-key, mixed>  $without
     * @param  array<array-key, mixed>  $metadata
     */
    public function __construct(
        private readonly array $definition,
        private readonly array $attributes,
        private readonly array $definedHeaders,
        private readonly array $headers,
        private readonly array $without,
        private readonly int $status = 200,
        private readonly string $wrap = 'data',
        private readonly array $metadata = [],
    ) {}

    /**
     * @return array<array-key, mixed>
     */
    public function getBody(int $times = 1): array
    {
        $body = $this->createBody($times);

        $wrappedBody = $this->wrapBody($body);

        return [
            ...$wrappedBody,
            ...$this->metadata,
        ];

    }

    /**
     * @return array<array-key, mixed>
     */
    protected function createBody(int $times): array
    {
        if ($times === 1) {
            return $this->getData();
        }

        return collect()
            ->times($times, fn () => $this->getData())
            ->all();
    }

    /**
     * @return array<array-key, mixed>
     */
    protected function getData(): array
    {
        return collect($this->getAttributes())
            ->forget($this->getWithout())
            ->all();
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getAttributes(): array
    {
        return array_replace_recursive($this->definition, $this->attributes);
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getWithout(): array
    {
        return $this->without;
    }

    /**
     * @param  array<array-key, mixed>  $body
     * @return array<array-key, mixed>
     */
    protected function wrapBody(array $body): array
    {
        if ($this->wrap) {
            return [$this->wrap => $body];
        }

        return $body;
    }

    /**
     * @return array<string, bool|float|int|string>
     */
    public function getHeaders(): array
    {
        return array_replace_recursive($this->definedHeaders, $this->headers);
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}
