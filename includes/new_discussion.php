<?php
    // this is an 'includes'
    // it must not be accessed directly
    if (!isset($rootPath)) {
        $message = "Erreur, accès incorrect au formulaire";
        header("Location: ../index.php?&message=$message");
    }

    //getting discussion list (for the dropdown menu)
    $request = $pdo->query("SELECT code_categorie, name FROM DISCUSSION_CATEGORIE;");
    $categories = $request->fetchAll(PDO::FETCH_ASSOC);

    //page link is needed for redirection after submit
    $page_link = $_SERVER['PHP_SELF'];
    if ($page_link == 'discussion.php') {
        $page_link = $page_link . '?categorie=' . $_GET['categorie'] . '&title=' . $_GET['title'];
    }
?>
<div class="discu" id="discu">
    <form action="<?php echo $rootPath . 'scripts/new_discu.php'?>" method="POST" class="discu__form">
        <h2 class="discu__title">Nouvelle Discussion</h2>
        <p id="message">
            <?php if (array_key_exists('message', $_GET)) echo htmlspecialchars($_GET['message']); ?>
        </p>
        <input type="text" id="title" name="title" placeholder="Titre de la discussison" class="discu__input">

        <select id="categorie" name="categorie" class="discu__input">
            <option class="discu__input" value="default">Choisissez une catégorie</option>

            <?php foreach ($categories as $option): ?>
                <option value=<?php echo $option['code_categorie']?>><?php echo $option['name']?></option>
            <?php endforeach; ?>
        </select>

        <textarea placeholder="Écrivez votre message" id="discu_content" class="discu__largeinput" name="discu_content"></textarea>
        <button type="submit" class="discu__button" name="validate">Commencer la discussion</button>

        <input type="hidden" name="previous_page" value="<?php echo $page_link?>">
        
    </form>

    <i class="ri-close-line discu__close" id="discu-close"></i>
</div>