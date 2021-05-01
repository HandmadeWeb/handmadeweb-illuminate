<?php

namespace HandmadeWeb\Illuminate\Static\Abstract;

abstract class AbstractFacadeClass
{
    /**
     * The facaded instance.
     */
    protected static $instance;

    /**
     * Get the instance behind the facade.
     *
     * @return mixed
     */
    public static function __getFacadeInstance()
    {
        if (empty(static::$instance)) {
            static::$instance = static::__setFacadeInstance();
        }

        return static::$instance;
    }

    /**
     * Set the instance behind the facade.
     *
     * @return string
     */
    protected static function __setFacadeInstance()
    {
    }

    /**
     * Handle dynamic, static calls to the facade instance.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return static::__getFacadeInstance()->$method(...$args);
    }
}
