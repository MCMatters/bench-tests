<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function map(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group("{$this->app->basePath()}/routes/web.php");
    }
}
