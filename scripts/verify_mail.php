<?php
function redirectWithError($message) {
    header("Location: ../index.php?message=$message");
    $message = "";
    exit();
}
//------------------------------
// verification
$get_token = $_GET["token"];
$redirect = False;

if (strlen($get_token) < 50 || strlen($get_token) > 50) {
    $message = "Token Invalide";
    $redirect = True;
}

// email sanitization and validation
//bc we use it to query the database
$id_user = $_GET["id"];

// user id must me an integer
if (intval($id_user) == 0 && $id_user != "0") {
    $redirect = True;
}

if ($redirect == True ) {
    redirectWithError($message);
}

//----------------------------------
//check if token exist in the db

try {
    require_once "../includes/db.php";

    //-----------------------------
    //verify that the token exists

    $query = "SELECT token_value, expiration_date, token_type FROM TOKEN WHERE user=:id_user;";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_user", $id_user);
    $request->execute();

    $results = $request->fetchAll();
    
    //parsing
    $db_token = $results[0]["token_value"];
    $exp_date = $results[0]["expiration_date"];
    $token_type = $results[0]["token_type"];
    
    //verification de l'expiration
    $time_now = date("Y-m-d", time());
    
    //verification du token
    if ($token_type == "PASSWD" || // type du token 'ACCOUNT' ou 'PASSWD'
        $time_now > $exp_date ||   //expiration
        $db_token != $get_token ) { //valeur du token
        
        $message = "Token Invalide";
        redirectWithError($message);
    }

    //------------------------------------------
    // l'email est vérifiée, suppression du token

    $query = "UPDATE USER SET is_verified=1 WHERE id_user=:id_user; 
            
            DELETE FROM TOKEN WHERE(token_value=:token_value);
            
            DELETE FROM TOKEN WHERE(expiration_date<:time_now);";

    $request = $pdo->prepare($query);
    $request->bindParam(":id_user", $id_user);
    $request->bindParam(":token_value", $db_token);
    $request->bindParam(":time_now", $time_now);
    
    $request->execute();

    header("Location: ../index.php?show-login=true");
    exit();

} catch (PDOException $e) {
    die("Querry Failed : " . $e->getMessage());
}
