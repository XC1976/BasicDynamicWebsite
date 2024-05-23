<?php include 'scripts/php/init.php'; ?>

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

    <title>Forum</title>
</head>
<body>

<?php
       include('../includes/navbar_back.php');
       include('../includes/db.php');   
?>

<main>


<div class ="users">
    <div class = "title-container">
        <h1>CATÉGORIES DE DISCUSSIONS</h1>
        <a href="banWords.php">BAN WORDS</a>
        <a href="newCat.php">NOUVELLE CATEGORIE</a>
    </div>

    <?php include('scripts/php/message.php'); ?>

    <div class = "table-container"> 
    <table class = "tab">
        <thead>
        <tr> 
          <th onclick="sortTable(0)">catégorie <span class="arrow0 inactive"></span></th> 
          <th onclick="sortTable(1)">section <span class="arrow1 inactive"></span></th>
          <th onclick="sortTable(2)">nombres de discussions <span class="arrow2 inactive"></span></th> 
          <th>gérer</th>   
        </tr>
        </thead>
        <tbody>

         <!-- FETCHING THE ROWS FROM DB  -->
        <?php

        $getAllCategories = "SELECT 
        dc.code_categorie as id_cat,
        dc.name AS nom_cat,
        dc.parent_categorie AS parent_cat,
        COUNT(d.id_discussion) AS nombre_discus
    FROM 
        DISCUSSION_CATEGORIE dc
    LEFT JOIN 
        DISCUSSION d ON dc.code_categorie = d.categorie
    GROUP BY 
        dc.code_categorie, dc.name, dc.parent_categorie
    ORDER BY 
        dc.code_categorie;
    
    
    ";

    $req = $pdo->prepare($getAllCategories);
    $req->execute();
    $results = $req->fetchAll(); 

    if (!empty($results)){
        for ($i = 0; $i < count($results); $i++): 
    ?> 

        <tr>
            <td class="tabElem"><?php echo $results[$i]["nom_cat"];?></td>
            <td class="tabElem"><?php echo $results[$i]["parent_cat"];?></td>
            <td class="tabElem"><?php echo $results[$i]["nombre_discus"]; ?></td>
            <td class="tabElem">
                <a href = "editCat.php?id_cat=<?php echo $results[$i]["id_cat"]; ?>" class="updateButton"><span class="material-symbols-outlined">edit</span></a>
                <a href = "seeDiscussions.php?id_cat=<?php echo $results[$i]["id_cat"]; ?>" class="updateButton"><span class="material-symbols-outlined">visibility</span></a>
                
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