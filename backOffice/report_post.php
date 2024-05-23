<?php  
include 'scripts/php/init.php';
            include('../includes/db.php'); 
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
                header('location: frontPage.php?message=Identifiant post invalide.');
                exit; }

                $table = 'POST';

                $q = "SELECT 
        rp.id_report_post AS id,
        DATE_FORMAT(rp.date_report, '%d/%m/%Y %H:%i:%s') AS date, 
        rp.processing_status AS status,
        u_reporting.username AS signaleur, 
        rp.reporting_user,
        p.id_post AS post_id,
        p.content,
        u_posting.username AS signale, 
        u_posting.id_user AS reported_user,
        u_posting.profile_pic AS reportedPic,
        rp.reason_report AS type,
        u_reporting.profile_pic AS reportingPic
    FROM 
        REPORT_POST rp
    JOIN 
        USER u_reporting ON rp.reporting_user = u_reporting.id_user
    JOIN 
        POST p ON rp.reported_post = p.id_post
    JOIN 
        USER u_posting ON p.id_user = u_posting.id_user
    WHERE 
        rp.id_report_post = :id
    ORDER BY 
        rp.date_report DESC;";

        
                

                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id']]);
                $report = $req->fetch(PDO::FETCH_ASSOC);
                
                // Dans le cas où nous n'avons pas pu trouver le report dans la db
                if (!$report) { 
                    header('location: frontPage.php?message=Signalement introuvable.');
                    exit;
                } 
                 ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('scripts/php/genHeaderLinks.php'); ?>

    <!-- SPECIFIC CSS  -->
    <link rel="stylesheet" href="../assets/css/pageSpecific/reportPost.css">

    <!--  DELETE POST  -->
    <script src="scripts/js/Discussion.js"></script>

    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">


    <title>REPORT POST</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php'); 
        include('../includes/popupDelete.php');   
    ?>

    <main>
    <?php include('scripts/php/message.php'); ?>
    <div class = "title">
        <h1>SIGNALEMENT</h1>
    </div>

        <div class="outer-box">
            <div class="container">
                
            <div class="rowsContainer">

                    <div class="box">
                        <div class="textBox">
                            <p class="label">utilisateur signaleur</p>
                            <p class="info"><a href = "editUser.php?id_user=<?php echo $report['reporting_user'];?>"><?php echo $report['signaleur']; ?></a></p>
                        </div>
                        <div class="img">
                            <img class ="pic" src = "../assets/img/profilPic/<?php echo $report['reportingPic'];?>">
                        </div>
                    </div>

                    <div class="box">
                        <div class="textBox">
                            <p class="label">utilisateur signalé</p>
                            <p class="info"><a href = "editUser.php?id_user=<?php echo $report['reported_user'];?>"><?php echo $report['signale']; ?></a></p>
                        </div>
                        <div class="img">
                            <img class ="pic" src = "../assets/img/profilPic/<?php echo $report['reportedPic'];?>" >
                        </div>
                    </div>

                </div>

                <div class="rowsContainer2">
                    <p class = "reason">RAISON</p>
                    <p><?php if ($report['type'] == 1) { echo 'contenu innaproprié';} else { echo 'incitation à la haine ou harcèlement';} ?></p>
                </div>

                <div class="rowsContainer">
                <?php if ($report['content'] !== NULL): ?>
                    <p class="content"><button id="delete-btn" onclick="togglePopup(<?php echo $report['post_id']; ?>)">❌</button><?php echo $report['content']; ?></p>
                <?php else: ?>
                    <p class="content">post supprimé</p>
                <?php endif; ?>
                </div>



                <div class="rowsContainer">
                    <a href= "scripts/php/resolvedReport.php?id=<?php echo $report['id'];?>&table=<?php echo $table;?>" class ='btn'>Marquer comme résolu</a>
                </div>

            </div>
        </div>

    </main>
</body>
</html>
