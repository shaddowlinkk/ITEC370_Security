<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  <title>I.S.M - Acount Page</title>
	  
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
	  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	  
	  <!-- Bulma Version 0.6.0 -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
	  <link rel="stylesheet" type="text/css" href="../css/login.css">
	</head>
	
	<body bgcolor="ffffff">
	  <section >
		<div class="hero-body">
		  <div class="container has-text-centered">
			<div class="column is-4 is-offset-4">
			  Account of: 
				<?php session_start();
					echo $_SESSION['login'];
				?>
			</div>
		  </div>
		</div>
	  </section>
	  <script async type="text/javascript" src="../js/bulma.js"></script>
	</body>
</html>