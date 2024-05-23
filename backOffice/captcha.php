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

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/captcha.css">

                        <!-- SORT CSS & JS -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Captcha</title>
</head>
<body>

<?php  include('../includes/navbar_back.php');
           include('../includes/db.php');   
    ?>

<div class = "captchas"> 

    <div class = "container-header">
    <h1>CAPTCHA</h1>
    <a href="addCaptcha.php">AJOUTER +</a>
    </div>

    <?php include('scripts/php/message.php'); ?>

    <div class ="table-container">
    <table class = "tab">
        <thead>
        <tr> 
          <th onclick="sortTable(0)">question <span class="arrow0 inactive"></span></th>   
          <th onclick="sortTable(1)">réponse <span class="arrow1 inactive"></span></th>    
          <th>gérer</th>   
        </tr>
        </thead>
    </div>
    <tbody>

    <?php

        $getAllCaptchas = "SELECT id_captcha, questions, goodAnswer FROM CAPTCHA ORDER BY id_captcha DESC;";

    $req = $pdo->prepare($getAllCaptchas);
    $req->execute();
    $results = $req->fetchAll(); 

    if (!empty($results)){
        for ($i = 0; $i < count($results); $i++): 
    ?> 

<tr id = "">
            <td class="tabElem"><?php echo $results[$i]["questions"]; ?></td>
            <td class="tabElem"><?php echo $results[$i]["goodAnswer"]; ?></td>
            <td class="tabElem">
                <a href="editCaptcha.php?id_captcha=<?php echo $results[$i]["id_captcha"]; ?>" class="updateButton"><span class="material-symbols-outlined">edit</span></a>
                
            </td>
        </tr>
    <?php 
        endfor;
    } 

    ?>
    </tbody>

</div>

</body>
</html>