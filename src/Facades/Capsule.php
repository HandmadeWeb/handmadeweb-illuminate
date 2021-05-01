<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\Static\Abstract\AbstractFacadeClass;
use Illuminate\Database\Capsule\Manager as CapsuleManager;

class Capsule extends AbstractFacadeClass
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
        global $wpdb;

        $capsule = new CapsuleManager;

        $capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => $wpdb->dbhost,
            'database'  => $wpdb->dbname,
            'username'  => $wpdb->dbuser,
            'password'  => $wpdb->dbpassword,
            'charset'   => $wpdb->charset,
            'collation' => $wpdb->collate,
            'prefix'    => $wpdb->prefix,
        ]);

        $capsule->setAsGlobal();

        return $capsule;
    }
}
