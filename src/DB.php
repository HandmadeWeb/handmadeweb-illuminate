<?php

namespace HandmadeWeb\Illuminate;

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

class DB extends Capsule
{
    public function __construct(Container $container = null)
    {
        parent::__construct($container);

        global $wpdb;

        $this->addConnection([
            'driver'    => 'mysql',
            'host'      => $wpdb->dbhost,
            'database'  => $wpdb->dbname,
            'username'  => $wpdb->dbuser,
            'password'  => $wpdb->dbpassword,
            'charset'   => $wpdb->charset,
            'collation' => $wpdb->collate,
            'prefix'    => $wpdb->prefix,
        ]);

        // Set the event dispatcher used by Eloquent models... (optional)

        // $this->setEventDispatcher(new Dispatcher(new Container));

        // Make this Capsule instance available globally via static methods... (optional)
        $this->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        // $this->bootEloquent();
    }
}
