<?php
session_start();

function empty_form() {
	if(empty($_FILES['image']['name'])) {
		return true;
	}
	return false;
}

function redirect($url) {
	header("Location: " . $url);
	exit;
}

function filename_generate($filename) {
	$extension = pathinfo($filename)['extension'];
	return uniqid() . "." . $extension;
}

function upload_file(array $image, $name) {
	$temp_filename = $image['tmp_name'];
	move_uploaded_file($temp_filename, 'images/' . $name);
}

function save_in_db($name) {
	$file = __DIR__ . '/images/' . $name;
	$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
	$statement = $pdo->prepare("INSERT INTO images (image) VALUES (:image)");
	$statement->execute(['image' => 'images/' . $name]);
}

function all_images() {
	$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
	$statement = $pdo->prepare("SELECT * FROM images");
	$statement->execute();
	$images = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $images;
}

if (empty_form()) {
	redirect('task_16.php');
}

$name = filename_generate($_FILES['image']['name']);

upload_file($_FILES['image'], $name);

save_in_db($name);

$_SESSION['images'] = all_images();

redirect('task_16.php');