<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'] ?? null;
if (!$id){
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('DELETE FROM project WHERE id = :id');
$statement->bindValue(':id', $id);

