<?php  
include 'scripts/php/init.php';
          include('../includes/db.php'); 
            if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { 
                header('location: frontPage.php?message=Identifiant utilisateur invalide.');
                exit; }

                $table = 'USER';

                $q = "SELECT 
                id_report_user AS id,
                DATE_FORMAT(date_report, '%d/%m/%Y %H:%i:%s') AS date, 
                processing_status AS status,
                reported_user,
                reporting_user,
                u_reported.username AS signale, 
                u_reported.profile_pic AS reportedPic,
                reason_report AS type, 
                u_reporting.username AS signaleur,
                u_reporting.profile_pic AS reportingPic
              FROM 
                REPORT_USER
              JOIN 
                USER u_reporting ON reporting_user = u_reporting.id_user
              JOIN 
                USER u_reported ON reported_user = u_reported.id_user
              WHERE 
                id_report_user = :id
              ORDER BY 
                date_report DESC;";

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
    <link rel="stylesheet" href="../assets/css/pageSpecific/reportUser.css">


    <title>REPORT USER</title>
</head>
<body>
    <?php  
        include('../includes/navbar_back.php');  
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
                    <a href= "scripts/php/resolvedReport.php?id=<?php echo $report['id'];?>&table=<?php echo $table;?>" class ='btn'>Marquer comme résolu</a>
                </div>
            </div>
        </div>

    </main>
</body>
</html>
