<?php
// ... after admin authentication ...
if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['order_id'], $_POST['action'])) {
    $statut = $_POST['action']; // verifie, rejete, paye
    $comm = $_POST['comment'] ?? '';
    $stmt = $pdo->prepare("UPDATE orders SET status=?, comment=?, updated_at=NOW() WHERE id=?");
    $stmt->execute([$statut, $comm, $_POST['order_id']]);
    header("Location: orders.php?msg=Etat+mis+à+jour");
    exit;
}
// Affichage tableau des ordres