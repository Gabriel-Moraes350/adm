<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    const API_SUBDOMAIN = 'api';
    const ADM_SUBDOMAIN = 'adm';
    const WEB_SUBDOMAIN = 'web';
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        switch($this->mapRoutes())
        {
            case self::ADM_SUBDOMAIN:
                $this->mapAdmRoutes();
                break;
            case self::API_SUBDOMAIN:
                $this->mapApiRoutes();
                break;
            case self::WEB_SUBDOMAIN:
            default:
                $this->mapWebRoutes();
                break;
        }

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function mapAdmRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/adm.php'));
    }


    private function mapRoutes()
    {
        try{
           if(($subdomain = \strtolower(\trim(\explode('.', $_SERVER['HTTP_HOST'])[0]))) && !empty($subdomain))
           {
               return $subdomain;
           }
        }catch(\Exception $e){}

    }
}
