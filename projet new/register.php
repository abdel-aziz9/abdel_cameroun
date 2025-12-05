<?php
require 'config.php'; require 'functions.php';
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);
  $password = hash_password($_POST['password']);
  $stmt = $pdo->prepare('INSERT INTO users(username,email,password,phone) VALUES(?,?,?,?)');
  $stmt->execute([$username,$email,$password,$phone]);
  header('Location: login.php');
  exit;
}
?>
<form method="post">
  <input name="username" required placeholder="Nom d'utilisateur"><br>
  <input name="email" required type="email" placeholder="Email"><br>
  <input name="phone" required placeholder="Téléphone"><br>
  <input name="password" required type="password" placeholder="Mot de passe"><br>
  <button type="submit">Inscription</button>
</form>