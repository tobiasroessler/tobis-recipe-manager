<?php

class ToRo_RM_Steps_Meta_Box {
    
    const META_BOX_ID = "STEPS_META_BOX";
    const META_BOX_HEADER = "Steps";
    
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
                array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'low');
    }
    
    function draw() {
        echo 'Test';
    }
    
}
