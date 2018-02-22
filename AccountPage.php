<html>
	<head>
		<title>This thing</title>
		
		<link rel="stylesheet" type="text/css" href="CSS/Style.css">
	</head>
	
	<body> 
		<!--This is for the header and navigation-->
		<div>
		</div>
		
		<!--Main body of stuff-->
		<div>
				<p>
					Account of: 
					<?php session_start();
						echo $_SESSION['login'];
					?>
				</p>
		</div>
	</body>
</html>