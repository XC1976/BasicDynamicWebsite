<!-- Verify if there is items in cart and if yes show the number -->
<?php
$numberOfCartItems = 0;
if (isset($_SESSION['cartItems']) && !empty($_SESSION['cartItems'])) {

   foreach ($_SESSION['cartItems'] as $item) {
      $numberOfCartItems++;
   }
}

?>

<!--==================== HEADER ====================-->
<header class="header" id="header">
   <nav class="nav container">
      <a href="<?= $rootPath . 'index.php'; ?>" class="nav__logo"><img src="<?= $rootPath . 'assets/img/logo.png'; ?>"
            alt="Logo"></a>

      <div class="nav__menu" id="nav-menu">
         <ul class="nav__list">

            <li class="nav__item">
               <a href="<?php echo $rootPath . 'pages/livres/biblioteque.php' ?>" class="nav__link">Bibliothèque</a>
            </li>

            <li class="nav__item">
               <a href="<?= $rootPath ?>pages/Forum/accueil.php" class="nav__link">Forum</a>
            </li>

            <a href="<?= $rootPath . 'pages/challenge/challengeList.php' ?>" class="nav__link">Challenges</a>

            <li class="nav__item">
               <a href="<?= $rootPath . 'pages/dm/messagerie.php' ?>" class="nav__link">Messagerie</a>
            </li>

            <li class="nav__item">
               <a href="<?= $rootPath . 'pages/marketplace/shop.php' ?>" class="nav__link">Marketplace</a>
            </li>

            <?php if (isset($_SESSION['auth'])): ?>
               <li class="nav__item">
                  <a href="<?= $rootPath . 'pages/marketplace/orders.php' ?>" class="nav__link">Commandes</a>
               </li>
            <?php endif; ?>

            <li class="nav__item">
               <a href="<?= $rootPath . 'pages/marketplace/currentUserProducts.php' ?>" class="nav__link">Vos
                  produits</a>
            </li>
            <?php if (isset($_SESSION['admin'])): ?>

            <?php endif; ?>

            <?php if (isset($_SESSION['auth'])): ?>
               <li class="nav__item deconnexionLink">
                  <a href="<?= $rootPath . 'scripts/deconnexion.php' ?>" class="nav__link">Déconnection</a>
               </li>
            <?php endif; ?>
         </ul>

         <!-- Close button -->
         <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
         </div>
      </div>

      <div class="nav__actions">
         <!-- Shopping button -->

         <?php if (isset($_SESSION['auth'])): ?>
            <a href="<?= $rootPath . 'pages/marketplace/cart.php'; ?>" class="shoppingButton">
               <i class="fa-solid fa-cart-shopping"></i>
            </a>
         <?php else: ?>
            <a class="shoppingButton" onclick="triggerLoggingScreen()">
               <i class="fa-solid fa-cart-shopping"></i>
            </a>
         <?php endif; ?>

         <span id="numberCartItemNavbarFront"><?= $numberOfCartItems; ?></span>

         <!-- Search button -->
         <i class="ri-search-line nav__search" id="search-btn"></i>

         <!-- Fait disparaître le button connection et le remplace par la profile pic si connecté -->
         <?php if (!isset($_SESSION['auth'])): ?>
            <i class="ri-user-line nav__login" id="login-btn"></i>
         <?php else: ?>
            <a href="<?= $rootPath . 'pages/Profil/profile.php?username=' . $_SESSION['username']; ?>">
               <img src="<?= $rootPath . 'assets/img/profilPic/' . $_SESSION['profile_pic']; ?>" alt="profile"
                  class="profilPicImg" />
            </a>
         <?php endif; ?>

         <!-- Toggle button -->
         <div class="nav__toggle" id="nav-toggle">
            <i class="ri-menu-line"></i>
         </div>
      </div>
   </nav>
</header>

<!--==================== SEARCH ON CLICK ====================-->
<div class="search" id="search">
   <form action="" class="search__form">
      <div class="searchbar">
         <input type="search" placeholder="Rechercher un livre ou un utilisateur" class="search__input"
            id="search_input" oninput="searchBooks()">
         <i class="ri-search-line search__icon"></i>
      </div>
      <div id="results" class="results">
      </div>
   </form>
   <i class="ri-close-line search__close" id="search-close"></i>
</div>

<!--==================== LOGIN ON CLICK ====================-->
<div class="login" id="login">
   <form action="<?= $rootPath . 'scripts/connection_verify.php'; ?>" class="login__form" method="POST">
      <h2 class="login__title">Connexion</h2>

      <div class="login__group">
         <div>
            <label for="email" class="login__label">Email</label>
            <input type="text" placeholder="Écrivez votre e-mail" id="email" class="login__input" name="email"
               value="<?= isset($_COOKIE['email']) ? $_COOKIE['email'] : ''; ?>">
         </div>

         <div>
            <label for="password" class="login__label">Password</label>
            <input type="password" placeholder="Entrer votre mot de passe" id="password" class="login__input"
               name="password" value="<?= isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>">
         </div>
      </div>

      <div>
         <p class="login__signup">
            Vous n'avez pas de compte ? <a href="<?= $rootPath . 'pages/Inscription/inscription.php'; ?>">Création de
               compte</a>
         </p>

         <a href="<?php echo $rootPath . 'pages/Inscription/forgot-pw.php' ?>" class="login__forgot">
            J'ai oublié mon mot de passe
         </a>

         <div class="rememberMe">
            <input type="checkbox" id="remember-me" name="remember-me" <?= isset($_COOKIE['password']) ? 'checked' : ''; ?>>
            <label for="remember-me">Restez connecté</label>
         </div>

         <button type="submit" class="login__button" name="validate">Identifiez-vous</button>
      </div>
   </form>

   <i class="ri-close-line login__close" id="login-close"></i>
</div>