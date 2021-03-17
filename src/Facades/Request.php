<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Http\Request as HttpRequest;

class Request extends AbstractFacadeClass
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
        return HttpRequest::capture();
    }
}
