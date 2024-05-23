<?php 
include('db.php');

$q = "SELECT COUNT(*) AS $alias FROM $tableName";

$req = $pdo->prepare($q); 

$req->execute();            

$results = $req->fetch(PDO::FETCH_ASSOC);

?>