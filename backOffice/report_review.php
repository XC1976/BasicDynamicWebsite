<?php  
include 'scripts/php/init.php';
            include('../includes/db.php'); 
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
                header('location: frontPage.php?message=Identifiant post invalide.');
                exit; }

                $table = 'REVIEW';

                $q = "SELECT 
        rr.id_report_review AS id,
        DATE_FORMAT(rr.date_report, '%d/%m/%Y %H:%i:%s') AS date, 
        rr.processing_status AS status,
        u_reporting.username AS signaleur,
        reported_review, 
        reporting_user,
        u_reviewer.id_user AS reported_user,
        u_reviewer.username AS signale, 
        u_reporting.profile_pic AS reportingPic, 
        u_reviewer.profile_pic AS reportedPic, 
        rr.reason_report AS type,
        rb.comment AS content
    FROM 
        REPORT_REVIEW rr
    JOIN 
        USER u_reporting ON rr.reporting_user = u_reporting.id_user
    JOIN 
        REVIEW_BOOK rb ON rr.reported_review = rb.id_review
    JOIN 
        USER u_reviewer ON rb.id_user = u_reviewer.id_user 
        WHERE id_report_review = :id
    ORDER BY 
        rr.date_report DESC;";
  

                $req = $pdo->prepare($q);
                $req->execute(['id' => $_GET['id']]);
                $report = $req->fetch(PDO::FETCH_ASSOC);
                
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
    <script src="scripts/js/Review.js"></script>

    <link rel = "stylesheet" href = "../assets/css/general/components/popupDelete.css">


    <title>REPORT REVIEW</title>
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
                    <p class="content"><button id="delete-btn" onclick="togglePopup(<?php echo $report['reported_review']; ?>)">❌</button><?php echo $report['content']; ?></p>
                <?php else: ?>
                    <p class="content">review supprimé</p>
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
