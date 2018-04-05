<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  <title>I.S.M. - Login</title>
	  
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
	  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	  
	  <!-- Bulma Version 0.6.0 -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
	  <link rel="stylesheet" type="text/css" href="../css/login.css">
	</head>
	
	<body bgcolor="ffffff">
	  <?php
			$username = $password = "";
			
			session_start();
			
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
	  <section >
		<div class="hero-body">
		  <div class="container has-text-centered">
			<div class="column is-4 is-offset-4">
			  <div class="box">
			  
				<figure class="avatar">
				  <img src="Images/3NEK.png">
				</figure>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				
				  <div class="field">
					<div class="control">
					  <input class="input is-large" type="username" name="username" placeholder="User Name" autofocus="">
					</div>
				  </div>

				  <div class="field">
					<div class="control">
					  <input class="input is-large" type="password" name="password" placeholder="Password">
					</div>
				  </div>
				  
				  <?php 
					if ($_SERVER['REQUEST_METHOD'] == 'POST') 
					{
						if (!$loginCorrect) 
						{
							echo "<span style='color: red;'>Invalid login information, please try again.</span>";
						}
					}
				  ?>
				  
				  <input type="submit" value="Login" class="button is-block is-info is-large is-fullwidth">
				</form>
					
				
				
			  </div>
			</div>
		  </div>
		</div>
	  </section>
	  <script async type="text/javascript" src="../js/bulma.js"></script>
	</body>
</html>