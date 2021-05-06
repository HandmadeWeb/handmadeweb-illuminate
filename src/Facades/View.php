<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Facades\Dispatcher;
use HandmadeWeb\Illuminate\Facades\EngineResolver;
use HandmadeWeb\Illuminate\Facades\ViewFinderInterface;

class View extends AbstractFacadeClass
{
    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        return new \Illuminate\View\Factory(EngineResolver::__getFacadeInstance(), ViewFinderInterface::__getFacadeInstance(), Dispatcher::__getFacadeInstance());
    }
}
