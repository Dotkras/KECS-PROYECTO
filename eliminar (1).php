<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: panel.php");
    exit();
}

include 'db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("DELETE FROM productos WHERE id=$id");
}

header("Location: panel.php");
exit();
?>
