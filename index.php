<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=dp_crud','root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare('SELECT * FROM department');
$statement->execute();
$departments = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement = $pdo->prepare('SELECT * FROM project');
$statement->execute();
$projects = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Backend Task</title>
  </head>
  <body>
  <div class="container">
  <h1>Departments</h1>
  <a href="add_department.php" class="btn btn-success">Create a Department</a>
  <table class="table">
      <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Manager</th>
          <th scope="col">Action</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($departments as $i => $department):?>
          <tr>
              <th scope="row"><?php echo $i+1 ?></th>
              <td><?php echo $department['name'] ?></td>
              <td><?php echo $department['manager'] ?></td>
              <td>
                  <a href="edit.php?name=<?php echo $department['name']?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form style="display: inline-block" method="post" action="delete_department.php">
                      <input type="hidden" name="name" value="<?php echo $department['name']?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
              </td>
          </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
  </div>

 <div class="container">
  <h1>Projects</h1>
  <a href="add_project.php" class="btn btn-success">Create a Project</a>
  <table class="table">
      <thead>
      <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Budget</th>
          <th scope="col">Department</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
      </tr>
      </thead>
      <tbody>
      <?php foreach ($projects as $i => $project):?>
          <tr>
              <th scope="row"><?php echo $i+1 ?></th>
              <td><?php echo $project['name'] ?></td>
              <td><?php echo $project['budget'] ?></td>
              <td><?php echo $project['department'] ?></td>
              <td><?php echo $project['description'] ?></td>
              <td>
                  <button type="button" class="btn btn-sm btn-outline-primary">Edit</button>
                  <form style="display: inline-block" method="post" action="delete_project.php">
                      <input type="hidden" name="name" value="<?php echo $project['name']?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
              </td>
          </tr>
      <?php endforeach; ?>
      </tbody>
  </table>
 </div>


  </body>
</html>