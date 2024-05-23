<?php require('actions/loginAction.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include 'includes/head.php'; ?>
</head>
<body>

<?php if(isset($errorMsg)) {echo '<p>' . $errorMsg . '</p>';} ?>

<form method="POST">
  <div>
    <label for="exampleInputEmail1">Pseudo</label>
    <input type="text" name="pseudo">
  </div>
  <div>
  <div>
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password">
  </div>
  <button type="submit" class="btn btn-primary" name="validate">Submit</button>

  <a href="signup.php"><p>Je n'ai pas de compte, je m'inscris</p></a>
</form>

</body>
</html>