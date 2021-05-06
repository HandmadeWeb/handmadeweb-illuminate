<?php

namespace HandmadeWeb\Illuminate\Facades;

class EngineResolver extends AbstractFacadeClass
{
    /**
     * The facaded instance.
     */
    protected static $instance;

    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        $viewResolver = new \Illuminate\View\Engines\EngineResolver;

        $viewResolver->register('blade', function () {
            return CompilerEngine::__getFacadeInstance();
        });

        return $viewResolver;
    }
}
