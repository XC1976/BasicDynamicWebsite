<!-- requirements are:
              <link rel = "stylesheet" href = "../assets/css/general/components/navbar_back.css">
              <link rel = "stylesheet" href = "../assets/css/general/components/general_back.css">-->


              <!-- indicates the grid area this div belongs to -->
              
<div class = "grid-container">

    <!-- ==================================== HEADER ====================================== -->
<header class ="header">

<!-- left side of the header which contains a search bar that must later display all elements that start with those characters ordered by type -->
<div class = "header-left">
<input type="search" oninput ="search()" id="searchBar" placeholder="Rechercher">
<div id = "searchElems"></div>
</div>

<!--right side, made of 2 icons that redirects to home (the dashboard?) and to the admin's profile-->
<div class = "header-right">
<a href = "../scripts/deconnexion.php">
<span class="material-symbols-outlined">logout</span>
</a>

<a href = "..">
<span class="material-symbols-outlined">home</span>
</a>

</div>
</header>


    <!-- ==================================== NAVBAR ========================================--> 

<div class = "sidebar">
    <div class="sidebar-title">
          <div class="sidebar-brand">
          <a href = "../backOffice/frontPage.php">  <!-- logo redirects to openreads front page when clicked -->
            <img class = "logo" src = "../assets/img/logo.png" height="20px"> Openreads
          </a>
    </div>
</div>

    <ul class = "sidebar-list">
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/users.php';">
            <a href = "../backOffice/users.php">utilisateurs</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/authors.php';">
            <a href = "../backOffice/authors.php">auteurs</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/books.php';">
            <a href = "../backOffice/books.php">livres</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/forum.php';">
            <a href = "../backOffice/forum.php">forum</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/captcha.php';">
            <a href = "../backOffice/captcha.php">captcha</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/marketplace.php';">
            <a href = "../backOffice/marketplace.php">marketplace</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/database_destruction.php';">
            <a href = "../backOffice/database_destruction.php">database management</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/newsletter.php';">
            <a href = "../backOffice/newsletter.php">newsletter</a>
        </li>
        <li class = "sidebar-list-item" onclick="window.location.href='../backOffice/logs.php';">
            <a href = "../backOffice/logs.php">logs</a>
        </li>
    </ul> 

</div>