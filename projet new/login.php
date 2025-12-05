<?php
session_start();
require 'config.php';
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $stmt = $pdo->prepare('SELECT id,password,role FROM users WHERE username=? OR email=?');
  $stmt->execute([$user,$user]);
  $row = $stmt->fetch();
  if ($row && password_verify($pass,$row['password'])){
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    header('Location: '.($row['role']=='admin'?'admin/dashboard.php':'dashboard.php'));
    exit;
  }
  $error = "Login incorrect.";
}
?>
<form method="post">
  <input name="username" required placeholder="Username ou Email"><br>
  <input name="password" required type="password" placeholder="Mot de passe"><br>
  <button type="submit">Connexion</button>
  <?php if(isset($error)) echo '<span style="color:red">'.$error.'</span>'; ?>
</form>