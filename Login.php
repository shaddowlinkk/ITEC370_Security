<html>
	<head>
		<title>I.S.M. - Login</title>
		
		<link rel="stylesheet" type="text/css" href="CSS/Style.css">
	</head>
	
	<body> 
		<!--This is for the header and navigation-->
		<div>
		</div>
		<!--Main body of stuff-->
		<div class="box">
			<div class="content">
			<?php
				$username = $password = "";
				
				session_start();
				
				echo "<form action=";
				echo htmlspecialchars($_SERVER["PHP_SELF"]);
				echo" method='post'>
				Username: <input type='text' name='username' class='validate' pattern='[a-z]{1,}'> <br><br>
				Password: <input type='password' name='password' class='validate' pattern='[A-z]{1,}'><br>";
				if ($_SERVER['REQUEST_METHOD'] == 'POST') 
					{
						if (!$loginCorrect) 
						{
							echo "<span style='color: red;'>Invalid login information, please try again.</span>";
						}
				}
				echo "<br><input type='submit'><br>";
				
				//Used later for pulling up the information for an account
				$_SESSION['login'] = null;
				$loginCorrect = false;
				//Upon receiving information form the submit validates information then runs it against the info array
				if ($_SERVER["REQUEST_METHOD"] == "POST") 
				{
					$username = check_input($_POST['username']);
					$password = hash('sha256',check_input($_POST['password']));
					
					//connects to the database for users
					$conn = new mysqli("localhost", "itec370", "itec", "itec370");
				
					// Check connection
					if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
					} 
					
					$query = "SELECT password, UID FROM login WHERE username= '".$username."'";
					$userlist = $conn->query($query);
					
					if ($userlist->num_rows > 0) 
					{
						// output data of each row
						while($row = $userlist->fetch_assoc())
						{
							if ($password == $row["password"])
							{
								$_SESSION['login'] = $row["UID"];
								$loginCorrect = true;
								echo "<script>location.href='AccountPage.php';</script>";
							}
						}
					}
					
					$conn->close();
				}
				
				//Used for validating data No Hackers allowed (Hopefully)
				function check_input ($data)
				{
					$data = trim($data);
					$data = stripslashes($data);
					$data = htmlspecialchars($data);
					return $data;
				}
			?>
			<!--This is the HTML for the form that the user provides input for -->
			
			</form>
		</div>
		</div>
	</body>
</html>