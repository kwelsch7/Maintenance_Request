<?php
	// POST == Save
	function post()
	{
		require "mr_config.php"
		global $conn;	
		global $_POST;
		$conn = openDB($servername, $dbname, $username, $password, $conn);
		$dtPattern = "^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$"; // I think this is less specific, allowing more than just -, but still in YYYY-MM-DD format
		$phonePattern = "^[2-9]\d{2}-\d{3}-\d{4}$"; // This should be more specific, like pertaining to what I set it up to be in the .js file
		
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
		if(!preg_match($dtPattern ,$dt) || !preg_match($phonePattern ,$phoneNumber))
		{
			echo "Mismatched Regex";
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
	
?>