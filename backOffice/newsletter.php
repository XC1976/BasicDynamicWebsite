<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/newsletter.css">

    <!-- SORT CSS & JS -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Document</title>
</head>
<body>

<?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

<main>

<div class = "container-header">
    <h1>NEWSLETTER</h1>
    <a href="addNewsletter.php">AJOUTER +</a>
    <a href="historyNewsletter.php">HISTORIQUE</a>
    </div>

    <div class="allNewsletters">

    <?php include('scripts/php/message.php'); ?>

    <div class = "table-container"> 
    <table class = "tab">
        <thead>
        <tr> 
        <th onclick="sortTable(0)">numéro <span class="arrow0 inactive"></span></th>  
          <th onclick="sortTable(1)">sujet <span class="arrow1 inactive"></span></th> 
          <th>gérer</th>    
        </tr>
        </thead>
        <tbody>

    <?php

    $getAllNewsletters = "SELECT id_nl, subject FROM NEWSLETTER;";
    
    $req = $pdo->prepare($getAllNewsletters);
    $req->execute();
    $newsletters = $req->fetchAll();      
    
    if (!empty($newsletters)){
        foreach ($newsletters as $newsletter):
    ?> 
        <tr>
            <td class="tabElem"><?php echo $newsletter["id_nl"];?></td>
            <td class="tabElem"><?php echo $newsletter["subject"];?></td>
            <td class="tabElem">
                <a href = "editNewsletter.php?id_nl=<?php echo $newsletter["id_nl"];?>" class="updateButton"><span class="material-symbols-outlined">edit</span></a>
                
            </td>
        </tr>
    <?php 
        endforeach;
    } 

    ?>

</tbody>

    </div>
</div>

</main>
    
</body>
</html>