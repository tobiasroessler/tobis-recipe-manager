<?php
/*
    Plugin Name: Tobi's Recipe Manager
    Plugin URI: http://www.tobiasroessler.com
    Description: Plugin for managing recipes
    Author: Tobias Rössler
    Version: 1.0.0
    Author URI: http://www.tobiasroessler.com
*/

error_reporting(E_STRICT);

require('includes/class-toro-recipe-manager.php');

// Create recipe manager instance and initialize the plugin
$plugin = new ToRo_Recipe_Manager();
$plugin->init();

// This must be in the main plugin file
register_activation_hook(__FILE__, array($plugin, 'install'));

?>