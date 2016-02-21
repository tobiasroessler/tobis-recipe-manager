<?php

class ToRo_RM_Recipe_Details_Meta_Box {
    
    const META_BOX_ID = "RECIPE_DETAILS_META_BOX";
    const META_BOX_HEADER = "Recipe details";
    
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
                array($this, 'draw'), $this->recipe_post_Type_id, 'normal', 'high');
    }
    
    function draw() {
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="amount" class="toro_rm_label_general">Amount</label></div>';
        echo '<input id="amount" type="text" size="4" maxlength="4" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Person(s)</span>';
        echo '</div><hr>';
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="preperation_time" class="toro_rm_label_general">Preperation time</label></div>';
        echo '<input id="preperation_time" type="text" size="4" maxlength="3" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Minute(s)</span>';
        echo '</div><hr>';
        echo '<div>';
        echo '<div class="toro_rm_recipe_label_div"><label for="cooking_time" class="toro_rm_label_general">Cooking time</label></div>';
        echo '<input id="cooking_time" type="text" size="4" maxlength="3" class="toro_rm_recipe_details_input"></input>';
        echo '<span>Minute(s)</span>';
        echo '</div>';
    }
    
}
