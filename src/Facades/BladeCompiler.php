<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Static\Abstract\AbstractFacadeClass;

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
        $compiledViewPath = trailingslashit(WP_CONTENT_DIR).'cache/compiled-blade-templates';
        locationExistsOrCreate($compiledViewPath);

        return new \Illuminate\View\Compilers\BladeCompiler(Filesystem::__getFacadeInstance(), $compiledViewPath);
    }
}
