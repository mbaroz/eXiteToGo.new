<!DOCTYPE HTML>
<html> 
	<body>
		
		 <?php  

			if(!empty($_REQUEST['Update']))
			{				
			  	UpdateDatabase();			  	
			}
			else
			if(!empty($_REQUEST['Delete']))
			{				  	
			  	DeletePersonById();			
			}

				
			function DeletePersonById(){
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "myDB";

				// Create connection
				 $conn = mysqli_connect($servername, $username, $password, $dbname);
				 // Check connection
				 if (!$conn) {
				     die("Connection failed: " . mysqli_connect_error());
				}

				$id = $_POST["id"];
				$sql = "DELETE FROM MyPerson WHERE id=" . $id ;				

				if (mysqli_query($conn, $sql)) {
				    echo "Record deleted successfully";
				} else {
				    echo "Error deleting record: " . mysqli_error($conn);
				}

				mysqli_close($conn);
			}

			function UpdateDatabase(){
				$servername = "localhost";
				$username = "root";
				$password = "root";
				$dbname = "myDB";

				// Create connection
				 $conn = mysqli_connect($servername, $username, $password, $dbname);
				 // Check connection
				 if (!$conn) {
				     die("Connection failed: " . mysqli_connect_error());
				}
				
				$lastName = $_POST["lastName"];
				$id = $_POST["id"];
				$sql = "UPDATE MyPerson SET lastname='" . $lastName . "' WHERE id=" . $id;
				
				if (mysqli_query($conn, $sql)) {
				    echo "Record updated successfully";
				} else {
				    echo "Error updating record: " . mysqli_error($conn);
				}

				mysqli_close($conn);				
			}
		?>
	</body>
</html>
