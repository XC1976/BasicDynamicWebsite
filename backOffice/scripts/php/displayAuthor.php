<?php

ini_set('display_errors', 1);

if (isset($_GET['name']) && !empty($_GET['name'])) {

    include('../../../includes/db.php');

    $req = $pdo->prepare("SELECT id_author, name, lastname FROM AUTHOR WHERE name LIKE ? OR lastname LIKE ? LIMIT 5;");
    $success = $req->execute([
        $_GET['name'] . "%",
        $_GET['name'] . "%"
    ]);

    if ($success) {
        $authors = $req->fetchAll(PDO::FETCH_ASSOC);

        foreach ($authors as $author) { ?> 
            <li onclick = "setValue('<?php echo $author['id_author']; ?>')"  id="<?php echo $author['id_author']; ?>"><?php echo $author['name'] . ' ' . $author['lastname']; ?></li>

<?php
        }
    }
}
?>

