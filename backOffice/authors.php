<?php 
include 'scripts/php/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php');?>

             <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/users.css">

             <!-- SORT CSS & JS -->

     <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Authors</title>
    
</head>

<body>
     <!-- DB AND NAV INCLUDES  -->
<?php  
    include('../includes/navbar_back.php');
    include('../includes/db.php');   
?>

<main>


<div class ="users">
    <div class = "title-container">
        <h1>AUTEURS</h1>
        <a href="addAuthor.php">AJOUTER +</a>
    </div>

    <?php include('scripts/php/message.php'); ?>

    <div class = "table-container"> 
    <table class = "tab">
        <thead>
        <tr> 
          <th onclick="sortTable(0)">prénom <span class="arrow0 inactive"></span></th>  
          <th onclick="sortTable(1)">nom <span class="arrow1 inactive"></span></th>  
          <th>gérer</th>   
        </tr>
        </thead>
        <tbody>

         <!-- FETCHING THE ROWS FROM DB  -->
        <?php

        $getAllAuthors = "SELECT id_author, name, lastname FROM AUTHOR;";

    $req = $pdo->prepare($getAllAuthors);
    $req->execute();
    $results = $req->fetchAll(); 

    if (!empty($results)){
        for ($i = 0; $i < count($results); $i++): 
    ?> 

        <tr>
            <td class="tabElem"><?php echo $results[$i]["name"]; ?></td>
            <td class="tabElem"><?php echo $results[$i]["lastname"]; ?></td>
            <td class="tabElem">
                <a href = "editAuthor.php?id_author=<?php echo $results[$i]["id_author"]; ?>" class="updateButton"><span class="material-symbols-outlined">edit</span></a>
                
            </td>
        </tr>
    <?php 
        endfor;
    } 

    ?>
    </tbody>
    </div>
</div>

</main>



    
</body>
</html>