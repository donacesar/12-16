<?php

$text = $_POST['text'];

$pdo = new PDO('mysql:host=localhost;dbname=my_database;charser=utf8','root', 'root' ); 

$statement = $pdo->prepare("INSERT INTO text (text) VALUE (:text)");
$statement->execute([':text' => $text]);

header("Location: task_9.html");