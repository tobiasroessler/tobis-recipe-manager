<?php

class ToRo_RM_Recipe_Details_Meta_Box {
    
    const META_BOX_ID = "RECIPE_DETAILS_META_BOX";
    const META_BOX_HEADER = "Recipe details";
    const META_BOX_NONCE = "RECIPE_DETAILS_META_BOX_NONCE";
    const META_KEY = "toro_rm_details";
    
    private $recipe_post_Type_id = null;
    
    function __construct($recipe_post_Type_id) {
        $this->recipe_post_Type_id = $recipe_post_Type_id;
    }
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'create_meta_box'));
        add_action('save_post', array($this, 'save_details'), 10, 2 );
    }
    
    function create_meta_box() {
        if($this->recipe_post_Type_id === null) {
            return;
        }
        
        add_meta_box(self::META_BOX_ID, self::META_BOX_HEADER, 
            array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'high');
    }
    
    function save_details($post_id, $post) {
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
        
        // Get data from $_POST
        $new_amount = (isset($_POST['toro_rm_amount']) ? sanitize_html_class($_POST['toro_rm_amount']) : '');
        $new_preparation_time = (isset($_POST['toro_rm_preparation_time']) ? sanitize_html_class($_POST['toro_rm_preparation_time']) : '');
        $new_cooking_time = (isset($_POST['toro_rm_cooking_time']) ? sanitize_html_class($_POST['toro_rm_cooking_time']) : '');
        
        // Get the meta value of the custom field key
        $meta_value = get_post_meta($post_id, self::META_KEY, true);
        
        // Create DOM document
        $dom = new DOMDocument('1.0', 'utf-8');
        $root = $dom->createElement('details');
        $dom->appendChild($root);
        $root->appendChild($dom->createElement('amount', $new_amount));
        $root->appendChild($dom->createElement('preparation_time', $new_preparation_time));
        $root->appendChild($dom->createElement('cooking_time', $new_cooking_time));
        $new_meta_value = $dom->saveXML();
        
        if ($meta_value == '') {
            add_post_meta($post_id, self::META_KEY, $new_meta_value, true);
        } else {
            update_post_meta($post_id, self::META_KEY, $new_meta_value);
        }
    }
    
    function draw() {
        $amount = '';
        $preparation_time = '';
        $cooking_time = '';
        
        $post_id = isset($_REQUEST['post']) ? sanitize_html_class($_REQUEST['post']) : 0;
        $meta_value = $post_id > 0 ? get_post_meta($post_id, self::META_KEY, true) : '';
        if($meta_value != '') {
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->loadXML($meta_value);
            $amount = $dom->getElementsByTagName('amount')->item(0)->nodeValue;
            $preparation_time = $dom->getElementsByTagName('preparation_time')->item(0)->nodeValue;
            $cooking_time = $dom->getElementsByTagName('cooking_time')->item(0)->nodeValue;
        }
        
        echo wp_nonce_field(basename(__FILE__), self::META_BOX_NONCE);
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="amount" class="toro_rm_label_general">Amount</label></div>';
        echo '<input id="amount" name="toro_rm_amount" value="' . $amount . '" type="text" size="4" maxlength="4" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Person(s)</span>';
        echo '</div><hr>';
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="preperation_time" class="toro_rm_label_general">Preperation time</label></div>';
        echo '<input id="preparation_time" name="toro_rm_preparation_time" value="' . $preparation_time . '" type="text" size="4" maxlength="3" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Minute(s)</span>';
        echo '</div><hr>';
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="cooking_time" class="toro_rm_label_general">Cooking time</label></div>';
        echo '<input id="cooking_time" name="toro_rm_cooking_time" value="' . $cooking_time . '" type="text" size="4" maxlength="3" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Minute(s)</span>';
        echo '</div>';
    }
    
}
