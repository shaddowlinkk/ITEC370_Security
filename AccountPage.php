<html>
	<head>
		<title>I.S.M - Acount Page</title>
		
		<link rel="stylesheet" type="text/css" href="CSS/Style.css">
	</head>
	
	<body> 
		<!--This is for the header and navigation-->
		<div>
		</div>
		
		<!--Main body of stuff-->
		<div class="box">
			<div class="content">
				<p>
					Account of: 
					<?php session_start();
						echo $_SESSION['login'];
					?>
				</p>
			</div>
		</div>
	</body>
</html>