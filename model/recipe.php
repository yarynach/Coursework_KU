<?php
class Recipe implements JsonSerializable{
    private $id;
    private $recipe_name;
    private $restriction;
    private $cookingTime;
    private $ingredient_name;
    private $recipeText;
    private $img;
    private $price;


    function makeRecipe($recipe_name, $restriction, $cookingTime, $ingredient_name, $recipeText, $img) {
        $this->recipe_name = $recipe_name;
        $this->restriction = $restriction;
        $this->cookingTime = $cookingTime;
        $this->ingredient_name = $ingredient_name;
        $this->recipeText = $recipeText;
        $this->img = $img;
    }

    function __get($name){
        return $this->$name;
    }
    function __set($name,$value){
        $this->$name = $value;
    }

    public function jsonSerialize(){
        return get_object_vars($this);
    }
}
?>