
$(document).ready(function(){
    // for add ingr
    var d_add = $(".add_ingr");
    var add_button = $(".add_item");

    $(add_button).click(function(e){
        e.preventDefault();
        var newline = $('<div>Ingredient <input name = "ingr[]" type="text"/><a href="#" class="remove_field">Remove</a></div>'); 
        newline.find("a").click(function(){
            $(this).parent().remove();
        });
        $(d_add).append(newline);
    });


});

