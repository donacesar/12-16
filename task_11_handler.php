<?php
session_start();

function redirect($url) {
	header("Location: " . $url);
	exit;
}

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$pdo = new PDO("mysql:host=localhost;dbname=my_database;charser=utf8", 'root', 'root');

$statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!empty($user)) {
	$_SESSION['message'] = 'Этот эл адрес уже занят другим пользователем';
	redirect('task_11.php');
}

$statement = $pdo->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
$statement->execute([':email' => $email, ':password' => $password]);

redirect('task_11.php');