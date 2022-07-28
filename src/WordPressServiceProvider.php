<?php

namespace RickWest\WordPress;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class WordPressServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-wordpress-api')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(WordPress::class, fn () => new WordPress());
    }
}
