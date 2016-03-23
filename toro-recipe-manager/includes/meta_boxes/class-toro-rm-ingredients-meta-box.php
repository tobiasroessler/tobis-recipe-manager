<?php

class ToRo_RM_Ingredients_Meta_Box {
    
    const META_BOX_ID = "INGREDIENTS_META_BOX";
    const META_BOX_HEADER = "Ingredients";
    const META_BOX_NONCE = "INGREDIENTS_META_BOX_NONCE";
    const POST_INGREDIENT_AMOUNTS = "ingredient_amounts";
    const POST_INGREDIENT_UNITS = "ingredient_units";
    const POST_INGREDIENTS = "ingredients";
    const META_KEY = "toro_rm_ingredients";
    
    private $recipe_post_Type_id = null;
    
    function __construct($recipe_post_Type_id) {
        $this->recipe_post_Type_id = $recipe_post_Type_id;
    }
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'create_meta_box'));
        add_action('save_post', array($this, 'save_ingredients'), 10, 2 );
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
        $amounts = (isset($_POST['toro_rm_ingredient_amounts']) ? sanitize_html_class($_POST['toro_rm_ingredient_amounts']) : '');
        $units = (isset($_POST['toro_rm_ingredient_units']) ? sanitize_html_class($_POST['toro_rm_ingredient_units']) : '');
        $ingredients = (isset($_POST['toro_rm_ingredients']) ? sanitize_html_class($_POST['toro_rm_ingredients']) : '');  
        if(count($ingredients) <= 0) {
            return $post_id;
        }
        
        // Get the meta value of the custom field key
        $meta_value = get_post_meta($post_id, self::META_KEY, true);
        
        // Create DOM document
        $dom = new DOMDocument('1.0', 'utf-8');
        $root = $dom->createElement('ingredients');
        $dom->appendChild($root);
        
        for($i = 0; $i < count($ingredients); $i++) {
            $amount = $amounts[$i];
            $unit = $units[$i];
            $name = $ingredients[$i];
            
            $ingredient_node = $dom->createElement('ingredient');
            $ingredient_node->appendChild($dom->createElement('amount', $amount));
            $ingredient_node->appendChild($dom->createElement('unit', $unit));
            $ingredient_node->appendChild($dom->createElement('name', $name));
            $root->appendChild($ingredient_node);
        }
        
        $new_meta_value = $dom->saveXML();
        
        // Add or update
        if ($meta_value == '') {
            add_post_meta($post_id, self::META_KEY, $new_meta_value, true);
        } else {
            update_post_meta($post_id, self::META_KEY, $new_meta_value);
        }
    }
    
    function draw() {
        $post_id = isset($_REQUEST['post']) ? sanitize_html_class($_REQUEST['post']) : 0;
        $meta_value = $post_id > 0 ? get_post_meta($post_id, self::META_KEY, true) : '';

        echo wp_nonce_field(basename(__FILE__), self::META_BOX_NONCE);
        echo '<div id="ingredients_wrapper">';
        
        if($meta_value != '') {
            $xml = simplexml_load_string($meta_value);
            foreach($xml->ingredient as $ingredient) {
                $amount = $ingredient->amount;
                $unit = $ingredient->unit;
                $name = $ingredient->name;
                
                echo '<div class="ingredient_wrapper">';
                echo '<div>';
                echo '<input type="text" name="toro_rm_ingredient_amounts[]" value="' . $amount . '" />';
                echo '<input type="text" name="toro_rm_ingredient_units[]" value="' . $unit . '" />';
                echo '<input type="text" name="toro_rm_ingredients[]" value="' . $name . '" />';
                echo '</div>';
                echo '<div><a href="#" class="remove_ingredient_link">Remove</a><span class="ingredient_up_button_separator">|</span><a href="#" class="ingredient_up_link">Up</a><span class="ingredient_down_button_separator">|</span><a href="#" class="ingredient_down_link">Down</a></div>';
                echo '<hr>';
                echo '</div>';
            }
        }
        
        echo '</div>';
        echo '<div><button id="add_ingredient_button">Add</button></div>';
    }
    
}
