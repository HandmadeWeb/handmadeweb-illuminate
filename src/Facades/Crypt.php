<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Encryption\Encrypter;

class Crypt extends AbstractFacadeClass
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
        return new Encrypter('base64:EeigPCN4wCFaZJclcv7VKPV+42yHTvuUV3rfpN+nxeI=');
    }
}
