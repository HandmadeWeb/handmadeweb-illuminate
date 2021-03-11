<?php

if (! class_exists('DB')) {
    class DB extends \HandmadeWeb\Illuminate\DB
    {
    }

    class_exists('DB') ? new \DB : null;
}
