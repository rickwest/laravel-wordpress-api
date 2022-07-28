<?php

namespace RickWest\WordPress\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use RickWest\WordPress\WordPressServiceProvider;

class TestCase extends Orchestra
{
    /**
     * @inheritDoc
     */
    protected function getPackageProviders($app): array
    {
        return [
            WordPressServiceProvider::class,
        ];
    }
}
