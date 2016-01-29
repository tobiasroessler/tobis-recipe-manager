<?php
/*
    Plugin Name: Tobi's Recipe Manager
    Plugin URI: http://www.tobiasroessler.com
    Description: Plugin for managing recipes
    Author: Tobias Rössler
    Version: 1.0.0
    Author URI: http://www.tobiasroessler.com
*/

require('includes/class-toro-recipe-manager.php');

$plugin = new TORO_Recipe_Manager();
$plugin->init();

?>