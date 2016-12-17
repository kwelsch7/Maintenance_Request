<?php
	require "mr_post.php";
	require "mr_put.php";
	require "mr_delete.php";
	
	$method = $_SERVER['REQUEST_METHOD'];
	
	// POST == Save, PUT == Update, DELETE == Delete
	switch($method)
	{
		case "POST":
			post();
			break;
		case "PUT":
			put();
			break;
		case "DELETE";
			delete();
			break;
		default:
			exit(http_response_code(400));
	}
?>