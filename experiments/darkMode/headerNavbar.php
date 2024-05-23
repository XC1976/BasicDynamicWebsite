<!--==================== HEADER ====================-->
<header class="header" id="header">
         <nav class="nav container">
            <a href="<?= $indexPHPPath; ?>" class="nav__logo"><img src="<?= $logoPath; ?>" alt="Logo"></a>

            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li class="nav__item">
                     <a href="#" class="nav__link">Accueil</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Compte</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Genres</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Forum</a>
                  </li>

                  <li class="nav__item">
                     <a href="#" class="nav__link">Contactez-nous</a>
                  </li>
                  <img src="assets/img/darkMode/moon.png" alt="Toggle dark mode" id="darkModeIcon">
               </ul>

               <!-- Close button -->
               <div class="nav__close" id="nav-close">
                  <i class="ri-close-line"></i>
               </div>
            </div>

            <div class="nav__actions">
               <!-- Search button -->
               <i class="ri-search-line nav__search" id="search-btn"></i>

               <!-- Login button -->
               <i class="ri-user-line nav__login" id="login-btn"></i>

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
            <i class="ri-search-line search__icon"></i>
            <input type="search" placeholder="Que cherchez-vous ?" class="search__input">
         </form>

         <i class="ri-close-line search__close" id="search-close"></i>
      </div>

      <!--==================== LOGIN ON CLICK ====================-->
      <div class="login" id="login">
         <form action="<?= $connectionPHPPath; ?>" class="login__form" method="POST">
            <h2 class="login__title">Connexion</h2>
            
            <div class="login__group">
               <div>
                  <label for="email" class="login__label">Email</label>
                  <input type="text" placeholder="Écrivez votre e-mail" id="email" class="login__input" name="email">
               </div>
               
               <div>
                  <label for="password" class="login__label">Password</label>
                  <input type="password" placeholder="Entrer votre mot de passe" id="password" class="login__input" name="password">
               </div>
            </div>

            <div>
               <p class="login__signup">
                  Vous n'avez pas de compte ? <a href="<?= $inscriptionPHPPath; ?>">Création de compte</a>
               </p>
   
               <a href="#" class="login__forgot">
                  J'ai oublié mon mot de passe
               </a>
   
               <button type="submit" class="login__button" name="validate">Identifiez-vous</button>
            </div>
         </form>

         <i class="ri-close-line login__close" id="login-close"></i>
      </div>