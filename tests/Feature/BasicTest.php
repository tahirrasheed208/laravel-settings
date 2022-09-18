<?php

namespace TahirRasheed\LaravelSettings\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use TahirRasheed\LaravelSettings\Tests\TestCase;

class BasicTest extends TestCase
{
    use DatabaseTransactions;

    public function test_check_value_save_in_settings()
    {
        setting()->put('foo', 'bar');
        $foo = setting()->get('foo');

        $this->assertEquals('bar', $foo);
    }

    public function test_get_value_from_settings()
    {
        $foo = setting()->get('foo');

        $this->assertNotEquals('bar', $foo);
    }

    public function test_check_default_value_is_working()
    {
        $foo = setting()->get('foo', 'bar');

        $this->assertEquals('bar', $foo);
    }

    public function test_check_value_deleted_from_settings()
    {
        setting()->delete('foo');
        $foo = setting()->get('foo');

        $this->assertNotEquals('bar', $foo);
    }
}