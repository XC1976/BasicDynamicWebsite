<?php 
include 'scripts/php/init.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/banWords.css">

    <!--  JS  -->
    <script src="scripts/js/banWords.js"></script>

    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">

    <title>Ban words</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
        include('../includes/popupDelete.php'); 
    ?>

    <main>
        <section id ="list">
        <div class= "title">
                <h1>LISTE DES MOTS</h1>
            </div>
            <?php 
             $getAllWords = "SELECT id__word, word FROM BAN_WORD;";

$req = $pdo->prepare($getAllWords);
$req->execute();
$words = $req->fetchAll(); 

if (!empty($words)){
    foreach ($words as $word):
?> 
<button type="button" id="<?php echo $word['id__word'];?>" class="btn" onclick="togglePopup(this.id)"><?php echo $word['word'];?></button>

<?php 
        endforeach;
    } else {
        echo 'pas de mots trouvés pour le moment.';
    }
    ?>
       </section>

       <!-- SECTION 2 ADD WORD -->
        <section id ="add">

            <div class= "title">
                <h1>AJOUTER UN MOT</h1>
            </div>
            <div class = "message">
            <?php include('scripts/php/message.php'); ?>
            </div>

            <div id= "form">
                <form method="post" id="center-box" action="scripts/php/verificationAddWord.php" enctype="multipart/form-data">

                <div class="inputRow">
                            <input type="text" id="inputWord" name="word" rows="10" cols="125" class ="input-zone" placeholder= "Saisissez votre mot ici">
                </div>

                <div id= "btn-container">
                    <button class="btn" type="submit">Enregistrer</button>
                </div>

                </form>
            </div>


        </section>









    </main>
    
</body>
</html>