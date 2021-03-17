<?php

namespace HandmadeWeb\Illuminate\Facades;

use HandmadeWeb\Illuminate\AbstractFacadeClass;
use Illuminate\Database\Capsule\Manager as Capsule;

class DB extends AbstractFacadeClass
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
        require_wp_db();
        global $wpdb;

        $capsule = new Capsule();

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
