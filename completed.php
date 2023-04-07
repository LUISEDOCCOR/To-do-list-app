<?php

session_start();
if(!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
}


require "database.php";

$statement = $conn->prepare("SELECT * FROM dolist WHERE id = :id LIMIT 1");
$statement->execute([":id" => $_GET["id"]]);

$dolist = $statement->fetch(PDO::FETCH_ASSOC);

if($dolist["user_id"] !== $_SESSION["user"]["id"]){
    http_response_code(403);
    echo("HTTP 403 UNAUTHORIZED");
    return;
  };


if ($statement->rowCount() == 0 ){
    http_response_code(404);
    echo("HTTP ERROR 404 NOT FOUND");
}else{
    $statement = $conn->prepare("DELETE FROM dolist WHERE id = :id");
    $statement->execute([":id" => $_GET["id"]]);
}

header("Location: home.php");