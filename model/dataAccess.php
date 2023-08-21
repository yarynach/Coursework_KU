<?php
$pdo = new PDO("mysql:host=localhost;dbname=db_k2289903",
"k2289903",
"",
[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

function getAllRecipes(){
    global $pdo;
    $statement=$pdo->prepare("SELECT rec.id, rec.recipe_name,  GROUP_CONCAT(DISTINCT Dietary_restrictions.diet_restriction SEPARATOR ',') as restriction, rec.cooking_time as cookingTime,  GROUP_CONCAT( DISTINCT Ingredients.ingredient_name SEPARATOR ',') as ingredient_name, rec.recipe_text as recipeText, rec.img as img FROM Recipe as rec 
    INNER JOIN Recipe_ingredients
    ON rec.id=Recipe_ingredients.id_rec
    INNER JOIN Ingredients
    ON Recipe_ingredients.id_ingr=Ingredients.id
    INNER JOIN Dietary_restrictions_records as dr
    ON rec.id=dr.id_rec
    INNER JOIN Dietary_restrictions 
    ON Dietary_restrictions.id=dr.id_restr
    GROUP BY rec.id, rec.recipe_name, rec.recipe_text, rec.img");
$statement->execute();
$results=$statement->fetchAll(PDO::FETCH_CLASS,"Recipe");
return $results;
}


function addRecipe($recipe){
    global $pdo;

    $statement=$pdo->prepare(" INSERT INTO Ingredients(ingredient_name)
                              SELECT ? FROM DUAL
                              WHERE NOT EXISTS (SELECT ingredient_name FROM Ingredients
                              WHERE ingredient_name=? LIMIT 1)");
    foreach($recipe->ingredient_name as $value){
        $statement->execute([$value, $value]);
    }
   

    $statement=$pdo->prepare("INSERT INTO Recipe(recipe_name,cooking_time,recipe_text,img) VALUES (?,?,?,?)");
    $statement->execute([$recipe->recipe_name,$recipe->cookingTime,$recipe->recipeText, $recipe->img]);

    $recipe->id=$pdo->query("SELECT last_insert_id()")->fetchColumn();
    $statement=$pdo->prepare(" INSERT INTO Recipe_ingredients(id_rec,id_ingr)
                                VALUES(?,(SELECT id FROM Ingredients WHERE ingredient_name=?))");
    for($i=0;$i<sizeof($recipe->ingredient_name);$i++){
        $statement->execute([$recipe->id,$recipe->ingredient_name[$i]]);
    }

    $statement=$pdo->prepare("INSERT INTO Dietary_restrictions_records(id_rec, id_restr)
                            VALUES(?,(SELECT id FROM Dietary_restrictions WHERE diet_restriction=?))");
    for($i=0;$i<sizeof($recipe->restriction);$i++){
        $statement->execute([$recipe->id,$recipe->restriction[$i]]);
    }

}


function getRecipeByStart($name)
{
    global $pdo;
    $statement=$pdo->prepare("SELECT DISTINCT recipe_name FROM Recipe WHERE recipe_name LIKE ?");
    $statement->execute(["$name%"]);
    $recipes=$statement->fetchAll(PDO::FETCH_COLUMN,0);
    return $recipes;
    
}

function getIngredientByStart($name){
    global $pdo;
    $statement=$pdo->prepare("SELECT DISTINCT ingredient_name FROM Ingredients WHERE ingredient_name LIKE ?");
    $statement->execute(["$name%"]);
    $ingredients=$statement->fetchAll(PDO::FETCH_COLUMN,0);
    return $ingredients;
}
function getRecipeByName($name){
    global $pdo;
    $statement=$pdo->prepare(" SELECT rec.id, rec.recipe_name,  GROUP_CONCAT(DISTINCT Dietary_restrictions.diet_restriction SEPARATOR ',') as restriction, rec.cooking_time as cookingTime,  GROUP_CONCAT( DISTINCT Ingredients.ingredient_name SEPARATOR ',') as ingredient_name, rec.recipe_text as recipeText, rec.img as img FROM Recipe as rec 
    INNER JOIN Recipe_ingredients
    ON rec.id=Recipe_ingredients.id_rec
    INNER JOIN Ingredients
    ON Recipe_ingredients.id_ingr=Ingredients.id
    INNER JOIN Dietary_restrictions_records as dr
    ON rec.id=dr.id_rec
    INNER JOIN Dietary_restrictions 
    ON Dietary_restrictions.id=dr.id_restr
    WHERE rec.recipe_name=?
    GROUP BY rec.id, rec.recipe_name, rec.recipe_text, rec.img");
    $statement->execute([$name]);
    $recipes=$statement->fetchAll(PDO::FETCH_CLASS,"Recipe");
    return $recipes;
}
function getAllRestrictions(){

    global $pdo;
    $statement=$pdo->prepare("SELECT diet_restriction FROM Dietary_restrictions");
    $statement->execute();
    $restrictions=$statement->fetchAll(PDO::FETCH_COLUMN,0);
    return $restrictions;

}

function getRecipeById($id){
    global $pdo;
    $statement=$pdo->prepare(" SELECT rec.id, rec.recipe_name,  GROUP_CONCAT(DISTINCT Dietary_restrictions.diet_restriction SEPARATOR ',') as restriction, rec.cooking_time as cookingTime,  GROUP_CONCAT( DISTINCT Ingredients.ingredient_name SEPARATOR ',') as ingredient_name, rec.recipe_text as recipeText, rec.img as img FROM Recipe as rec 
    INNER JOIN Recipe_ingredients
    ON rec.id=Recipe_ingredients.id_rec
    INNER JOIN Ingredients
    ON Recipe_ingredients.id_ingr=Ingredients.id
    INNER JOIN Dietary_restrictions_records as dr
    ON rec.id=dr.id_rec
    INNER JOIN Dietary_restrictions 
    ON Dietary_restrictions.id=dr.id_restr
    WHERE rec.id=?
    GROUP BY rec.id, rec.recipe_name, rec.recipe_text, rec.img");
    $statement->execute([$id]);
    $recipes=$statement->fetchAll(PDO::FETCH_CLASS,"Recipe");
    return $recipes[0];
}
function getAllIngredients(){
    global $pdo;
    $statement=$pdo->prepare("SELECT ingredient_name FROM Ingredients");
    $statement->execute();
    $ingr=$statement->fetchAll(PDO::FETCH_COLUMN,0);
    return $ingr;
}

function getByIngredients($ingr){
    global $pdo;
    $separator=str_repeat('?,',count($ingr)-1) . '?';
    $statement=$pdo->prepare(" SELECT rec.id, rec.recipe_name,  GROUP_CONCAT(DISTINCT Dietary_restrictions.diet_restriction SEPARATOR ',') as restriction, rec.cooking_time as cookingTime,  GROUP_CONCAT( DISTINCT Ingredients.ingredient_name SEPARATOR ',') as ingredient_name, rec.recipe_text as recipeText, rec.img as img FROM Recipe as rec 
    INNER JOIN Recipe_ingredients
    ON rec.id=Recipe_ingredients.id_rec
    INNER JOIN Ingredients
    ON Recipe_ingredients.id_ingr=Ingredients.id
    INNER JOIN Dietary_restrictions_records as dr
    ON rec.id=dr.id_rec
    INNER JOIN Dietary_restrictions 
    ON Dietary_restrictions.id=dr.id_restr
    WHERE Ingredients.ingredient_name IN ($separator)
    GROUP BY rec.id, rec.recipe_name, rec.recipe_text, rec.img");
    $statement->execute($ingr);
    $recipes=$statement->fetchAll(PDO::FETCH_CLASS,"Recipe");
    return $recipes;
}




function getByFilters($restr, $ingr,$cooking_time,$keyword){
    global $pdo;
    $restrArray = $restr;
    $ingrArray = $ingr;
    $statement = "CREATE OR REPLACE VIEW recipe_view AS
    SELECT rec.id, rec.recipe_name, GROUP_CONCAT(DISTINCT dr.diet_restriction SEPARATOR ',') AS restriction, rec.cooking_time AS cookingTime, GROUP_CONCAT(DISTINCT Ingredients.ingredient_name SEPARATOR ',') AS ingredient_name, rec.recipe_text AS recipeText, rec.img AS img
    FROM Recipe AS rec
    INNER JOIN Recipe_ingredients ON rec.id = Recipe_ingredients.id_rec
    INNER JOIN Ingredients ON Recipe_ingredients.id_ingr = Ingredients.id
    INNER JOIN Dietary_restrictions_records AS drr ON rec.id = drr.id_rec
    INNER JOIN Dietary_restrictions AS dr ON drr.id_restr = dr.id
    GROUP BY rec.id, rec.recipe_name, rec.recipe_text, rec.img";
    $statement = $pdo->prepare($statement);
    $statement->execute();
    $statement = "SELECT * FROM recipe_view WHERE id>0";

    if (!empty($restr)){
        $paramRestr = array();
        foreach ($restrArray as $index => $restriction) {
            $paramRestr = ":param_restr{$index}";
            $paramRestrictions[] = $paramRestr;
            $statement .= " AND restriction LIKE {$paramRestr}";
        }
        
    }

    if (!empty($ingr)){
        $paramIngredients = array();
        foreach ($ingrArray as $index => $ingredient) {
            $paramIngr = ":param_ingr{$index}";
            $paramIngredients[] = $paramIngr;
            $statement .= " AND ingredient_name LIKE {$paramIngr}";
        }
    }
    if (!empty($cooking_time)){
        $paramTime=":param_time";
        $statement.= " AND cookingTime<={$paramTime}";
    }
    if (!empty($keyword)){
        $paramKeyword=":param_keyword";
        $statement.= " AND recipeText LIKE {$paramKeyword}";
    }


    $statement = $pdo->prepare($statement);
    if (!empty($restr)){
        foreach ($restrArray as $index => $restriction) {
            $restr = "%".$restriction."%";
            $paramRestr = $paramRestrictions[$index];
            $statement->bindValue($paramRestr, $restr, PDO::PARAM_STR);
        } 
    }
    if (!empty($ingr)){
        foreach ($ingrArray as $index => $ingredient) {
            $ingr = "%".$ingredient."%";
            $paramIngr = $paramIngredients[$index];
            $statement->bindValue($paramIngr, $ingr, PDO::PARAM_STR);
        } 
    }
    if (!empty($keyword)){
            $keyword = "%".$keyword."%";
            $statement->bindValue($paramKeyword, $keyword, PDO::PARAM_STR);
    }
    if (!empty($cooking_time)){
        $time = $cooking_time;
        $statement->bindValue($paramTime, $time, PDO::PARAM_INT);
}
    $statement->execute();
    $recipes=$statement->fetchAll(PDO::FETCH_CLASS,"Recipe");
    return $recipes;


}

function updateName($id,$newValue){
    global $pdo;
    $statement=$pdo->prepare("UPDATE Recipe SET recipe_name=? WHERE id=?");
    $statement->execute([$newValue,$id]);
}

function deleteIngredients($id,$ingredient){
    global $pdo;
    $statement=$pdo->prepare("DELETE Recipe_ingredients 
    FROM Recipe_ingredients 
    JOIN Ingredients 
    ON Recipe_ingredients.id_ingr=Ingredients.id
    WHERE Ingredients.ingredient_name=? AND Recipe_ingredients.id_rec=?");
    $statement->execute([$ingredient,$id]);
}

function insertIngredients($id,$ingredients){
    global $pdo;

    $statement=$pdo->prepare(" INSERT INTO Ingredients(ingredient_name)
    SELECT ? FROM DUAL
    WHERE NOT EXISTS (SELECT ingredient_name FROM Ingredients
    WHERE ingredient_name=? LIMIT 1)");
    foreach($ingredients as $value){
        $statement->execute([$value, $value]);
    }

    $statement=$pdo->prepare(" INSERT INTO Recipe_ingredients(id_rec,id_ingr)
    VALUES(?,(SELECT id FROM Ingredients WHERE ingredient_name=?))");
    for($i=0;$i<sizeof($ingredients);$i++){
    $statement->execute([$id,$ingredients[$i]]);
    }
}

function insertRestrictions($id,$restrictions){
    global $pdo;
    $statement=$pdo->prepare("INSERT INTO Dietary_restrictions_records(id_rec, id_restr)
    VALUES(?,(SELECT id FROM Dietary_restrictions WHERE diet_restriction=?))");
    for($i=0;$i<sizeof($restrictions);$i++){
        $statement->execute([$id,$restrictions[$i]]);
    }
}
function deleteRestrictions($id,$restrictions){
    global $pdo;
    $statement=$pdo->prepare("DELETE Dietary_restrictions_records
    FROM Dietary_restrictions_records
    JOIN Dietary_restrictions
    ON Dietary_restrictions_records.id_restr=Dietary_restrictions.id
    WHERE Dietary_restrictions_records.id_rec=? AND Dietary_restrictions.diet_restriction=?");
    for($i=0;$i<sizeof($restrictions);$i++){
        $statement->execute([$id,$restrictions[$i]]);
    }
}

function updateRecipeText($id, $text){
    global $pdo;
    $statement=$pdo->prepare("UPDATE Recipe SET recipe_text=? WHERE id=?");
    $statement->execute([$text,$id]);
}

function updateCookingTime($id,$time){
    global $pdo;
    $statement=$pdo->prepare("UPDATE Recipe SET cooking_time=? WHERE id=?");
    $statement->execute([$time,$id]);
}
function updateImg($id,$link){
    global $pdo;
    $statement=$pdo->prepare("UPDATE Recipe SET img=? WHERE id=?");
    $statement->execute([$link,$id]);
}



//for login

function addUser($user){
    global $pdo;
    $statement=$pdo->prepare("INSERT INTO Users (username, user_type, password) VALUES (?, ?, ?)");
    $statement->execute([$user->username,$user->user_type,$user->password]);
    $result=$pdo->query("SELECT last_insert_id()")->fetchColumn();
    return $result;
}

function checkUsername($username){
    global $pdo;
    $statement=$pdo->prepare("SELECT COUNT(*) FROM Users WHERE username =?");
    $statement->execute($username);
    $result=$statement->fetchColumn();
    return $result;
}
function getUser($username,$password){
    global $pdo;
    $statement=$pdo->prepare("SELECT * FROM Users WHERE username=? AND password=?");
    $statement->execute([$username,$password]);
    $user=$statement->fetchAll(PDO::FETCH_CLASS,"User");
    return $user[0];
}

//order

function addOrder($id,$name,$address,$email){
    global $pdo;
    $statement=$pdo->prepare("INSERT INTO Orders(id_user,name_surname,address,email) VALUES(?,?,?,?)");
    $statement->execute([$id,$name,$address,$email]);
    $order_id=$pdo->query("SELECT last_insert_id()")->fetchColumn();
    return $order_id;
}

function addOrderDetail($id,$array){
    global $pdo;
    $statement=$pdo->prepare("INSERT INTO Order_details(id_order,id_recipe,quantity) VALUES(?,?,?)");
    foreach($array as $key=>$value){
        $statement->execute([$id,$key,$value]);
    }

}
?>

