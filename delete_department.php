<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


$name = $_POST['name'] ?? null;
if (!$name){
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('DELETE FROM department WHERE name = :name');
$statement->bindValue(':name', $name);
$statement->execute();
header('Location: index.php');