<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$stmt = $pdo->prepare('SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC');
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>
<h1>Mon Profil</h1>
Nom: <?= htmlspecialchars($user['username']) ?><br>
Email: <?= htmlspecialchars($user['email']) ?><br>
Téléphone: <?= htmlspecialchars($user['phone']) ?><br>
<a href="order_new.php">Nouvel échange</a> | <a href="logout.php">Déconnexion</a>
<hr>
<h2>Mes transactions</h2>
<table border="1">
  <tr><th>Montant</th><th>De</th><th>À</th><th>Statut</th><th>Date</th><th>Reçu</th></tr>
  <?php foreach($orders as $o): ?>
    <tr>
      <td><?= $o['amount'] ?></td>
      <td><?= $o['from_currency'] ?></td>
      <td><?= $o['to_currency'] ?></td>
      <td><?= $o['status'] ?></td>
      <td><?= $o['created_at'] ?></td>
      <td>
        <?php if ($o['payment_receipt']) echo '<a href="uploads/'.$o['payment_receipt'].'" target="_blank">Voir</a>'; ?>
      </td>
    </tr>
  <?php endforeach; ?>
</table>