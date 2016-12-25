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
	
	// Regex Stuff
	$dtPattern = "/^(19|20)\d\d-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[01])$/"; // YYYY-MM-DD format (with other specifiers according to MySQL Date rules)
	$phonePattern = "/^[2-9]\d{2}-\d{3}-\d{4}$/"; // 999-999-9999 (the first digit can't be 0 or 1)
	
	// The variables in question
	$dt;
	$tenant;
	$apartmentNumber;
	$maintenanceDay;
	$immediately;
	$whenever;
	$permission;
	$timeOfDay;
	$phoneContact;
	$textContact;
	$phoneNumber;
	$description;
	
	// Open the Database Connection
	$conn = null;

	try
	{
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
		echo "Connection failed: " . $e->getMessage();
		exit(http_response_code(400));
	}
	
	// POST == Save, PUT == Update, DELETE == Delete, ELSE Populate Admin Page table
	if($_SERVER["REQUEST_METHOD"] == "POST") // do Save
	{
		$evalBools;
		// Booleans shouldn't need Trimmed
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
		
		// The .js file puts the date and phoneNumber into the proper format, but check it 
		//  against a Regex here in case it was messed with between then and now
		if(!preg_match($dtPattern, $dt))
		{
			echo "Mismatched Date Regex";
			exit(http_response_code(400));
		}
		else if(!preg_match($phonePattern, $phoneNumber))
		{
			echo "Mismatched Phone Regex";
			exit(http_response_code(400));
		}
		else
		{
			try
			{
				$stmt = $conn->prepare("INSERT INTO request_notes (dt, tenant, apartmentNumber, maintenanceDay, immediately, whenever, 
																	permission, timeOfDay, phoneContact, textContact, phoneNumber, description) 
																	VALUES (:dt, :tenant, :apartmentNumber, :maintenanceDay, :immediately, :whenever, 
																	:permission, :timeOfDay, :phoneContact, :textContact, :phoneNumber, :description)");
				$stmt->bindParam(':dt', $dt);
				$stmt->bindParam(':tenant', $tenant);
				$stmt->bindParam(':apartmentNumber', $apartmentNumber);
				$stmt->bindParam(':maintenanceDay', $maintenanceDay);
				$stmt->bindParam(':immediately', $immediately);
				$stmt->bindParam(':whenever', $whenever);
				$stmt->bindParam(':permission', $permission);
				$stmt->bindParam(':timeOfDay', $timeOfDay);
				$stmt->bindParam(':phoneContact', $phoneContact);
				$stmt->bindParam(':textContact', $textContact);
				$stmt->bindParam(':phoneNumber', $phoneNumber);
				$stmt->bindParam(':description', $description);
				
				$stmt->execute();
			}
			catch(PDOException $e)
			{
				echo "Save/Add Problem:\r\n" . $e->getMessage();
			}
			
			$conn = null;
			echo "Submission successful";
		}
	}
	else if($_SERVER["REQUEST_METHOD"] == "PUT") //do Update
	{
		/*
		// The following info is reference material from my tMDB Assignment:
		parse_str(file_get_contents("php://input"), $_PUT);
		//print_r($_PUT);
		
		$key = $_PUT["key"];
		$name = trim($_PUT["name"]);
		$year = trim($_PUT["year"]);
		$studio = trim($_PUT["studio"]);
		$price = trim($_PUT["price"]);
		
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
				$stmt = $conn->prepare("UPDATE movies_php SET name = :name, year = :year, studio = :studio, price = :price WHERE movieID = :key");
				$stmt->bindParam(':name', $name);
				$stmt->bindParam(':year', $year);
				$stmt->bindParam(':studio', $studio);
				$stmt->bindParam(':price', $price);
				$stmt->bindParam(':key', $key);
				
				$stmt->execute();
			}
			catch(PDOException $e)
			{
				echo "Update Problem:\r\n" . $e->getMessage();
			}
			
			$conn = null;
			echo "Update successful";
		}
		*/
	}
	else if($_SERVER["REQUEST_METHOD"] == "DELETE") //do Delete
	{
		/*
		require "mr_config.php"
		
		$conn = openDB($servername, $dbname, $username, $password, $conn);
		
		// The following info is reference material from my tMDB Assignment:
		parse_str(file_get_contents("php://input"), $_DELETE);
		
		$key = $_DELETE["key"];
		
		try
		{
			$stmt = $conn->prepare("DELETE FROM movies_php WHERE movieID = :key");
			$stmt->bindParam(':key', $key);
			
			$stmt->execute();
		}
		catch(PDOException $e)
		{
			echo "Delete Problem:\r\n" . $e->getMessage();
		}
		
		$conn = null;
		
		//echo $key;
		*/
	}
	else // Populate Admin Page table
	{
		try // No prepared statement needed
		{
			$sql = "SELECT * FROM request_notes ORDER BY dt DESC, description";
			$result = $conn->query($sql);
		}
		catch(PDOException $e)
		{
			echo $sql . "\r\n" . $e->getMessage(); //Not "<br>" because this will be used in console.log()
		}
		
		$conn = null;
		
		echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
	}
?>