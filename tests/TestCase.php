<?php

namespace TahirRasheed\LaravelSettings\Tests;

use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    use WithWorkbench;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', ['--database' => 'testing'])->run();
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('database.default', 'testing');
    }
}
