<?php 
session_start();

function get_pdo() {
	$pdo = new PDO("mysql:host=localhost;dbname=my_database;charset=utf8", 'root', 'root');
	return $pdo;
}

function all_images() {
	$pdo = get_pdo();
	$statement = $pdo->prepare("SELECT * FROM images");
	$statement->execute();
	$images = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $images;
}

function redirect($url) {
	header("Location: " . $url);
	exit;
}

function img_filename($id) {
	$pdo = get_pdo();
	$statement = $pdo->prepare("SELECT * FROM images WHERE id=:id");
	$statement->execute(['id' => $id]);
	$img = $statement->fetch(PDO::FETCH_ASSOC);
	return $img['image'];
}

function remove_img_from_db($id) {
	$pdo = get_pdo();
	$statement = $pdo->prepare("DELETE FROM images WHERE id=:id");
	$statement->execute(['id' => $id]);
}

function remove_from_folder($filename) {

	unlink($filename);
}


$id = $_GET['id'];

$name = img_filename($id);

remove_img_from_db($id);

remove_from_folder($name);

$_SESSION['images'] = all_images();

redirect('task_17.php');