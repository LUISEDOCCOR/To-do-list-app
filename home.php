<?php 

session_start();


require "database.php";
$dolist = $conn->query("SELECT * FROM dolist WHERE user_id = {$_SESSION['user']['id']}");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <script defer src="./js/index.js"></script>
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/darkly/bootstrap.min.css" integrity="sha512-YRcmztDXzJQCCBk2YUiEAY+r74gu/c9UULMPTeLsAp/Tw5eXiGkYMPC4tc4Kp1jx/V9xjEOCVpBe4r6Lx6n5dA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <title>To do list</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary">
            <div class="container-fluid">
               <a class="navbar-brand" href="index.php">To do list</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                  <a class="nav-link" href="#">Home</a>
                  <a class="nav-link" href="add.php">Add new to do</a>
                  <a class="nav-link" href="logout.php">Logout</a>
                  <a class="nav-link" ><?=$_SESSION["user"]["email"]?></a>
                </div>
              </div>
            </div>
          </nav>
    
    </header>
    <main>
      <?php if($dolist->rowCount() == 0): ?>
        <div class="d-flex justify-content-center">
          <div class="col-md-4 mx-3">
            <div class="card card-body text-center">
              <p>No notes</p>
              <a href="add.php">Add a note</a>
            </div>
          </div>
        </div>
      <?php die();?>
      <?php  endif ?>
       <div class="mt-5 mx-3">
        <?php foreach($dolist as $list):  ?>
          <div class="card mt-3">
                  <h5 class="card-header"><?= $list["title"] ?></h5>
                    <div class="card-body">
                    <h5 class="card-title"><?= $list["subtitle"] ?></h5>
                    <p class="card-text"><?= $list["notes"] ?></p>
                    <div class="d-flex gap-2 flex-wrap">
                      <a href="completed.php?id=<?=$list["id"]?>" class="btn btn-success ">Completed</a>
                      <a href="edit.php?id=<?=$list["id"]?>" class="btn btn-warning">Edit</a>
                      <a href="delete.php?id=<?=$list["id"]?>" class="btn btn-danger">Delete</a>
                      </div>
                  </div>
              </div>
          <?php endforeach  ?>
        </div>
        <div class="d-flex  flex-row-reverse p-2 me-2 mt-3">
            <a href="add.php">
              <button type="button" class=" btn btn-primary">Add new to do</button>
            </a>
        </div>
    </main>

    
</body>
</html>