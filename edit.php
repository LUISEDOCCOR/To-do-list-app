<?php 

    require "database.php";

  


    session_start();
    if(!isset($_SESSION["user"])){
      header("Location: index.php");
      return;
    }
    
    $error = "";


    $statement = $conn->prepare("SELECT * FROM dolist WHERE id = :id LIMIT 1");
    $statement->execute([":id" => $_GET["id"]]);

    if($statement->rowCount() == 0){
      http_response_code(404);
      echo("HTTP ERROR 404 NOT FOUND");
      return;
    }

    $dolist = $statement->fetch(PDO::FETCH_ASSOC);

    if($dolist["user_id"] !== $_SESSION["user"]["id"]){
      http_response_code(403);
      echo("HTTP 403 UNAUTHORIZED");
      return;
    };



    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty($_POST["title"]) || empty($_POST["subtitle"]) || empty($_POST["notes"])  ){
            $error = "Fill in all the fields";

        }else{
          $statement = $conn->prepare("UPDATE dolist SET title = :title, subtitle = :subtitle, notes = :notes WHERE id = :id");
          $statement->execute([
            ":id" => $_GET["id"],
            ":title" => $_POST["title"],
            ":subtitle" => $_POST["subtitle"],
            ":notes" => $_POST["notes"]
            
           
          ]);    

          
            
          header("Location: home.php");
        }

    }

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
                  <a class="nav-link" href="home.php">Home</a>
                  <a class="nav-link" href="add.php">Add new to do</a>
                  <a class="nav-link" href="logout.php">Logout</a>
                </div>
              </div>
            </div>
          </nav>
    </header>
    <main class="mt-3 mx-4">
        <?php if(!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
              <?=$error?>
            </div>
        <?php endif?>    
        <form method="POST" action="edit.php?id=<?=$dolist["id"] ?>" class="d-flex flex-column ">
            <div class="mb-3" >
              <label  class="form-label">Title</label>
              <input  value="<?=$dolist["title"] ?>" type="text" class="  form-control custom-input" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label  class="form-label">Subtitle</label>
              <input value="<?=$dolist["subtitle"] ?>" type="text" class="form-control custom-input" id="subtitle" name="subtitle">
            </div>
            <div class="mb-3">
                <label    class="form-label">Notes</label>
                <input value="<?=$dolist["notes"] ?>" type="text" class="form-control  custom-input" id="notes" name="notes">
              </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary custom-button">Apply</button>
              <a href="home.php?>" class="btn btn-danger custom-a">Cancel</a>
            </div>
        </form>
    </main>

    
</body>
</html>