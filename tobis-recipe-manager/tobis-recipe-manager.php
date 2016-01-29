<?php
/*
    Plugin Name: Tobi's Recipe Manager
    Plugin URI: http://www.tobiasroessler.com
    Description: Plugin for managing recipes
    Author: Tobias Rössler
    Version: 1.0.0
    Author URI: http://www.tobiasroessler.com
*/

function register_tobis_recipe_manager_plugin() {
    $labels = array(
        'name' => _x('Tobi\'s Recipes', 'tobis_recipe_manager'),
        'singular_name' => _x('Tobi\'s Recipes', 'tobis_recipe_manager'),
        'add_new' => _x('Add New', 'tobis_recipe_manager'),
        'add_new_item' => _x('Add New Recipe', 'tobis_recipe_manager'),
        'edit_item' => _x('Edit Recipe', 'tobis_recipe_manager'),
        'new_item' => _x('New Recipe', 'tobis_recipe_manager'),
        'view_item' => _x('View Recipe', 'tobis_recipe_manager'),
        'search_items' => _x('Search Recipes', 'tobis_recipe_manager'),
        'not_found' => _x('No recipes found', 'tobis_recipe_manager'),
        'not_found_in_trash' => _x('No recipes found in trash', 'tobis_recipe_manager'),
        'menu_name' => _x('Tobi\'s Recipes', 'tobis_recipe_manager'),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Tobi\'s Recipes',
        'public' => true,
        'show_in_menu' => true,
        'menu_position' => 6,
        'has_archive' => true,
        'rewrite' => true,
    );
 
    register_post_type('tobis_recipes', $args);
}

add_action('init', 'register_tobis_recipe_manager_plugin', 0);

function add_submenu_for_ingredients(){
    add_submenu_page('edit.php?post_type=tobis_recipes', 'Ingredients', 'Ingredients', 'activate_plugins', 'tobis_recipes_ingredients', 'my_render_list_page');
}

add_action('admin_menu', 'add_submenu_for_ingredients');

function my_render_list_page() {
    echo '<div class="wrap">TEST 123</div>';
}

?>