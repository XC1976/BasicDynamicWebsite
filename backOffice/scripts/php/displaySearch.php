<?php 

ini_set('display_errors', 1);

if (isset($_GET['name']) && !empty($_GET['name'])) {
    include('../../../includes/db.php');

    // Requête pour les utilisateurs
    $reqUser = $pdo->prepare("SELECT id_user as id, username as name FROM USER WHERE username LIKE ? LIMIT 7;");
    $successUser = $reqUser->execute([$_GET['name'] . "%"]);
    $rowsUser = $reqUser->fetchAll(PDO::FETCH_ASSOC);

    // Requête pour les auteurs
    $reqAuthor = $pdo->prepare("SELECT id_author as id, name, lastname FROM AUTHOR WHERE name LIKE ? OR lastname LIKE ? LIMIT 7;");
    $successAuthor = $reqAuthor->execute([
        $_GET['name'] . "%",
        $_GET['name'] . "%"
    ]);
    $rowsAuthor = $reqAuthor->fetchAll(PDO::FETCH_ASSOC);

    
    $rows = array_merge($rowsUser, $rowsAuthor);

    if ($successUser && $successAuthor) {
?>

<div id= "searchBarList" >
    <?php foreach ($rows as $row): ?>
        <div class = "rows">
            <?php
            $url = '';
            $location = '';
            if (isset($row['lastname']) && !empty($row['lastname'])) {
                $url = 'editAuthor.php?id_author=' . $row['id'];
                $location = 'dans Auteur';
            } else {
                $url = 'editUser.php?id_user=' . $row['id'];
                $location = 'dans Utilisateur';
            }
            ?>
            <a href="<?php echo $url; ?>" id="<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
                <?php if (isset($row['lastname']) && !empty($row['lastname'])): ?>
                    <?php echo ' ' . $row['lastname'] . ' ' . $location; ?>
                <?php else: ?>
                    <?php echo ' ' . $location; ?>
                <?php endif; ?>
            </a>
                </div>
    <?php endforeach; ?>
</div>

<?php
    }
}
?>
