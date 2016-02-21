<?php

class ToRo_RM_Ingredients_Meta_Box {
    
    const META_BOX_ID = "INGREDIENTS_META_BOX";
    const META_BOX_HEADER = "Ingredients";
    
    private $recipe_post_Type_id = null;
    
    function __construct($recipe_post_Type_id) {
        $this->recipe_post_Type_id = $recipe_post_Type_id;
    }
    
    public function init() {
        add_action('add_meta_boxes', array($this, 'create_meta_box'));
    }
    
    function create_meta_box() {
        if($this->recipe_post_Type_id === null) {
            return;
        }
        add_meta_box(self::META_BOX_ID, self::META_BOX_HEADER, 
                array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'default');
    }
    
    function draw() {
        echo '<button id="my_button">Add</button>';
    }
    
}
