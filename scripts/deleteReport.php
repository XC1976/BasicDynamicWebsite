<?php 
// seems like there's an issue here too

if (isset($_POST['id']) && isset($_POST['table'])) {
    $id = intval($_POST['id']);
    $table = $_POST['table'];

    // Connexion
    $bdd = new PDO("mysql:host=localhost;port=3306;dbname=openreads;charset=utf8", "root", "ePvVcHHgOSFLyEZQQglE$");

    // You can't prepare the table name so here's a switch 
    switch ($table) {
        case 'report_user':
            $req = $bdd->prepare("DELETE FROM report_user WHERE id = ?");
            break;
        case 'report_review':
            $req = $bdd->prepare("DELETE FROM report_review WHERE id = ?");
            break;
        case 'report_post':
            $req = $bdd->prepare("DELETE FROM report_post WHERE id = ?");
            break;
        case 'report_book':
            $req = $bdd->prepare("DELETE FROM report_book WHERE id = ?");
            break;

        default:
            http_response_code(400); // BAD_REQUEST
            exit();
    }


    $success = $req->execute([$id]);


    if ($success) {
        http_response_code(204); // NO_CONTENT
    } else {
        http_response_code(500); // INTERNAL_SERVER_ERROR
    }
} else {
    // Erreur : les paramètres requis ne sont pas présents
    http_response_code(400); // BAD_REQUEST 
}
?>
