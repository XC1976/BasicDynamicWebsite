<!-- SELECT * FROM BookToSell ORDER BY date_published DESC LIMIT 16; -->

<?php
    if(isset($_GET['page']) && !empty($_GET['page']) && filter_var($_GET['page'], FILTER_VALIDATE_INT) !== false && $_GET['page'] > 0) {
        $pageNumber = $_GET['page'];
    } else {
        $pageNumber = 1;
    }

    // Calculate the offset for the page number
    if($pageNumber == 1) {
        $pageNumberOffset = 0;    
    } else {
        $pageNumberOffset = ($pageNumber - 1) * 8;
    }

    $getItemsOfPage = $pdo->prepare('SELECT * FROM BookToSell LEFT JOIN BookImage ON BookToSell.id_BookToSell = BookImage.id_book_to_sell WHERE BookToSell.quantityItem != 0 ORDER BY date_published DESC LIMIT 8 OFFSET :offset');
    $getItemsOfPage->bindParam(':offset', $pageNumberOffset, PDO::PARAM_INT);
    $getItemsOfPage->execute();

    $itemsOfPageInfos = $getItemsOfPage->fetchAll(PDO::FETCH_ASSOC);