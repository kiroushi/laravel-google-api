<?php

namespace Kiroushi\LaravelGoogleApi\Facades;

use Illuminate\Support\Facades\Facade;
use Kiroushi\LaravelGoogleApi\GoogleApi;

class GoogleApiFacade extends Facade
{
    
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GoogleApi::class;
    }

}
