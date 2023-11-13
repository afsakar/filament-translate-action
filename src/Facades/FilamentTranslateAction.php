<?php

namespace Afsakar\FilamentTranslateAction\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Afsakar\FilamentTranslateAction\FilamentTranslateAction
 */
class FilamentTranslateAction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Afsakar\FilamentTranslateAction\FilamentTranslateAction::class;
    }
}
