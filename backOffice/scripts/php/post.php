<?php

$rootPath = '../../';
?>
<div class="indentation">
    <?php
    for ($i = 0; $i < $indent; $i++) {
        echo '<hr class="vertical-bar">';
    }
    ?>
    <div class="post">
        <div>
            <a href="<?= $rootPath . 'pages/Profil/profile.php?username=' . $post['username']; ?>" class="avatar">
                <img src="<?= $rootPath . 'assets/img/profilPic/' . $post['profile_pic'] ?>" alt="User Avatar">
                <div class="user-info">
                    <div class="full-name"><?php echo $post['name'] . ' ' . $post['lastname'] ?></div>
                    <div class="username"><?php echo '@' . $post['username'] ?></div>
                </div>
            </a>
        </div>
        <div class="content">
            <div class="star">
                <?php
                //star displaying
                //a response doesn't have a rating
                if ($post['respond_to'] == NULL) {
                    for ($i = 0; $i < 5; $i++) {
                        if ($post['rating'] > $i)
                            echo '<i class="fas fa-star"></i>';
                        else
                            echo '<i class="far fa-star"></i>';
                    }
                }

                ?>
            </div>

            <div class="message"><?php echo $post['comment'] ?></div>
            <div class="time">
                <?php echo $timestamp = $post['date']; ?>
            </div>
            <div class="actions">
                <button id="<?php echo $post['id_review'] ?>" style = 'color: black;' onclick="togglePopup(this.id)">Supprimer</button>
                <span class="like-counter" id="<?php echo 'counter' . $post['id_review'] ?>">
                    <?php
                    $id_review = $post['id_review'];
                    include  'like_nb_review.php';
                    ?>
                </span>
            </div>
        </div>
    </div>
</div>