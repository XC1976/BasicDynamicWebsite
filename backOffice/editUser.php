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
    <link rel="stylesheet" href="../assets/css/pageSpecific/editUser.css">

    <!-- ACTION CHANGE JS  -->
    <script src="scripts/js/changeAction.js"></script>

    <title>Edit User</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>
        <?php  
            // id au bon format dans l'url 
            if (!isset($_GET['id_user']) || !is_numeric($_GET['id_user'])) { 
                header('location: users.php?message=Identifiant invalide.');
                exit;
            } else {
                // on cherche l'id dans la db
                $q = 'SELECT id_user, name, lastname, admin, username, email, profile_pic, status, is_banned FROM USER WHERE id_user = :id;';
                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id_user']]);
                $user = $req->fetch(PDO::FETCH_ASSOC);
                
                // Si nous ne le trouvons pas, retour au tableau users  
                if (!$user) { 
                    header('Location: users.php?message=Utilisateur introuvable.');
                    exit;
                } else {                  
                    include('scripts/php/message.php');
        ?>

        <div class="form">
            <div class="center-box">
                <div class="title-container">
                    <h1>MODIFIER L'UTILISATEUR</h1>
                </div>
                <div class="form-container">
                    <!-- action assurée par JS en fonction du bouton cliqué-->
                    <form method="post" action="" id="Form" enctype="multipart/form-data">
                     
                    <div class = "info">

                    <div class = "pic"><img class="thumbnail" src="../assets/img/profilPic/<?= $user['profile_pic'] ?>"></div>
                       <div class = "texts">
                        <div class="inputRow">
                            <label for="inputUsername">Username</label>
                            <input type="text" name="username" placeholder="username" class="input-zone" id="inputUsername" value="<?php echo $user['username']; ?>">
                        </div>
                        <div class="inputRow">
                            <label for="inputName">Prénom</label>
                            <input type="text" name="name" placeholder="name" class="input-zone" id="inputName" value="<?php echo $user['name']; ?>">
                        </div>
                        <div class="inputRow">
                            <label for="inputLastname">Nom</label>
                            <input type="text" name="lastname" placeholder="lastname" class="input-zone" id="inputLastname" value="<?php echo $user['lastname']; ?>">
                        </div>
                        <div class="inputRow">
                            <label for="inputEmail">Email</label>
                            <input type="text" name="email" placeholder="email" class="input-zone" id="inputEmail" value="<?php echo $user['email']; ?>">
                        </div>
                        </div>


                        </div>

                        <!-- nom de l'image en value cachée -->
                        <input type="hidden" name="profile_pic" value="<?= $user['profile_pic']; ?>">
                        <div class="file_selection">
                            <label for="inputImage" class="form-label">Image de profil</label>
                            <input type="file" name="image" class="form-control" id="inputImage">
                        </div>

                        <div class = "status">
                        <div class="inputRow">
                        <label for="inputStatus" name="status" class="input-zone">Statut</label>
                            <select id = "inputStatus" name ="status_value">
                                <option value="0" <?php if ($user['is_banned'] == 0) echo "selected"; ?>>actif</option>
                                <option value="1" <?php if ($user['is_banned'] == 1) echo "selected"; ?>>banni</option>   
                            </select>
                        

                        <label for="inputAdmin" name="admin" class="input-zone">Droits</label>
                            <select id = "inputAdmin" name ="admin_value">
                                <option value="0" <?php if ($user['admin'] == 0) echo "selected"; ?>>regular</option>
                                <option value="1" <?php if ($user['admin'] == 1) echo "selected"; ?>>admin</option>   
                            </select>


                        <label for="inputAuthor" name="author" class="input-zone">Auteur</label>
                            <select id = "inputAuthor" name ="author_value">
                                <option value="0" <?php if ($user['status'] == 0) echo "selected"; ?>>auteur</option>
                                <option value="1" <?php if ($user['status'] == 1) echo "selected"; ?>>utilisateur</option>   
                            </select>
                        </div>
                        </div>

                        <input type="hidden" name="userId" value="<?= $user['id_user'] ?>">
                        <button class="btn" id="submit-btn" onclick="changeAction('scripts/php/verificationEditUser.php')" type="submit">Enregistrer</button>
                        <button class="btn" id="delete-btn" onclick="changeAction('scripts/php/deleteUser.php')" type="submit">Supprimer</button>
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
