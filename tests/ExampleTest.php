<?php

namespace Rubium\Getresponse\Tests;

use Orchestra\Testbench\TestCase;
use Rubium\Getresponse\GetresponseServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [GetresponseServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
