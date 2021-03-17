<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;

class BladeCompiler extends AbstractFacadeClass
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
        $compiledViewPath = __DIR__.'/../../compiled-blade-templates';

        return new \Illuminate\View\Compilers\BladeCompiler(Filesystem::__getFacadeInstance(), $compiledViewPath);
    }
}
