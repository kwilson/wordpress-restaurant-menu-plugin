<?php
/*
Plugin Name: Restaurant Menu
Plugin URI: https://github.com/kwilson/wordpress-restaurant-menu-plugin
Description: Restaurant menu manager.
Version: 1.0
Author: Kevin Wilson
Author URI: http://kwilson.me.uk
License: GPL2
*/

include('assets/inc/class.RestaurantMenu.php');
//include('assets/inc/class.RestaurantMenu.DatabaseManager.php');
include('assets/inc/functions.template-tags.php');

global $restaurantmenu_db_version;
$restaurantmenu_db_version = "1.0";

// Install DB
include_once dirname( __FILE__ ).'/assets/inc/class.RestaurantMenu.DatabaseManager.php';
register_activation_hook(__FILE__, array('RestaurantMenu_DatabaseManager', 'Install'));

?>