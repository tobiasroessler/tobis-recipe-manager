<?php

class ToRo_RM_Steps_Meta_Box {
    
    const META_BOX_ID = "STEPS_META_BOX";
    const META_BOX_HEADER = "Steps";
    const META_BOX_NONCE = "STEPS_META_BOX_NONCE";
    const META_KEY = "toro_rm_steps";
    
    private $recipe_post_Type_id = null;
    
    function __construct($recipe_post_Type_id) {
        $this->recipe_post_Type_id = $recipe_post_Type_id;
    }
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'create_meta_box'));
        add_action('save_post', array($this, 'save_steps'), 10, 2 );
    }
    
    function create_meta_box() {
        if($this->recipe_post_Type_id === null) {
            return;
        }
        add_meta_box(self::META_BOX_ID, self::META_BOX_HEADER, 
                array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'low');
    }
    
    function save_steps($post_id, $post) {
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
        $steps = (isset($_POST['toro_rm_steps']) ? sanitize_html_class($_POST['toro_rm_steps']) : '');
        if(count($steps) <= 0) {
            return $post_id;
        }
        
        // Get the meta value of the custom field key
        $meta_value = get_post_meta($post_id, self::META_KEY, true);
        
        // Create DOM document
        $dom = new DOMDocument('1.0', 'utf-8');
        $root = $dom->createElement('steps');
        $dom->appendChild($root);
        
        for($i = 0; $i < count($steps); $i++) {
            $step = $steps[$i];
            $root->appendChild($dom->createElement('step', $step));
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
        //$meta_value = '';
        
        echo wp_nonce_field(basename(__FILE__), self::META_BOX_NONCE);
        echo '<div id="steps_wrapper">';
        
        if($meta_value != '') {
            $xml = simplexml_load_string($meta_value);
            foreach($xml->step as $step) {
                echo '<div class="step_wrapper">';
                echo '<div><textarea rows="2" cols="50" name="toro_rm_steps[]">' . $step . '</textarea></div>';
                echo '<div><a href="#" class="remove_step_link">Remove</a><span class="step_up_button_separator">|</span><a href="#" class="step_up_link">Up</a><span class="step_down_button_separator">|</span><a href="#" class="step_down_link">Down</a></div>';
                echo '<hr>';
                echo '</div>';
            }
        }
        
        echo '</div>';
        echo '<div><button id="add_step_button">Add</button></div>';
    }
    
}
