<?php include 'scripts/php/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('scripts/php/genHeaderLinks.php'); ?>

                    <!-- SPECIFIC CSS  -->

    <link rel = "stylesheet" href = "../assets/css/pageSpecific/frontPage.css">
    

                     <!-- JS  -->
    <script src ="../assets/js/deleteRow.js" defer></script>

    <title>Admin Dashboard</title>  
</head>


<body>
    <?php  include('../includes/navbar_back.php');
           include('../includes/db.php');   
    ?>


    <main>
         <!-----     ANALYTICS ROW      ------>
        <div class= "main-title">
            <h2>Analytics</h2>
        </div>
        <div class= "main-cards"> 
            
            <?php 
            /* function that fetches the needed data for each block using the table name + a variable name for the result */
                function AnalyticsBlocksInfo($tableName, $alias) {
                    include('../includes/db.php');
                    $getSumElements = "SELECT COUNT(*) AS $alias FROM $tableName;";
                    $req = $pdo->prepare($getSumElements); 
                    $req->execute();            
                    $results = $req->fetch(PDO::FETCH_ASSOC);
                    $SumElements = $results[$alias];

                    echo $SumElements;
                }
            ?>


        <!--   calling the function for each block   -->
        <div class= "card"> 
            <div class= "card-inner"> 
                <h2>USERS</h2>
                <span class="material-symbols-outlined">groups</span>
            </div>
            <h1><?php AnalyticsBlocksInfo('USER', 'user_count'); ?></h1>
        </div>
        

        <div class= "card"> 
            <div class= "card-inner"> 
                <h2>LIVRES</h2>
                <span class="material-symbols-outlined">menu_book</span>
            </div>
            <h1><?php AnalyticsBlocksInfo('BOOK', 'book_count'); ?></h1> 
        </div>


        <div class= "card"> 
            <div class= "card-inner"> 
                <h2>FORUM</h2>
                <span class="material-symbols-outlined">forum</span>
            </div>
            <h1><?php AnalyticsBlocksInfo('DISCUSSION', 'discussion_count'); ?></h1> 
        </div>


        <div class= "card"> 
            <div class= "card-inner"> 
                <h2>ARTICLE</h2>
                <span class="material-symbols-outlined">sell</span>
            </div>
            <h1><?php AnalyticsBlocksInfo('BookToSell', 'booktosell_count'); ?></h1> 
        </div>

        </div>



        <!-----     RECENT REPORTS      ------>
    
    <div class = "tab-container">
    <div class= "main-title"> 
    <h2>Signalements récents à traîter</h2>
    </div>
    <?php include('scripts/php/message.php'); ?>

        <!-----     TABS. Admins can click on them to switch between user account reports, book reports, post reports and review reports  ------>
        <!-----     arguments 0,1,2,4 put in the correct order of the tables help the JS function treat the right one, as the report tables will be fetched into an indexed array    ------>
        <button class = "btn" onclick= "openTab(0)">USERS</button>
        <button class = "btn" onclick= "openTab(1)" >POSTS</button>
        <button class = "btn" onclick= "openTab(2)">REVIEWS</button>



  <?php

  $user = "SELECT 
  id_report_user AS id,
  DATE_FORMAT(date_report, '%d/%m/%Y %H:%i:%s') AS date, 
  processing_status AS status,
  u_reported.username AS signale, 
  reason_report AS type, 
  u_reporting.username AS signaleur 
FROM 
  REPORT_USER
JOIN 
  USER u_reporting ON reporting_user = u_reporting.id_user
JOIN 
  USER u_reported ON reported_user = u_reported.id_user
WHERE 
  processing_status = 0 
ORDER BY 
  date_report DESC;";


$post = "SELECT 
rp.id_report_post AS id,
DATE_FORMAT(rp.date_report, '%d/%m/%Y %H:%i:%s') AS date, 
rp.processing_status AS status,
u_reporting.username AS signaleur, 
u_posting.username AS signale, 
rp.reason_report AS type 
FROM 
REPORT_POST rp
JOIN 
USER u_reporting ON rp.reporting_user = u_reporting.id_user
JOIN 
POST p ON rp.reported_post = p.id_post
JOIN 
USER u_posting ON p.id_user = u_posting.id_user
WHERE 
  processing_status = 0
ORDER BY 
rp.date_report DESC;";

$review = "SELECT 
rr.id_report_review AS id,
DATE_FORMAT(rr.date_report, '%d/%m/%Y %H:%i:%s') AS date, 
rr.processing_status AS status,
u_reporting.username AS signaleur, 
u_reviewer.username AS signale, 
rr.reason_report AS type 
FROM 
REPORT_REVIEW rr
JOIN 
USER u_reporting ON rr.reporting_user = u_reporting.id_user
JOIN 
REVIEW_BOOK rb ON rr.reported_review = rb.id_review
JOIN 
USER u_reviewer ON rb.id_user = u_reviewer.id_user
WHERE 
  processing_status = 0
ORDER BY 
rr.date_report DESC;
";


  /* the structure of a report table name is always the same, only the last portion indicates what the table is about. $tableName is concatenated to the basic synthax to form the desired table's name. 
     As the table names are written in full caps, we  tableNameCaps  */
  function getReports($getAllReports, $tableName) {

    global $pdo;


    $req = $pdo->prepare($getAllReports);
    $req->execute();
    $results = $req->fetchAll();
        
        echo "<table class = " . "tab" . ">
        <tr> 
          <th>signalé.e</th> 
          <th>signalement de</th> 
          <th>motif</th>  
          <th>status</th>
          <th>date</th> 
          <th>gérer</th>   
        </tr>";

    if (!empty($results)){
        for ($i = 0; $i < 7 && $i < count($results); $i++): 
    ?> 


        <tr id = " <?php echo $results[$i]['id']; ?> ">
            <td class="tabElem"><?php echo $results[$i]['signale']; ?></td>
            <td class="tabElem"><?php echo $results[$i]['signaleur']; ?></td>
            <td class="tabElem"><?php if ($results[$i]['type'] == 1) { echo 'contenu innaproprié';} else { echo 'incitation à la haine ou harcèlement';} ?></td> 
            <td class="tabElem">non résolu</td>
            <td class="tabElem"><?php echo $results[$i]['date']; ?></td>
            <td class="tabElem">
                <a href = "report_<?php echo $tableName; ?>.php?id=<?php echo $results[$i]['id']; ?>" class="updateButton"><span class="material-symbols-outlined">edit</span></a>
            </td>
        </tr>
    <?php 
        endfor;
    } 
    
  }

  getReports($user, 'user');
  getReports($post, 'post');
  getReports($review, 'review');

  
  
?>
</table>
    </div>

</main>
</body>
</html>

<!-- TO DO:

- tweak the sql bits in order to display names, pictures...More meaningful information than ids. Might be tricky as this suggests turning the column names into parameters

- fetch to delete row when confirmation page "ok" clicked. Also suggests potential php function tweaks in order to put html ids and classes that'll pass into the php script-->

