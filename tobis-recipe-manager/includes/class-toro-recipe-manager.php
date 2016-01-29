<?php

class TORO_Recipe_Manager {
    
    const RECIPE_POST_TYPE_ID = "tobis_recipes";
    const RECIPE_POST_TYPE_NAME = "Recipes";
    const RECIPE_POST_TYPE_DESC = "Tobi's Recipes";
    const RECIPE_POST_TYPE_MENU_NAME = "Recipes";
    const RECIPE_POST_TYPE_ADD_NEW = "Add New";
    const RECIPE_POST_TYPE_EDIT_RECIPE = "Edit Recipe";
    const RECIPE_POST_TYPE_NEW = "New Recipe";
    const RECIPE_POST_TYPE_VIEW = "View Recipe";
    const RECIPE_POST_TYPE_SEARCH = "Search Recipes";
    const RECIPE_POST_TYPE_MENU_POSITION = 8;
    const RECIPES_NOT_FOUND = "No recipes found";
    const RECIPES_NOT_FOUND_IN_TRASH = "No recipes found in trash";
    
    const INGREDIENTS_PARENT_SLUG = "edit.php?post_type=tobis_recipes";
    const INGREDIENTS_PAGE_TITLE = "Ingredients";
    const INGREDIENTS_MENU_TITLE = "Ingredients";
    const INGREDIENTS_CAPABILITY = "activate_plugins";
    const INGREDIENTS_MENU_SLUG = "tobis_recipes_ingredients";
    const INGREDIENTS_FUNCTION = "my_render_list_page";
    
    function __construct() {
        // Do nothing
    }
    
    function init() {
        // Register the plugin
        add_action('init', array($this, 'register_plugin'), 0);
        
        // Add a submenu for managing the ingredients
        add_action('admin_menu', array($this, 'add_submenu_for_ingredients'));
    }
  
    function register_plugin() {
        $this->register_recipes_post_type();
    }
    
    function register_recipes_post_type() {
        $labels = array(
            'name' => _x(self::RECIPE_POST_TYPE_NAME, 'tobis_recipe_manager'),
            'singular_name' => _x(self::RECIPE_POST_TYPE_NAME, 'tobis_recipe_manager'),
            'add_new' => _x(self::RECIPE_POST_TYPE_ADD_NEW, 'tobis_recipe_manager'),
            'add_new_item' => _x(self::RECIPE_POST_TYPE_ADD_NEW, 'tobis_recipe_manager'),
            'edit_item' => _x(self::RECIPE_POST_TYPE_EDIT_RECIPE, 'tobis_recipe_manager'),
            'new_item' => _x(self::RECIPE_POST_TYPE_NEW, 'tobis_recipe_manager'),
            'view_item' => _x(self::RECIPE_POST_TYPE_VIEW, 'tobis_recipe_manager'),
            'search_items' => _x(self::RECIPE_POST_TYPE_SEARCH, 'tobis_recipe_manager'),
            'not_found' => _x(self::RECIPES_NOT_FOUND, 'tobis_recipe_manager'),
            'not_found_in_trash' => _x(self::RECIPES_NOT_FOUND_IN_TRASH, 'tobis_recipe_manager'),
            'menu_name' => _x(self::RECIPE_POST_TYPE_MENU_NAME, 'tobis_recipe_manager'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => self::RECIPE_POST_TYPE_DESC,
            'public' => true,
            'show_in_menu' => true,
            'menu_position' => self::RECIPE_POST_TYPE_MENU_POSITION,
            'has_archive' => true,
            'rewrite' => true,
        );
        
        register_post_type(self::RECIPE_POST_TYPE_ID, $args);
    }

    function add_submenu_for_ingredients(){
        add_submenu_page(self::INGREDIENTS_PARENT_SLUG, 
                self::INGREDIENTS_PAGE_TITLE, 
                self::INGREDIENTS_MENU_TITLE, 
                self::INGREDIENTS_CAPABILITY, 
                self::INGREDIENTS_MENU_SLUG, 
                array($this, self::INGREDIENTS_FUNCTION));
    }

    function my_render_list_page() {
        echo '<div class="wrap">TEST 123</div>';
    }
    
}

