<?php

namespace OmniaDigital\CatalystForms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystForms\CatalystFormsPlugin
 */
class CatalystFormsPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystForms\CatalystFormsPlugin::class;
    }
}
