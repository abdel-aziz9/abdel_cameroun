<?php
session_start();
require 'config.php'; require 'functions.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');
if ($_SERVER['REQUEST_METHOD']=='POST') {
  $from = $_POST['from_currency'];
  $to = $_POST['to_currency'];
  $amount = floatval($_POST['amount']);
  $rate = get_rate($to,$pdo);
  $result_amount = $amount * $rate;
  $receipt = upload_receipt($_FILES['receipt']);
  $stmt = $pdo->prepare("INSERT INTO orders (user_id,from_currency,to_currency,amount,rate,result_amount,payment_receipt,status)
    VALUES (?,?,?,?,?,?,?,?)");
  $stmt->execute([$_SESSION['user_id'], $from, $to, $amount, $rate, $result_amount, $receipt, 'en_attente']);
  header('Location: dashboard.php');
  exit;
}
?>
<form method="post" enctype="multipart/form-data">
  <select name="from_currency" required>
    <option value="CFA">CFA</option><option value="NGN">NGN</option>
    <option value="XOF">XOF</option><option value="USDT">USDT</option>
    <option value="BTC">BTC</option><option value="XRP">XRP</option>
    <option value="TRX">TRX</option><option value="SOL">SOL</option>
  </select>
  <select name="to_currency" required>
    <option value="NGN">NGN</option><option value="CFA">CFA</option>
    <option value="XOF">XOF</option><option value="USDT">USDT</option>
    <option value="BTC">BTC</option><option value="XRP">XRP</option>
    <option value="TRX">TRX</option><option value="SOL">SOL</option>
  </select>
  <input type="number" name="amount" required min="1">
  <input type="file" name="receipt" required>
  <button type="submit">Créer</button>
</form>