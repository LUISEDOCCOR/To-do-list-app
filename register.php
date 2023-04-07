<?php 

require "database.php";

$error = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"])){
    $error = "Fill in all the fields";
  }else if(!str_contains($_POST["email"] , "@")){
    $error = "Enter a valid email";
  }else{
    $statement = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute([":email" => $_POST["email"]]);
    if($statement->rowCount() > 0){
      $error = "That email already exists, use another one";
      ;
    }else{
      $statement = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
      $statement->execute([
        ":name" => $_POST["name"],
        ":email" => $_POST["email"],
        ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT),
      ]);

      $statement = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
      $statement->execute([":email" => $_POST["email"]]);

      $user = $statement->fetch(PDO::FETCH_ASSOC);

      session_start();

      unset($user["password"]);

      $_SESSION["user"] = $user;


      header("Location: home.php");


    }




  }


};




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/darkly/bootstrap.min.css" integrity="sha512-YRcmztDXzJQCCBk2YUiEAY+r74gu/c9UULMPTeLsAp/Tw5eXiGkYMPC4tc4Kp1jx/V9xjEOCVpBe4r6Lx6n5dA==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <title>To do list</title>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
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
                  <a class="nav-link" href="register.php">Register</a>
                  <a class="nav-link" href="login.php">Login</a>
                </div>
              </div>
            </div>
          </nav>
    </header>
    <?php if(!empty($error)): ?>
      <div class="alert alert-danger" role="alert">
        <?=$error?>
      </div>
    <?php endif;?>  
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                 <form  method="POST" action="register.php" >
                  
                  <div class="mb-md-5 mt-md-4 pb-5">
      
                    <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                    <p class="text-white-50 mb-5">Create a new account now!</p>
                    
                    <div class="form-outline form-white mb-4">
                      <input type="text" id="name" class="form-control form-control-lg" name="name" />
                      <label class="form-label mt-3" for="name">Name</label>
                    </div>

                    <div class="form-outline form-white mb-4">
                      <input type="text" id="email" class="form-control form-control-lg" name="email" />
                      <label class="form-label mt-3" for="email">Email</label>
                    </div>

                    <div class="form-outline form-white mb-3">
                      <input type="password" id="password" class="form-control form-control-lg" name="password" />
                      <label class="form-label mt-3" for="password">Password</label>
                    </div>


                    <button type="submit" class="btn btn-outline-light btn-lg px-5" >Register</button>

                    

                  </div>

                 </form>       
      
                  <div>
                    <p class="mb-0">You have an account? <a href="login.php" class="text-white-50 fw-bold">Login</a>
                    </p>
                  </div>
      
                </div>
              </div>
            </div>
          </div>
        </div>
      </section> 
</body>
</html>