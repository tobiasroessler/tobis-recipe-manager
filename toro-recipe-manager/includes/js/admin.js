jQuery(document).ready(function($) {
    var index = 0;
    
    $("#add_ingredient_button").click(function(e){
        e.preventDefault();
        var ingredientWrapper = 
            '<div class="ingredient_wrapper">' +
            '<div><input type="text" name="toro_rm_ingredient_amounts[]" value="' + index + '" /><input type="text" name="toro_rm_ingredient_units[]" /><input type="text" name="toro_rm_ingredients[]" /></div>' +
            '<div><a href="#" class="remove_ingredient_link">Remove</a><span class="ingredient_up_button_separator">|</span><a href="#" class="ingredient_up_link">Up</a><span class="ingredient_down_button_separator">|</span><a href="#" class="ingredient_down_link">Down</a></div>' +
            '<hr>' +
            '</div>';
        $("#ingredients_wrapper").append(ingredientWrapper);
        index++;
    });
    
    $(".remove_ingredient_link").live('click', function(e){
        e.preventDefault();
        $(this).closest(".ingredient_wrapper").remove();
        index--;
    });
    
    $(".ingredient_up_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".ingredient_wrapper");
        parent.insertBefore(parent.prev());
    });
    
    $(".ingredient_down_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".ingredient_wrapper");
        parent.insertAfter(parent.next());
    });
    
    $("#add_step_button").click(function(e){
        e.preventDefault();
        var stepWrapper = 
            '<div class="step_wrapper">' +
            '<div><textarea rows="2" cols="50" name="toro_rm_steps[]" value="' + index + '" /></div>' +
            '<div><a href="#" class="remove_step_link">Remove</a><span class="step_up_button_separator">|</span><a href="#" class="step_up_link">Up</a><span class="step_down_button_separator">|</span><a href="#" class="step_down_link">Down</a></div>' +
            '<hr>' +
            '</div>';
        $("#steps_wrapper").append(stepWrapper);
        index++;
    });
    
    $(".remove_step_link").live('click', function(e){
        e.preventDefault();
        $(this).closest(".step_wrapper").remove();
        index--;
    });
    
    $(".step_up_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".step_wrapper");
        parent.insertBefore(parent.prev());
    });
    
    $(".step_down_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".step_wrapper");
        parent.insertAfter(parent.next());
    });
})
