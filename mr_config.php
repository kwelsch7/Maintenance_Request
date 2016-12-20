<?php
	$servername = "localhost";
	
	// On the actual Server:
	//$username = "konnorwe_maintReq";
	//$password = "complaintSubmi55ion";
	//$dbname = "konnorwe_maintenance_request";
	
	// Local Testing/Debugging:
	$username = "root";
	$password = "";
	$dbname = "maintenance_request";
	
	$conn = null;

	function openDB($servername, $dbname,$username, $password, $conn)
	{
		try
		{
			$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
			$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch (PDOExcetpion $e)
		{
			echo "Connection failed: " . $e->getMessage();
		}
	}
?>