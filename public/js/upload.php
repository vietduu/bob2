<?php
	header('Access-Control-Allow-Origin: *');
	$protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ? "https://" : "http://";  
	$root = $_SERVER['DOCUMENT_ROOT'] . '/bob2/public/' . $_POST['url'];
	move_uploaded_file($_FILES["image"]["tmp_name"], $root. $_FILES["image"]["name"]);
?>