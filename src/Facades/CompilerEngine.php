<?php

namespace HandmadeWeb\Illuminate\Facades;

class CompilerEngine extends AbstractFacadeClass
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
        return new \Illuminate\View\Engines\CompilerEngine(BladeCompiler::__getFacadeInstance());
    }
}
