<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Class\Filter as IlluminateFilter;
use HandmadeWeb\Illuminate\Static\Abstract\AbstractFacadeClass;

class Filter extends AbstractFacadeClass
{
    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        return new IlluminateFilter;
    }
}
