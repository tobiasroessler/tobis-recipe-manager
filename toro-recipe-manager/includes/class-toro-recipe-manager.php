<?php

if(!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

require_once('installation_and_update/class-toro-recipe-manager-installer.php');
require_once('list_tables/class-toro-rm-ingredients-list-table.php');
require_once('meta_boxes/class-toro-rm-recipe-details-meta-box.php');
require_once('meta_boxes/class-toro-rm-ingredients-meta-box.php');
require_once('meta_boxes/class-toro-rm-steps-meta-box.php');

global $toro_rm_db_version;
$toro_rm_db_version = '1.0.0';

class ToRo_Recipe_Manager {
    
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
    const INGREDIENTS_FUNCTION = "render_ingredients_list_table";
    
    public $installer = null;
    public $recipe_details_meta_box = null;
    public $ingredients_meta_box = null;
    public $steps_meta_box = null;
    
    function __construct() {
        $this->installer = new ToRo_Recipe_Manager_Installer();
        $this->recipe_details_meta_box = new ToRo_RM_Recipe_Details_Meta_Box(self::RECIPE_POST_TYPE_ID);
        $this->ingredients_meta_box = new ToRo_RM_Ingredients_Meta_Box(self::RECIPE_POST_TYPE_ID);
        $this->steps_meta_box = new ToRo_RM_Steps_Meta_Box(self::RECIPE_POST_TYPE_ID);
    }
    
    public function install() {
        // Install the plugin
        $this->installer->install();
    }
    
    function init() {
        // Register the plugin
        add_action('init', array($this, 'init_plugin'), 0);
        
        // Insert style scripts
        //add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
        add_action('init', array($this, 'enqueue_styles_and_scripts'));
        
        // Add a submenu for managing the ingredients
        add_action('admin_menu', array($this, 'add_submenu_for_ingredients'));
        
        // Register plugins_loaded hock for updating the plugin
        add_action('plugins_loaded', array($this->installer, 'update'));
        
        // Register add_meta_boxes hock for adding metaboxs
        $this->recipe_details_meta_box->init();
        $this->ingredients_meta_box->init();
        $this->steps_meta_box->init();
    }
  
    function init_plugin() {
        // Register post type
        $this->register_recipes_post_type();
        
        // Register styles
        $pluginDir = plugins_url('/css/admin.css', __FILE__);
        wp_register_style('toro_rm_admin_styles', $pluginDir);
        
        // Register JavaScript
        $scriptDir = plugins_url('/js/admin.js', __FILE__);
        wp_register_script('toro_rm_admin_scripts', $scriptDir);
    }
    
    function enqueue_styles_and_scripts() {
        wp_enqueue_style('toro_rm_admin_styles');
        wp_enqueue_script('toro_rm_admin_scripts');
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
            'supports' => array('title','thumbnail'),
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

    function render_ingredients_list_table() {
        $listTable = new ToRo_RM_Ingredients_List_Table();
        echo '<div class="wrap"><h2>My List Table Test</h2>'; 
        $listTable->prepare_items(); 
        $listTable->display(); 
        echo '</div>'; 
    }
    
}

