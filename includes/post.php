<?php $rootPath = '../../';
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
                <button id="<?php echo $post['id_review'] ?>" class="like-btn" onclick="like_click(this)">Aimer</button>
                <span class="like-counter" id="<?php echo 'counter' . $post['id_review'] ?>">
                    <?php
                    $id_review = $post['id_review'];
                    include $rootPath . 'scripts/like_nb_review.php';
                    ?>
                </span>
                <button id="<?php echo $post['id_review'] ?>" class="like-btn"
                    onclick="show_popup(this)">Répondre</button>
            </div>
        <?php if (isset($_SESSION['id_user'])) :?>
            <?php if ($post['id_user'] == $_SESSION['id_user']): ?>
                <div style="margin-top: 10px;">
                    <button onclick="deletePost2(event, <?= $post['id_review']; ?>)" class="deletePostButton">Supprimer
                        post</button>
                    <button onclick="showTextArea(event)" class="editPostButton">Edit post</button>
                    <form action="<?= $rootPath . 'scripts/posts/editReviewBook.php' ?>" method="post" class="editPost">
                        <textarea name="editPost"></textarea>
                        <input type="submit" name="submit" value="Modifier post" class="modifPost">
                        <input type="hidden" name="id_post" value="<?= $post['id_review']; ?>">
                        <input type="hidden" name="previous_page" value="<?= $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>">
                        <input type="hidden" name="id_discu" value=<?= $_GET['id']; ?>>
                    </form>
                </div>
            <?php endif; ?>
        <?php endif;?>
        </div>
    </div>
</div>
