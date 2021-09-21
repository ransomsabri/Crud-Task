<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $pdo->prepare('SELECT * FROM department');
$statement->execute();
$departments = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $pdo->prepare('SELECT * FROM project ORDER BY id ASC');
$statement->execute();
$projects = $statement->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}


$statement = $pdo->prepare('SELECT * FROM project WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$project = $statement->fetch(PDO::FETCH_ASSOC);


$errors = [];

$id = $project['id'];
$name = $project['name'];
$budget = $project['budget'];
$department = $project['department'];
$description = $project['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $budget = $_POST['budget'];
    $department = $_POST['department'];
    $description = $_POST['description'];

    if (!$name) {
        $errors[] = "Please provide the department's name";
    }

    if (!$errors) {

        $statement = $pdo->prepare('UPDATE project SET name = :name, budget = :budget, department = :department, description = :description WHERE id = :id');
       $statement->bindValue(':id',$id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':budget', $budget);
        $statement->bindValue(':department', $department);
        $statement->bindValue(':description', $description);
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
    <h1>Update Project</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <div><?php echo $error ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <br><br>
    <form action="" method="post">
        <div class="mb-3">
            <label>ID</label>
            <input type="number" name="id" value="<?php echo $project['id']?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $project['name']?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Budget</label>
            <input type="number" name="budget" value="<?php echo $project['budget']?>" step=".01" class="form-control">
        </div>
        <div class="mb-3">
            <label>Department</label>
            <select name="department" class="form-select" aria-label="Default select example">
                <option selected><?php echo $project['department'] ?></option>
                <?php foreach ($departments as $i=> $department):?>
                    <option><?php echo $department['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <input type="text" name="description" value="<?php echo $project['description']?>" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

</div>
</body>
</html>