jQuery(document).ready(function($) {
    var index = 0;
    
    $("#add_ingredient_button").click(function(e){
        e.preventDefault();
        var ingredientWrapper = 
            '<div class="ingredient_wrapper">' +
            '<div><input type="text" name="ingredient_amounts[]" value="' + index + '" /><input type="text" name="ingredient_units[]" /><input type="text" name="ingredients[]" /></div>' +
            '<div><a href="#" class="remove_link">Remove</a><span class="ingredient_up_button_separator">|</span><a href="#" class="up_link">Up</a><span class="ingredient_down_button_separator">|</span><a href="#" class="down_link">Down</a></div>' +
            '<hr>' +
            '</div>';
        $("#ingredients_wrapper").append(ingredientWrapper);
        index++;
    });
    
    $(".remove_link").live('click', function(e){
        e.preventDefault();
        $(this).closest(".ingredient_wrapper").remove();
        index--;
    });
    
    $(".up_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".ingredient_wrapper");
        parent.insertBefore(parent.prev());
    });
    
    $(".down_link").live('click', function(e){
        e.preventDefault();
        var parent = $(this).closest(".ingredient_wrapper");
        parent.insertAfter(parent.next());
    });
})
