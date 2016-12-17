<?php
	// DELETE == delete
	function delete()
	{
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
	}
	
?>