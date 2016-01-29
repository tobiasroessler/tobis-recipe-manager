<?php

class TORO_Recipe_Manager {
    
    const NAME = "Recipes";
    const MENU_NAME = "Recipes";
    const ADD_NEW = "Add New";
    const EDIT_RECIPE = "Edit Recipe";
    const NEW_RECIPE = "New Recipe";
    const VIEW_RECIPE = "View Recipe";
    const SEARCH_RECIPES = "Search Recipes";
    const NOT_FOUND = "No recipes found";
    const NOT_FOUND_IN_TRASH = "No recipes found in trash";
    
    const RECIPE_POST_TYPE_NAME = "tobis_recipes";
    const RECIPE_POST_TYPE_DESC = "Tobi's Recipes";
    const MENU_POSITION = 8;
    
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
            'name' => _x(self::NAME, 'tobis_recipe_manager'),
            'singular_name' => _x(self::NAME, 'tobis_recipe_manager'),
            'add_new' => _x(self::ADD_NEW, 'tobis_recipe_manager'),
            'add_new_item' => _x(self::ADD_NEW, 'tobis_recipe_manager'),
            'edit_item' => _x(self::EDIT_RECIPE, 'tobis_recipe_manager'),
            'new_item' => _x(self::NEW_RECIPE, 'tobis_recipe_manager'),
            'view_item' => _x(self::VIEW_RECIPE, 'tobis_recipe_manager'),
            'search_items' => _x(self::SEARCH_RECIPES, 'tobis_recipe_manager'),
            'not_found' => _x(self::NOT_FOUND, 'tobis_recipe_manager'),
            'not_found_in_trash' => _x(self::NOT_FOUND_IN_TRASH, 'tobis_recipe_manager'),
            'menu_name' => _x(self::MENU_NAME, 'tobis_recipe_manager'),
        );

        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'description' => self::RECIPE_POST_TYPE_DESC,
            'public' => true,
            'show_in_menu' => true,
            'menu_position' => self::MENU_POSITION,
            'has_archive' => true,
            'rewrite' => true,
        );
        
        register_post_type(self::RECIPE_POST_TYPE_NAME, $args);
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

