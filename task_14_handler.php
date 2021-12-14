<?php
session_start();

function error_redirect($url, $msg) {
	$_SESSION['error_message'] = $msg;
	header("Location: " . $url);
	exit;
}

$email = $_POST['email'];
$password = $_POST['password'];

$pdo = new PDO("mysql:host=localhost;dbname=my_database;charser=utf8", 'root', 'root');

$statement = $pdo->prepare("SELECT * FROM users WHERE email=:email");
$statement->execute(['email' => $email]);
$user = $statement->fetch(PDO::FETCH_ASSOC);

if(empty($user) || !password_verify($password, $user['password'])) {
	error_redirect('task_14.php', 'Неверный логин или пароль');
}

$_SESSION['login'] = $user['email'];
var_dump($_SESSION['login']);

