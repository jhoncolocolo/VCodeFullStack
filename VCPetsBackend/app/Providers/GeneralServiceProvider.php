<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\General\GeneralService;
use App\Services\Category\CategoryService;
use App\Services\Tag\TagService;
use App\Services\Pet\PetService;
use App\Services\ApiResponse\ApiResponseService;

class GeneralServiceProvider extends ServiceProvider
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
        $this->app->bind('General', function () {
            return new GeneralService();
        });
            $this->app->bind('Category', function () {
            return new CategoryService();
        });
        $this->app->bind('Tag', function () {
            return new TagService();
        });
        $this->app->bind('Pet', function () {
            return new PetService();
        });
    }
}