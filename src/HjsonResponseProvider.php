<?php

namespace HjsonResponse;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class HjsonResponseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('hjson', function ($value, $http_code = null, $errno = null) {
            return (new HjsonResponse())->toResponse($value, $http_code, $errno);
        });

        Response::macro('makeHjson', function () {
            return new HjsonResponse();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
