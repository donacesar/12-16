<?php
session_start();

$text = $_POST['text'];

$pdo = new PDO('mysql:host=localhost;dbname=my_database;charser=utf8','root', 'root' );
$statement = $pdo->prepare("SELECT * FROM text WHERE text=:text");
$statement->execute([':text' => $text]);
$arr = $statement->fetch(PDO::FETCH_ASSOC);

if(!empty($arr)) {
	$_SESSION['message'] = 'Dведенное значение уже присутствует в таблице.';
} else {

$statement = $pdo->prepare("INSERT INTO text (text) VALUE (:text)");
$statement->execute([':text' => $text]);

}


header("Location: task_10.php");