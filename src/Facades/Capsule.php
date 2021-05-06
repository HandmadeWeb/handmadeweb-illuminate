<?php

namespace HandmadeWeb\Illuminate\Facades;

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

        $capsule = new \Illuminate\Database\Capsule\Manager;

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
