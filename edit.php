<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$name = $_GET['name'] ?? null;
if (!$name){
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM department WHERE name = :name');
$statement->bindValue(':name', $name);
$statement->execute();
$department = $statement->fetch(PDO::FETCH_ASSOC);


$errors = [];

$name = $department['name'];
$manager = $department['manager'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $manager = $_POST['manager'];

    if (!$name) {
        $errors[] = "Please provide the department's name";
    }

    $statement = $pdo->prepare('UPDATE department SET name=:name, manager=:manager');
    if (!$errors) {
        $statement->bindValue(':name', $name);
        $statement->bindValue(':manager', $manager);
        $statement->execute();
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
    <h1>Update Department</h1>
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
            <label>Department Name</label>
            <input type="text" class="form-control">
        </div>
        <div class="mb-3">
            <label>Department Manager</label>
            <input type="text" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
</body>
</html>