<?php
/*
Plugin Name: Handmade Web - Illuminate
Plugin URI: https://
Description:
Author:
Version: 1.0.0
Author URI: https://
*/

use HandmadeWeb\Illuminate\Loader;

defined('ABSPATH') || exit;

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/classes/Carbon.php';
require_once __DIR__.'/classes/Collection.php';
require_once __DIR__.'/classes/DB.php';
require_once __DIR__.'/classes/LazyCollection.php';
require_once __DIR__.'/classes/View.php';

add_action('init', [Loader::class, 'boot_views'], 9999);
