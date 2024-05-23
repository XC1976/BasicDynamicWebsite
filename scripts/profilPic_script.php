<?php
// Formatte les grands nombres pour les followers et les suivis pour des raisons de lisibilité
function formatNombre($nb)
{
    if ($nb >= 0 && $nb <= 999) {
        return $nb;
    } elseif ($nb >= 1000 && $nb <= 999999) {
        return floor($nb / 1000) . 'K';
    } elseif ($nb >= 1000000 && $nb <= 9999999) {
        return floor($nb / 1000000) . 'M';
    } else
        return $nb;
}

// Vérifier si l'ID dans $_GET['id'] existe

if (isset($_GET['username']) && !empty($_GET['username'])) {

    // Verify if the ID exists
    $usernameProfil = $_GET['username'];
    $checkIfUsernameExists = $pdo->prepare('SELECT profile_pic, username, bio, id_user FROM USER WHERE username = ?');
    $checkIfUsernameExists->execute([$usernameProfil]);

    if ($checkIfUsernameExists->rowCount() > 0) {

        // =============================================
        // Récupère les informations du user
        $usersInfo = $checkIfUsernameExists->fetch(PDO::FETCH_ASSOC);

        $userProfilPic = $rootPath . 'assets/img/profilPic/' . $usersInfo['profile_pic'];
        $userUsername = $usersInfo['username'];
        $usernameBio = $usersInfo['bio'];
        $userID = $usersInfo['id_user'];

        // ========================================= 
        //Récupère le nombre de followers qui suit l'utilisateur

        $getNumberOfFollowers = $pdo->prepare('SELECT COUNT(following_user) AS followers_count FROM Follows WHERE followed_user = ?');
        $getNumberOfFollowers->execute([$userID]);
        $numberOfFollowsList = $getNumberOfFollowers->fetch(PDO::FETCH_ASSOC);

        $numberOfFollowers = $numberOfFollowsList['followers_count'];

        // ======================================== 
        //Récupère le nombre de personnes que follow l'utilisateur en question

        $getNumbersOfPeopleFollowed = $pdo->prepare('SELECT COUNT(followed_user) AS followings_count FROM Follows WHERE following_user = ?');
        $getNumbersOfPeopleFollowed->execute([$userID]);
        $numberOfPeopleFollowedList = $getNumbersOfPeopleFollowed->fetch(PDO::FETCH_ASSOC);

        $numberOfPeopleFollowed = $numberOfPeopleFollowedList['followings_count'];

        // ===============================================
        // Récupère les dernières post reviews de l'utilistateur
        $getCurrentUserPostsRequest = $pdo->prepare("SELECT id_post, content, id_discu, post_date FROM POST WHERE id_user = ? AND deleted != 1
        ORDER BY post_date DESC;");
        $getCurrentUserPostsRequest->execute([
            $userID
        ]);

        $currentUserPosts = $getCurrentUserPostsRequest->fetchAll(PDO::FETCH_ASSOC);
        $currentUserPostsRow = $getCurrentUserPostsRequest->rowCount();

        // ============================================== 
        // All the verification to see if the current user is already following or blocking the current user

        //Verify if its own profile
        if (isset($_SESSION['id_user']) && $userID != $_SESSION['id_user']) {

            // Verify if the current user is already following the user
            $getFollowRow = $pdo->prepare("SELECT followed_user FROM Follows WHERE followed_user = ? AND following_user = ?;");
            $getFollowRow->execute([
                $userID,
                $_SESSION['id_user']
            ]);

            // Use count($followRow) to verify if the follows exists

            $followRow = $getFollowRow->fetchAll(PDO::FETCH_ASSOC);

            // Verify if the user is already blocking the user
            $getBlockRow = $pdo->prepare("SELECT blocked_user FROM BLOCKS WHERE blocked_user = ? AND blocking_user = ?;");
            $getBlockRow->execute([
                $userID,
                $_SESSION['id_user']
            ]);

            $blockRow = $getBlockRow->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get reviews books
        $queryReviewsBooks = "SELECT id_review, comment, rating, time_stamp, 
        REVIEW_BOOK.id_book AS idBook, id_user, respond_to, BOOK.title_VF AS bookName FROM REVIEW_BOOK JOIN BOOK ON REVIEW_BOOK.id_book = BOOK.id_book
        WHERE REVIEW_BOOK.id_user = :id_user AND REVIEW_BOOK.deleted != 1;";

        $getReviewsBookRequest = $pdo->prepare($queryReviewsBooks);
        $getReviewsBookRequest->bindParam(":id_user", $userID);
        $getReviewsBookRequest->execute();
        $ReviewsBook = $getReviewsBookRequest->fetchAll(PDO::FETCH_ASSOC);

        $reviewsBookRowCount = $getReviewsBookRequest->rowCount();

        if ($userUsername == $_SESSION['username']) {
            // Get all libraries of own user
            $getLibrariesRequest = $pdo->prepare("SELECT id_lib, name, library_img FROM LIB WHERE id_user = ?;");
            $getLibrariesRequest->execute([
                $userID
            ]);
            $getLibraries = $getLibrariesRequest->fetchAll(PDO::FETCH_ASSOC);
        } else {
            // Only show public libraries
            $getLibrariesRequest = $pdo->prepare("SELECT id_lib, name, library_img FROM LIB WHERE id_user = ? AND public != 0;");
            $getLibrariesRequest->execute([
                $userID
            ]);
            $getLibraries = $getLibrariesRequest->fetchAll(PDO::FETCH_ASSOC);
        }

        // Get the user challenge
        $getUsersChallengeRequest = $pdo->prepare("SELECT CHALLENGE.date_start, CHALLENGE.date_end, CHALLENGE.name, CHALLENGE.id_challenge, CHALLENGE.goal_books 
        FROM CHALLENGELIST JOIN CHALLENGE ON CHALLENGELIST.id = CHALLENGE.enCours WHERE id_user = ?;");
        $getUsersChallengeRequest->execute([
            $userID
        ]);
        $getUsersChallenge = $getUsersChallengeRequest->fetchAll(PDO::FETCH_ASSOC);

    } else {
        // Send an error message when the user with $_GET['id'] doesn't exist
        header('Location: ../others/errorPage.php?message=Cet utilisateur n\'existe pas.');
    }

} else {
    // Send an error message if the ID is empty or not present in the URL.
    header('Location: ../others/errorPage.php?message=Vous ne pouvez pas accéder à cette page ainsi.');
}