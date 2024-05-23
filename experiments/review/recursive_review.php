<?php
session_start();

// Relative path to root "/"
// ========== PLEASE ADD A "/" AT THE END ! ========== 
$rootPath = '../../';
// Name of the document
$DocumentTitle = 'Livre';

// Path to DB
require $rootPath . 'includes/db.php';

$id = 5;


//get reviews
$query = "SELECT id_review, comment, rating, DATE_FORMAT(time_stamp, '%d/%m/%Y %H:%i') AS date, respond_to, USER.id_user, USER.name, USER.lastname, profile_pic, username
        FROM REVIEW_BOOK JOIN USER ON REVIEW_BOOK.id_user = USER.id_user
        WHERE id_book = :id;
        GROUP BY repond_to";

$request = $pdo->prepare($query);
$request->bindParam(":id", $id);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);

//var_dump($posts);

/*
input : array of post, id of a post
output : nothing
*/
function display_post($posts, $id) {
    foreach ($posts as $post) {
        if ($post['id_review'] == $id) {
            include '../../includes/post.php';
        }
    }
}
/*
input : array of post, id of a post
output : array of all the posts that are in response to the input post
*/
function search_resp($posts, $id) {
    $answers = array();
    foreach ($posts as $post) {
        if ($post['respond_to'] == $id) {
            $answers[] = $post;
        }
    }
    return $answers;
}



/*
input : array of post, id of a post
output : nothing
description : recursive function that takes a post that isn't a response to any other post
                print original post            
                find all the post in response, print them
*/
function response_tree($posts, $id) {
    display_post($posts, $id);
    $responses = search_resp($posts, $id);

    if (empty($responses)) {
        return;
    } 
    else {
        foreach ($responses as $post) {
            response_tree($posts, $post['id_review']);
        }
    }
}
/*
runner code
*/
foreach ($posts as $post) {
    if ($post['respond_to'] == NULL) {
        response_tree($posts, $post['id_review']);
    }
}