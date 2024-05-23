<?php
include 'scripts/php/init.php';

if (!isset($_GET['id']) || empty($_GET['id'])) { 
    header('location: books.php?message=Identifiant de livre invalide.');
    exit; 
}

$id = $_GET['id'];

include('../includes/db.php');

$query = "SELECT id_review, comment, rating, DATE_FORMAT(time_stamp, '%d/%m/%Y %H:%i') AS date, respond_to, USER.id_user, USER.name, USER.lastname, profile_pic, username
        FROM REVIEW_BOOK JOIN USER ON REVIEW_BOOK.id_user = USER.id_user
        WHERE id_book = :id AND REVIEW_BOOK.deleted != 1 AND comment IS NOT NULL;
        ";

$request = $pdo->prepare($query);
$request->bindParam(":id", $id);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);

include '../includes/printStarRating.php';

/*
input : array of post, id of a post,  identation level
output : nothing
*/
function display_post($posts, $id, $indent)
{
    foreach ($posts as $post) {
        if ($post['id_review'] == $id) {
            include 'scripts/php/post.php';
        }
    }
}
/*
input : array of post, id of a post
output : array of all the posts that are in response to the input post
*/
function search_resp($posts, $id)
{
    $answers = array();
    foreach ($posts as $post) {
        if ($post['respond_to'] == $id) {
            $answers[] = $post;
        }
    }
    return $answers;
}

/*
input : array of post, id of a post, identation level
output : nothing
description : recursive function that takes a post that isn't a response to any other post
                print original post            
                find all the post in response, print them
*/
function response_tree($posts, $id, $indent)
{
    display_post($posts, $id, $indent);
    $responses = search_resp($posts, $id);

    if (empty($responses)) {
        return;
    }
    foreach ($responses as $post) {
        response_tree($posts, $post['id_review'], $indent + 1);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/livre.css">

    <!--  DELETE POST  -->
    <script src="scripts/js/Review.js"></script>

    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">

    <title>Reviews livre</title>
</head>

<body>
<?php  
    include('../includes/navbar_back.php');  
    include('../includes/popupDelete.php');  
    ?>
        <main>
        <section class="review">
            <div class="reviews-header">
                <h2 class="big-title">Critiques</h2>
            </div>
            <div class="posts-container">
                <?php
                foreach ($posts as $post) {
                    if ($post['respond_to'] == NULL) {
                        response_tree($posts, $post['id_review'], 0);
                    }
                }
                ?>
            </div>
        </section>

        
    </main>



    
</body>
</html>












