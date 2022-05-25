<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return  void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return  void
     */
    public function register()
    {
            App::bind(
            'App\Repositories\Category\CategoryRepositoryInterface',
            'App\Repositories\Category\CategoryRepository'
        );
        App::bind(
            'App\Repositories\Tag\TagRepositoryInterface',
            'App\Repositories\Tag\TagRepository'
        );
        App::bind(
            'App\Repositories\Pet\PetRepositoryInterface',
            'App\Repositories\Pet\PetRepository'
        );
    }
}