<?php
session_start();
$rootPath = "../";
require $rootPath . 'includes/db.php';


//user must be connected
if (!isset($_SESSION['id_user']) || empty($_SESSION['id_user'])) {
    exit(1);
}
$id_user = $_SESSION['id_user'];

//=== disucussions panel

$query="SELECT
            MAX(sent_date) AS date,
            MESSAGE.destinataire AS reciever,
            USER.id_user AS sender
        FROM 
            MESSAGE
        JOIN USER
            ON MESSAGE.id_user = USER.id_user
        WHERE
            MESSAGE.id_user = :id_user
        OR
            destinataire = :id_user
        GROUP BY
            sender,
            reciever
        ORDER BY
            date DESC
        ;";

$request = $pdo->prepare($query);
$request->bindParam(":id_user", $id_user);
$request->bindParam(":id_user", $id_user);
$request->execute();
$discussions = $request->fetchAll(PDO::FETCH_ASSOC);

$id_users = array();

//getting all senders and recievers
$id_users = array();
foreach($discussions as $message) {
    if ($message['sender'] != $id_user && !in_array($message['sender'], $id_users))
        array_push($id_users, $message['sender']);
    if ($message['reciever'] != $id_user && !in_array($message['reciever'], $id_users))
        array_push($id_users, $message['reciever']);   
}

//add new dest with searchbar
if (isset($_SESSION['selected_dest']) && !empty($_SESSION['selected_dest']) && !in_array($_SESSION['selected_dest'], $id_users)) {
    array_push($id_users, $_SESSION['selected_dest']);
}


$discu = array();
for($i = 0; $i < count($id_users); $i++){
    $friend = $id_users[$i];
    //getting user data
$query="SELECT
            USER.id_user AS id_dest,
            USER.username,
            profile_pic
        FROM 
            USER
        WHERE
            id_user = :friend
    ;";

    $request = $pdo->prepare($query);
    $request->bindParam(":friend", $friend);
    $request->execute();
    $res = $request->fetchAll(PDO::FETCH_ASSOC);
    //echo '<br><br>';
    //var_dump($res);
    if (!empty($res[0]) ){
        array_push($discu, $res[0]);
    }
}

if (empty($discu) || $discu[0] == null) {
    exit();
}

$discuId = 0; foreach ($discu as $message): ?>
    <div class="discu" id=<?= 'dest' . $message['id_dest']?>>
        <a href="<?= '../../' . 'pages/Profil/profile.php?username=' . $message['username']; ?>" class="avatar">
            <div>
                <img src="<?= '../../' . 'assets/img/profilPic/' . $message['profile_pic'] ?>" alt="User Avatar">
                <div class="user-info">
                    <div class="username"><?= '@' . $message['username'] ?></div>
                </div>
            </div>
        </a>
        <div class="content">
            <div class="content"><?php echo getLastMessage($message['id_dest'], $id_user, 'content', $pdo) ?></div>
            <div class="time">
                <?php echo getLastMessage($message['id_dest'], $id_user, 'date', $pdo)?>
            </div>
        </div>
    </div>
<?php $discuId++; endforeach; 

function getLastMessage($id, $id_user, $value, $pdo) {
    $query="SELECT
                content,
                DATE_FORMAT(sent_date, '%d/%m @ %H:%i') AS date
            FROM
                MESSAGE
            WHERE
                (id_user = :id_dest  AND destinataire = :id_user
            OR
                id_user = :id_user AND destinataire = :id_dest) 
            AND
                sent_date = (SELECT MAX(sent_date) FROM MESSAGE WHERE 
                            id_user = :id_dest  AND destinataire = :id_user
                            OR
                            id_user = :id_user AND destinataire = :id_dest)
            ;";
    $request = $pdo->prepare($query);
    $request->bindParam(":id_user", $id_user);
    $request->bindParam(":id_dest", $id);
    $request->execute();
    $res = $request->fetchAll(PDO::FETCH_ASSOC);
    if (empty($res)) {
        $res[0]['content'] = 'Aucun Message';
        $res[0]['date'] = '';
    }

    if ($value == 'date') {
        return $res[0]['date'];
    }
    else if ($value == 'content') {
        return $res[0]['content'];
    } else {
        return 'Error';
    }
}
