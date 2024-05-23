<?php

ini_set('display_errors',1); 

include('../includes/db.php'); 

$q = "SELECT id_genre as id, name FROM GENRE;";


$req = $pdo->prepare($q);

$success = $req->execute([
]);

if($success) {
    $options = $req->fetchAll(PDO::FETCH_ASSOC);
    foreach ($options as $option) { ?>

        <option value="<?php echo $option['id']?>"><?php echo $option['name'];?></option>
        
        <?php
}
}
?>
