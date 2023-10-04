<?php

namespace OmniaDigital\CatalystFormsPlugin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \OmniaDigital\CatalystFormsPlugin\CatalystFormsPlugin
 */
class CatalystFormsPlugin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \OmniaDigital\CatalystFormsPlugin\CatalystFormsPlugin::class;
    }
}
