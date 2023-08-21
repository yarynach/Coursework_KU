<?php
require_once("../model/recipe.php");
require_once("../model/dataAccess.php");
session_start();


if (isAdmin()){
    if(isset($_REQUEST["add_recipe"])){
        $recipe_name=$_REQUEST["recipe_name"];
        if(isset($_REQUEST["restr"])){
            $restr=$_REQUEST["restr"];
        }else{
            $restr[0]="No restriction";
        }
        
        $time=$_REQUEST["time"];
        $text=$_REQUEST["text"];
        $ingredient_name=$_REQUEST["ingr"];
        $img=$_REQUEST["img"];
        $newRecipe = new Recipe;
        $newRecipe->makeRecipe($recipe_name,$restr,$time,$ingredient_name,$text,$img);
        addRecipe($newRecipe);
    }
    //  for viewing checkboxes with restr
    $restrictions=getAllRestrictions();

    if(isset($_REQUEST["saveChanges"])){
        if(!isset($_REQUEST["id"])){
        }
        else{
            $id=$_REQUEST["id"];
            $old=getRecipeById($id);
            $recipe_name=$_REQUEST["recipe_name"];
            if(isset($_REQUEST["restr"])){
                $restr=$_REQUEST["restr"];
            }else{
                $restr[0]="No restriction";
            }
            $time=$_REQUEST["time"];
            $text=$_REQUEST["text"];
            $ingredient_name=$_REQUEST["ingr"];
            $img=$_REQUEST["img"];
            $new = new Recipe;
            $new->makeRecipe($recipe_name,$restr,$time,$ingredient_name,$text,$img);
            $new->id=$id;
            $added_ingr=array();
            $deleted_ingr=array();
            $added_restr=array();
            $deleted_restr=array();


            if ($new->recipe_name!=$old->recipe_name){
                updateName($id,$recipe_name);
            }



            $old_ingr=explode(",",$old->ingredient_name);
            // search for deleted ingredients
            for( $i=0;$i<count($old_ingr);$i++){
                //case sensitive
                if(!in_array($old_ingr[$i],$ingredient_name)){
                    $deleted_ingr[]=$old_ingr[$i];
                }
            }
            //search for added indgredients
            for( $i=0;$i<count($ingredient_name);$i++){
                //case sensitive
                if(!in_array($ingredient_name[$i],$old_ingr)){
                    $added_ingr[]=$ingredient_name[$i];
                }
            }
            //insertIngredients($new); // не добавляти однакові елементи в таблицю
            //порівнювати присутність відсутність і на основі цього видаляти
            if(count($deleted_ingr)>0){
                foreach($deleted_ingr as $ingr){
                    deleteIngredients($id,$ingr);
                }
            }
            if(count($added_ingr)>0){
                    insertIngredients($id,$added_ingr);
            }

            //restrictions
            $old_restr=explode(",",$old->restriction);
            for( $i=0;$i<count($old_restr);$i++){
                //case sensitive
                if(!in_array($old_restr[$i],$restr)){
                    $deleted_restr[]=$old_restr[$i];
                }
            }
            for( $i=0;$i<count($restr);$i++){
                //case sensitive
                if(!in_array($restr[$i],$old_restr)){
                    $added_restr[]=$restr[$i];
                }
            }
            if(count($added_restr)>0){
                insertRestrictions($id,$added_restr);
            }
            if(count($deleted_restr)>0){
                deleteRestrictions($id,$deleted_restr);
            }

            //text
            if ($new->recipeText!=$old->recipeText){
                updateRecipeText($id,$recipe_name);
            }
            //cooking time
            if ($new->cookingTime!=$old->cookingTime){
                updateCookingTime($id,$time);
            }
            //img
            if ($new->img!=$old->img){
                updateImg($id,$img); //добавити валідацію на лінку
            }

        }

    }
    if(isset($_REQUEST["searchname"]) && $_REQUEST["searchname"] != ""){
        $name=$_REQUEST["searchname"];
        $results=getRecipeByName($name);
    }else{
        $results = getAllRecipes();
    }


    if(isset($_REQUEST['logout_btn'])){
        session_destroy();
        unset($_SESSION['user']);
        header("location: login_controller.php");
    }

    require_once("../view/admin_page.php");
}
else{
    header("location: ../view/restricted.php");
}



function isAdmin()
{
	if (isset($_SESSION['user']) && isset($_SESSION['user']['user_type'])  && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

?>