<?php
	// PUT == Update
	function put()
	{
		require "mr_config.php"
		
		$conn = openDB($servername, $dbname, $username, $password, $conn);
		
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
			
			//echo $key;
		}
	}
	
?>