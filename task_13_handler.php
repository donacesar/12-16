<?php
session_start();

$_SESSION['count']++;
header('Location: task_13.php');