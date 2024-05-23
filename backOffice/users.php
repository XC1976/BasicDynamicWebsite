<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/users.css">
    
     <!-- SORT CSS & JS -->

     <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Users</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>
    <main>
        <div class="users">
            <div class="title-container">
                <h1>UTILISATEURS</h1>
                <a href="addUser.php">AJOUTER +</a>
            </div>
            <?php include('scripts/php/message.php'); ?>
            <div class="table-container"> 
                <table class="tab">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0)">
                                <div>
                                    profil
                                    <span class="arrow0 inactive"></span>
                                </div>
                            </th>
                            <th onclick="sortTable(1)">
                                <div>
                                    identité
                                    <span class="arrow1 inactive"></span>
                                </div>
                            </th>
                            <th onclick="sortTable(2)">
                                <div>
                                    status user
                                    <span class="arrow2 inactive"></span>
                                </div>
                            </th>
                            <th onclick="sortTable(3)">
                                <div>
                                    email
                                    <span class="arrow3 inactive"></span>
                                </div>
                            </th>
                            <th onclick="sortTable(4)">
                                <div>
                                    statut ban
                                    <span class="arrow4 inactive"></span>
                                </div>
                            </th>
                            <th>gérer</th>   
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $getAllUsers = "SELECT id_user, name, lastname, username, email, profile_pic, status, is_banned FROM USER ORDER BY creation_date DESC;";
                            $req = $pdo->prepare($getAllUsers);
                            $req->execute();
                            $results = $req->fetchAll(); 
                            if (!empty($results)){
                                for ($i = 0; $i < count($results); $i++): 
                        ?> 
                        <tr>
                            <td class="tabElem" id="profil">
                                <img src="../assets/img/profilPic/<?php echo $results[$i]["profile_pic"]; ?>"  alt="">
                                <?php echo $results[$i]["username"]; ?>
                            </td>
                            <td class="tabElem">
                                <?php echo $results[$i]["name"]; echo " ";  echo $results[$i]["lastname"]; ?>
                            </td>
                            <td class="tabElem">
                                <?php if ($results[$i]["status"] == 1) {echo "utilisateur";} else { echo "auteur";}?>
                            </td> 
                            <td class="tabElem">
                                <?php echo $results[$i]["email"]; ?>
                            </td>
                            <td class="tabElem">
                                <?php if ($results[$i]["is_banned"] == 1) {echo "banni";} else { echo "actif";}?>
                            </td>
                            <td class="tabElem">
                                <a href="editUser.php?id_user=<?php echo $results[$i]["id_user"]; ?>" class="updateButton">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                            </td>
                        </tr>
                        <?php 
                                endfor;
                            } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
