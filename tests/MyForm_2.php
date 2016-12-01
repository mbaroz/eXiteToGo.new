<!DOCTYPE HTML>
<html> 
	<title>My Form</title>

	<body>
		<h2>Person Details:</h2>

		<form id="MainForm"  action="<?php echo htmlspecialchars('Database_2.php'); ?>" method="post">
		
			 Last Name: <br>
			 <input type="text" name="lastName"><br><br>
			 
			 Id:<br>
			 <input type="number" name="id"><br><br>
			 <br>
			 
			 <input type="submit" name="Update" value="Update">
			 <input type="submit" name="Delete" value="Delete">			

		 </form>
	</body>
</html>
