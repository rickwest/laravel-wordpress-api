<?php

namespace RickWest\Wordpress;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RickWest\Wordpress\Commands\WordpressCommand;

class WordpressServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-wordpress-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-wordpress-api_table')
            ->hasCommand(WordpressCommand::class);
    }
}
