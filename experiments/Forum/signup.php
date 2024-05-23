<?php require('actions/signupAction.php');?>

<!DOCTYPE html>
<html lang="fr">
    <?php include 'includes/head.php'; ?>
<body>
    
  <?php if(isset($errorMsg)) {echo '<p>' . $errorMsg . '</p>';} ?>

<form method="POST">
  <div>
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email">
  </div>
  <div>
    <label for="exampleInputEmail1">Pseudo</label>
    <input type="text" name="pseudo">
  </div>
  <div>
    <label for="exampleInputEmail1">Nom</label>
    <input type="text" name="lastName">
  </div>
  <div>
    <label for="exampleInputEmail1">Prénom</label>
    <input type="text" name="firstName">
  </div>
  <div>
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary" name="validate">Submit</button>
</form>

<a href="login.php"><p>J'ai déjà un compte je me connecte</p></a>
</body>
</html>