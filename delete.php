<?php
require "database.php";

session_start();
if(!isset($_SESSION["user"])){
    header("Location: index.php");
    return;
}

$id = $_GET["id"];

$statement = $conn->prepare("SELECT * FROM dolist WHERE id = :id");
$statement->execute([":id" => $id]);
if($statement->rowCount() == 0){
    http_response_code(404);
    echo("HTTP ERROR 404 NOT FOUND");
    die();
}

$dolist = $statement->fetch(PDO::FETCH_ASSOC);

if($dolist["user_id"] !== $_SESSION["user"]["id"]){
    http_response_code(403);
    echo("HTTP 403 UNAUTHORIZED");
    return;
  };

$statement =  $conn->prepare("DELETE FROM dolist WHERE id = :id");
$statement->execute([":id" => $id]);

header ("Location: home.php");