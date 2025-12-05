<?php
session_start();
require '../config.php';
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $user = $_POST['username'];
  $pass = $_POST['password'];
  $stmt = $pdo->prepare('SELECT id,password,role FROM users WHERE username=? OR email=? AND role="admin"');
  $stmt->execute([$user,$user]);
  $row = $stmt->fetch();
  if ($row && password_verify($pass,$row['password'])){
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    header('Location: dashboard.php');
    exit;
  }
  $error = "Login incorrect.";
}
?>
<form method="post">
  <input name="username" required>
  <input name="password" required type="password">
  <button type="submit">Connexion admin</button>
  <?php if(isset($error)) echo '<span style="color:red">'.$error.'</span>'; ?>
</form>