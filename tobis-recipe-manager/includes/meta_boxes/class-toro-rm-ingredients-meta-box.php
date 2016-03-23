<?php

class ToRo_RM_Ingredients_Meta_Box {
    
    const META_BOX_ID = "INGREDIENTS_META_BOX";
    const META_BOX_HEADER = "Ingredients";
    const META_BOX_NONCE = "INGREDIENTS_META_BOX_NONCE";
    const POST_INGREDIENT_AMOUNTS = "ingredient_amounts";
    const POST_INGREDIENT_UNITS = "ingredient_units";
    const POST_INGREDIENTS = "ingredients";
    
    private $recipe_post_Type_id = null;
    
    function __construct($recipe_post_Type_id) {
        $this->recipe_post_Type_id = $recipe_post_Type_id;
    }
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'create_meta_box'));
        //add_action('save_post', array($this, 'save_ingredients'), 10, 2 );
    }
    
    function create_meta_box() {
        if($this->recipe_post_Type_id === null) {
            return;
        }
        
        add_meta_box(self::META_BOX_ID, self::META_BOX_HEADER, 
                array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'default');
    }
    
    function save_ingredients($post_id, $post) {
        // Verify the nonce
        if (!isset($_POST[self::META_BOX_NONCE]) || !wp_verify_nonce($_POST[self::META_BOX_NONCE], basename(__FILE__))) {
            return $post_id;
        }
        
        // Get the post type object
        $post_type = get_post_type_object($post->post_type);
        
        // Check if the current user has permission to edit the post
        if (!current_user_can($post_type->cap->edit_post, $post_id)) {
            return $post_id;
        }
        
        // Get the posted data and sanitize it for use as an HTML class
        //$new_meta_value_ingredients = (isset( $_POST[self::POST_INGREDIENTS]) ? sanitize_html_class($_POST[self::POST_INGREDIENTS]) : '' );
        
        // Get the meta key
        //$meta_key = 'toro_rm_details';
    }
    
    function draw() {
        echo wp_nonce_field(basename(__FILE__), self::META_BOX_NONCE);
        echo '<div id="ingredients_wrapper"></div>';
        echo '<div><button id="add_ingredient_button">Add</button></div>';
    }
    
}
