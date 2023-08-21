$(document).ready(initialisePage);

let added=[];

function initialisePage()
{
    $("div#ajaxsearch input").keyup(handleInput);
    $("div#searchForIngr").keyup(handleIngr);
    $("div#ajaxsearch datalist").keyup();
    $("#cart_btn").click(showCart);
    $(".cart_close_btn").click(closeCart);
    $(".update_btn").click(searchById);
    $("#filter_btn").click(showForm);
    $("#add_btn").click(showAdd);
    $("#add_close_btn").click(closeAdd);
    $("#upd_close_btn").click(closeUpd);
    $("#formlog").on('submit', function(){
      alert("Your data has been successfully sumbitted. Expect a letter regarding further action.");
      return true;
    });
    $(".updateForm").on('click', '.add_item', function() {
      var newline1 = $('<div>Ingredient <input name="ingr[]" type="text"/><a href="#" class="remove_field">Remove</a></div>');
      newline1.find("a").click(function(e) {
        e.preventDefault();
        $(this).parent().remove();
      });
      $('.add_ingr').append(newline1);
    });
}

function handleInput()
{
  var search = $("div#ajaxsearch input").val().trim();
  if (search != "")
  {
    $.get("../model/getRecipes_service.php?recipe_name="+search,searchCallback);
  }
  else // if search IS empty
  {
    $("div#ajaxsearch div.results").hide();
  }
}

function handleIngr(){
  var search = $("div#searchForIngr input").val().trim();
  if (search != "")
  {
    $.get("../model/getIngredients_service.php?ingredient_name="+search,searchCallbackIngr);
  }
  else // if search IS empty
  {
    $("div#searchForIngr div.results").hide();
  }

}

function searchCallbackIngr(results){
    $("div#searchForIngr div.results").empty();
    for (var i=0;i<results.length; i++){
      if (!added.includes(results[i])){
      var result = $('<div><input class="result" type="checkbox" name="result_ingr[]">'+results[i]+'</div>');
      }else{
        var result = $('<div><input checked class="result" type="checkbox" name="result_ingr[]">'+results[i]+'</div>');
      }
      $(result).change(function(){
        var ingr=$(this).text();
        $(result).find('checked').change(function(){

        })
        //check if ingr is picked
        if (!added.includes(ingr)){
        added.push(ingr);
        var newline = $('<div><input  checked class="added_ingr" type="checkbox" value='+ingr+ ' name="added_ingr[]"><label>'+ingr+"</label></input></div>"); 
        // trigger for checkbox and delete from added
        $(newline).find('input').change(function(){
          const index = added.indexOf(ingr);
          if (index>-1){
            added.splice(index,1);
          }
          $(this).parent("div").remove();
        });

        $(".container_ingr").append(newline);
        }else{
          //deleting by ticking in searchlist
          const index = added.indexOf(ingr);
          if (index>-1){
            added.splice(index,1);
          }
          $('input.added_ingr[value='+ingr+']:checked').parent('div').remove();
        }
      })
      $("div#searchForIngr div.results").append(result);
    }
    if (results.length==0)
    {
      $("div#searchForIngr div.results").hide();
    }
    else
    {
      $("div#searchForIngr div.results").show();
    }

}

function searchCallback(results)
{
    console.log(results);
    $("div#ajaxsearch div.results").empty();
    for (var i=0;i<results.length; i++){
      var result = $('<div class="result">'+results[i]+"</div>");
      result.click(function(){
        $("div#ajaxsearch div.results").hide();
        $("input[name=searchname]").val($(this).text());
        $("form").get(0).submit();
      })
      $("div#ajaxsearch div.results").append(result);
    }
    if (results.length==0)
    {
      $("div#ajaxsearch div.results").hide();
    }
    else
    {
      $("div#ajaxsearch div.results").show();
    }
}

function ajaxSearch(){
  var search = $()
}

function showCart(){
  $('#modalPopup').modal('show')
}

function closeCart(){
  $('#modalPopup').modal('hide')
}
function showForm(){
  $("#filter-form").toggle();
}
function showAdd(){
  $("#modalPopupAdd").modal('show');
}
function closeAdd(){
  $('#modalPopupAdd').modal('hide');
}
function closeUpd(){
  $('#modalPopupUpd').modal('hide');
}
function searchById(){
  var search = $(this).closest('tr').find('td div.id').text();
  $("#modalPopupUpd").modal('show');

  $.get("../model/getRecipeById_service.php?id=" + search, function(results){
    $.get("../model/getAllRestrictions_service.php", function(restrictions){
        searchByIdCallback(results,restrictions);
    })
  });
  }


function searchByIdCallback(results, restrictions){
    $(".updateForm").empty();

      var recipe = results;
      var newline = $("<div></div");
      var ingr_array= recipe.ingredient_name.split(',');
      var restr = recipe.restriction.split(',');
      var deleted_ingr= new Array();

      newline.append("<input type='hidden' name=id value="+recipe.id+">");
      newline.append("<P> Name <input class='inputForm' name='recipe_name' value='"+recipe.recipe_name+"'>");



      newline.append("<div class='add_ingr'>");
      for(var i=0;i<ingr_array.length;i++){
        newline.append("<p> Ingredient <input name = 'ingr[]' class='inputForm' value='"+ingr_array[i]+"'><a href='#' class='remove_field' data-value='"+ingr_array[i]+"'>Remove</a>");
      };
      newline.find("a").click(function(e){
        e.preventDefault();
        deleted_ingr.push($(this).data('value'));
        $(this).parent().remove();
      }); 
      newline.append('<button type = "button" class="add_item">Add new ingredient</button>');
      


      console.log(newline);
      newline.append("</div><p> Restrictions");
      for(var i=0;i<restrictions.length;i++){
        var check = false;
        for(var j=0;j<restr.length;j++){
          if (restrictions[i].includes(restr[j])){
              check= true;
          }
        }
        if(check){
          newline.append("<input checked type='checkbox' name='restr[]' value="+restrictions[i]+">"+restrictions[i]);
        }
        else{
          newline.append("<input type='checkbox' name='restr[]' value="+restrictions[i]+">"+restrictions[i]);
        }
      }
      newline.append("<P> Recipe instruction <textarea name='text' class='inputForm'>"+recipe.recipeText+"</textarea>");


      newline.append("<P> Time for cooking <input name='time' class='inputForm' value="+recipe.cookingTime+">");
      newline.append("<P> Img <input name='img' class='inputForm' value="+recipe.img+">");
      newline.append("<button type='submit' name='saveChanges'>Save</button>")
      
      $(".updateForm").append(newline);
}




