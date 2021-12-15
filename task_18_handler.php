<?php
session_start();

function empty_form() {
	if(empty($_FILES['image']['name'][0])) {
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

function upload_file($tmp_name, $name) {
	move_uploaded_file($tmp_name, 'images/' . $name);
}

function save_in_db($name) {
	$file = __DIR__ . '/images/' . $name;
	$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
	$statement = $pdo->prepare("INSERT INTO images (image) VALUES (:image)");
	$statement->execute([':image' => 'images/' . $name]);
}

function all_images() {
	$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
	$statement = $pdo->prepare("SELECT * FROM images");
	$statement->execute();
	$images = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $images;
}

if (empty_form()) {
	redirect('task_18.php');
}



for ($i=0; $i < count($_FILES['image']['name']); $i++) { 
	$name = filename_generate($_FILES['image']['name'][$i]);
	$tmp_name = $_FILES['image']['tmp_name'][$i];
	upload_file($tmp_name, $name);
	save_in_db($name);
}




$_SESSION['images'] = all_images();

redirect('task_18.php');