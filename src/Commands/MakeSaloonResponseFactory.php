<?php

namespace BitMx\SaloonResponseFactories\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeSaloonResponseFactory extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:saloon-response-factory {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new saloon response factory class';

    protected string $namespace = 'Tests\SaloonResponseFactories';

    #[\Override]
    protected function getStub(): string
    {
        return $this->getStubPath();
    }

    public function getStubPath(): string
    {
        return __DIR__.'/../../stubs/saloon-response-factory.stub';
    }

    /**
     * @param  string  $name
     */
    protected function getPath(mixed $name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests').str_replace('\\', '/', $name).'.php';
    }

    /**
     * Get the root namespace for the class.
     */
    protected function rootNamespace(): string
    {
        return 'Tests';
    }

    /**
     * @param  string  $rootNamespace
     */
    protected function getDefaultNamespace(mixed $rootNamespace): string
    {
        return $rootNamespace.'\SaloonResponseFactories';
    }
}
