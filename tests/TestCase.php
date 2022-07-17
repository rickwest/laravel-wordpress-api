<?php

namespace RickWest\Wordpress\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RickWest\Wordpress\WordpressServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app)
    {
        return [
            WordpressServiceProvider::class,
        ];
    }
}
