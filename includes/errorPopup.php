<?php if (isset($_GET['message']) && !empty($_GET['message'])): ?>
    <div class="errorMsg">
        <p>
            <?= $_GET['message'] ?>
        </p>
        <img src="<?= $rootPath . 'assets/img/closeButton.png '?>" alt="close" onclick="deletePopupError(event)"/>
    </div>
<?php endif; ?>