<?php
function hash_password($password) {
  return password_hash($password, PASSWORD_DEFAULT);
}
function verify_password($password, $hash) {
  return password_verify($password, $hash);
}
function get_rate($to_curr, $pdo) {
  $stmt = $pdo->prepare('SELECT rate FROM exchange_rates WHERE currency=?');
  $stmt->execute([$to_curr]);
  return $stmt->fetchColumn() ?: 1;
}
function upload_receipt($file){
  $allowed = ['image/png','image/jpeg','application/pdf'];
  if($file['error']==0 && in_array($file['type'],$allowed)){
    $name = uniqid().'-'.$file['name'];
    move_uploaded_file($file['tmp_name'], __DIR__.'/uploads/'.$name);
    return $name;
  }
  return '';
}
function is_admin($uid, $pdo) {
  $stmt = $pdo->prepare('SELECT role FROM users WHERE id=?');
  $stmt->execute([$uid]);
  return $stmt->fetchColumn() === 'admin';
}
?>