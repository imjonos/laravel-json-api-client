<?php

namespace Nos\JsonApiClient\Facades;

use Illuminate\Support\Facades\Facade;

class JsonApiClient extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'jsonapiclient';
    }
}
