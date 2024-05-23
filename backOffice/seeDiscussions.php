<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/users.css">

    <!-- SORT CSS & JS -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/arrows.css">
    <script src="scripts/js/sortBy.js"></script>

    <title>Discussions de la catégorie</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');
        include('../includes/db.php');   
    ?>

    <main>

    <div class ="users">
    <div class = "title-container">
        <h1>DISCUSSIONS</h1>
    </div>

    <?php include('scripts/php/message.php'); ?>

    <div class = "table-container"> 
    <table class = "tab">
    <thead>
        <tr> 
          <th onclick="sortTable(0)">discussion  <span class="arrow0 inactive"></span></th> 
          <th onclick="sortTable(1)">posteur  <span class="arrow1 inactive"></span></th> 
          <th>gérer</th>   
        </tr>
    </thead>
    <tbody>

         <!-- FETCHING THE ROWS FROM DB  -->
         <?php  
if (!isset($_GET['id_cat']) || empty($_GET['id_cat'])) { 
    header('location: forum.php?message=Identifiant de catégorie invalide.');
    exit;
}
$q = 'SELECT id_discussion, DISCUSSION.name as nom, username 
FROM USER 
JOIN DISCUSSION ON id_user = op 
JOIN DISCUSSION_CATEGORIE ON categorie = code_categorie 
WHERE categorie = :id;';

    $req = $pdo->prepare($q);
    $req->execute(['id' => $_GET['id_cat']]);
    $discus = $req->fetchAll(PDO::FETCH_ASSOC);

    $cat = $_GET['id_cat'];

    if (!empty($discus)){
        foreach ($discus as $discu): 
?>
    <tr>
        <td class="tabElem"><?php echo $discu['nom']; ?></td>
        <td class="tabElem"><?php echo $discu['username']; ?></td>
        <td class="tabElem">
          <a href="seeDiscu.php?id_discu=<?php echo $discu["id_discussion"]; ?>&id_cat=<?php echo $cat; ?>" class="updateButton"><span class="material-symbols-outlined">visibility</span></a>
          <a href="scripts/php/deleteDiscu.php?id_discu=<?php echo $discu["id_discussion"]; ?>&id_cat=<?php echo $cat; ?>" class="updateButton"><span class="material-symbols-outlined">delete_forever</span></a>
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












