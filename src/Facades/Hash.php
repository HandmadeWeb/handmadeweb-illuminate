<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Hashing\Argon2IdHasher;
use Illuminate\Hashing\ArgonHasher;
use Illuminate\Hashing\BcryptHasher;

class Hash extends AbstractFacadeClass
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
        return new BcryptHasher;
    }

    /**
     * Get a driver instance.
     * Supported: "bcrypt", "argon", "argon2id".
     * @param  string|null  $driver
     * @return mixed
     */
    public function driver($driver = null)
    {
        switch ($driver) {
            case 'bcrypt':
                return new BcryptHasher;
                break;
            case 'argon':
                return new ArgonHasher;
                break;
            case 'argon2id':
                return new Argon2IdHasher;
                break;
        }

        return static::__getFacadeInstance();
    }
}
