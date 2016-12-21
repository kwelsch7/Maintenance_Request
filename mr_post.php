<?php
	// POST == Save
	function post()
	{
		require "mr_config.php"
		
		//$conn = openDB($servername, $dbname, $username, $password, $conn);
		
		$dt;
		$dt = trim($_POST["dt"]);
		$tenant = trim($_POST["tenant"]);
		$apartmentNumber = trim($_POST["apartmentNumber"]);
		$maintenanceDay = $_POST["maintenanceDay"];
		$immediately = $_POST["immediately"];
		$whenever = $_POST["whenever"];
		$permission = $_POST["permission"];
		$timeOfDay = trim($_POST["timeOfDay"]);
		$phoneContact = $_POST["phoneContact"];
		$textContact = $_POST["textContact"];
		$phoneNumber = trim($_POST["phoneNumber"]);
		$description = trim($_POST["description"]);
		
		// The following info is reference material from my tMDB Assignment:
		/*
		//hardened.js should ensure that year and price are proper numbers
		if(!preg_match($pattern ,$name) || !preg_match($pattern ,$studio))
		{
			//http_response_code(400);
			echo "fail";
		}
		else
		{
			$name = preg_replace("/'/", "\'", $name); //So apostrophes can be used
			$studio = preg_replace("/'/", "\'", $studio);
			
			try
			{
				$stmt = $conn->prepare("INSERT INTO movies_php (name, year, studio, price) VALUES (:name, :year, :studio, :price)");
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':year', $year);
				$stmt->bindParam(':studio', $studio);
				$stmt->bindParam(':price', $price);
				
				$stmt->execute();
			}
			catch(PDOException $e)
			{
				echo "Save/Add Problem:\r\n" . $e->getMessage();
			}
			
			$conn = null; //These are in each rather than at the very end so they're before the echo
			
			//echo $name;
		}*/
		
		echo "Submission successful";
	}
	
?>