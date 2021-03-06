<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];

$id = '';
$name = '';
$manager = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST ['id'];
    $name = $_POST['name'];
    $manager = $_POST['manager'];

    if (!$name) {
        $errors[] = "Please provide the department's name";
    }
    if (!$id) {
        $errors[] = "Please provide the department's ID";
    }
    if (!$errors) {
        $statement = $pdo->prepare('INSERT INTO department (id, name, manager) VALUES (:id, :name, :manager)');
        $statement->bindValue(':id', $id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':manager', $manager);
        $statement->execute();
        header('Location: index.php');

    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Backend Task</title>
</head>
<body>
<div class="container">
    <h1>Add a new Department</h1>
    <a href="index.php" style="float: right" class="btn btn btn-primary">Back</a>
    <br><br>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br><br>
    <form action="add_department.php" method="post">
        <div class="mb-3">
            <label>ID</label>
            <input type="number" name="id" class="form-control">
        </div>
        <div class="mb-3">
            <label>Department Name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label>Department Manager</label>
            <input type="text" name="manager" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
</body>
</html>