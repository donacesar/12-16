<?php
session_start();
unset($_SESSION['login']);
header("Location: task_14.php");