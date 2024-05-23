<?php
// this is an 'includes'
// it must not be accessed directly
if (!isset($rootPath)) {
    header("Location: ../pages/Forum/accueil.php");
}

//=== getting the last 5 posts
//SELECT content, id_user, post_date, id_discu FROM POST ORDER BY post_date DESC LIMIT 5;
$query = "SELECT POST.content, POST.post_date, POST.id_discu, USER.username
        FROM POST INNER JOIN USER
        ON POST.id_user = USER.id_user
        ORDER BY POST.post_date DESC LIMIT 5;
        ";
       
$request = $pdo->prepare($query);
$request->execute();
$posts = $request->fetchAll(PDO::FETCH_ASSOC);
$btnTxt = "+ Ajouter un poste";
?>

<div class="panel">
    <div class="add-post">
        <button class="like-btn" id="new_post-btn" onclick="show_popup()"><?php echo $btnTxt?></button>
    </div>
    <h3>Derniers posts</h3>
    <?php foreach ($posts as $post): ?>
        
        <div class="panel-post" id="panel-post" url="<?php echo $rootPath . 'pages/Forum/posts.php?id=' . $post['id_discu'] ?>">
            <div class="username"><?php echo '@' . $post['username']?></div>
            <div class="content">
                <p class="panel_message"><?php echo $post['content']?></p>
                <div class="time">
                    <?php $timestamp = $post['post_date'];
                    include $rootPath . 'includes/format_time.php'; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    //make message clickable
    const posts = document.querySelectorAll('.panel-post');
        posts.forEach(function(post) {
        post.addEventListener('click', function() {
            window.location = this.getAttribute('url');
        });
    });
    const last_post = document.querySelectorAll(".panel_message");

    //cut off the long messages
    last_post.forEach(function(msg) {
        if (msg.textContent.length > 150) {
            msg.textContent = msg.textContent.substring(0, 150) + ' ...';
        }
    });


</script>