<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/editNewsletter.css">

    <!-- ACTION CHANGE JS  -->
    <script src="scripts/js/changeAction.js"></script>

    <title>Edit Newsletter</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  
            // id au bon format dans l'url 
            if (!isset($_GET['id_nl']) || !is_numeric($_GET['id_nl'])) { 
                header('location: newsletter.php?message=Identifiant invalide.');
                exit;
            } else {
                
                $q = 'SELECT id_nl, subject, paragraph01, paragraph02, paragraph03 FROM NEWSLETTER WHERE id_nl = :id;';
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id_nl']]);
                $newsletter = $req->fetch(PDO::FETCH_ASSOC);
                
                if (!$newsletter) { 
                    header('location: newsletter.php?message=Utilisateur introuvable.');
                    exit;
                } else {                  
                    include('scripts/php/message.php');
        ?>

        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>MODIFIER LA NEWSLETTER</h1>
                </div>
                <div class="form-container">
            
                    <form method="post" action="" id="Form" enctype="multipart/form-data">
                     
                    <div class="info">
    
                        <div id= "paragraphs">
                        <div class = "input-containers">
                            <label for="inputSubject">Sujet</label>
                            <textarea name="subject" placeholder="Sujet" class="input-zone" id="inputSubject" cols="20" rows="2"><?php echo $newsletter['subject']; ?></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="input-containers">Paragraphe 1</label>
                            <textarea name="para1" placeholder="Paragraphe" class="input-zone" id="inputPara1" cols="60" rows="10"><?php echo $newsletter['paragraph01']; ?></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="inputPara2">Paragraphe 2</label>
                            <textarea name="para2" placeholder="Paragraphe" class="input-zone" id="inputPara2" cols="60" rows="10"><?php echo $newsletter['paragraph02']; ?></textarea>
                        </div>

                        <div class = "input-containers">
                            <label for="inputPara3">Paragraphe 3</label>
                            <textarea name="para3" placeholder="Paragraphe" class="input-zone" id="inputPara3" cols="60" rows="10"><?php echo $newsletter['paragraph03']; ?></textarea>
                        </div>
                        </div>

                    </div>

                        <input type="hidden" name="NewsId" value="<?php echo $newsletter['id_nl']; ?>">

                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditNewsletter.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteNewsletter.php')" type="submit">Supprimer</button>
                        <button class="btn" id="send-btn" onclick="changeAction('../scripts/send_newletter.php')" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
        <?php 
                }
            }
        ?> 
    </main>
</body>
</html>
