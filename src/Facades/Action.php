<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Class\Action as IlluminateAction;
use HandmadeWeb\Illuminate\Static\Abstract\AbstractFacadeClass;

class Action extends AbstractFacadeClass
{
    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
        return new IlluminateAction;
    }
}
