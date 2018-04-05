<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  
	  <title>I.S.M - Acount Page</title>
	  
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	 <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	 <script type="text/javascript" src="DataTables/datatables.min.js"></script>
	

		
	</head>
	
	<body bgcolor="ffffff">
		<?php 
			session_start();
			
			$filter = ['ID' => $_SESSION['login']];
			$options = [];
			$DataTables = new GetData($filter, $options);
			
			$data = $DataTables->getData();
		?>
			
		<!-- Table goes here -->
		<table id="table_id" class="display"></table>
		<script>				
			$('#table_id').DataTable(
			{
				data: <?php echo json_encode($data); ?>,
				columns: 
				[
					{ data: 'ID' },
					{ data: 'FirstName' },
					{ data: 'LastName' },
					{ data: 'MSG' }
				]
			} );
			
		</script>	
		
		<?php
			class GetData 
			{
				public $_mongo;
				public $_filter;
				public $_options;
				public $_total;
				
				public function __construct($filter, $options)
				{
					//connection to the database
					$this->_mongo = new \MongoDB\Driver\Manager('mongodb://localhost/db');
					$this->_filter = $filter;
					$this->_options = $options;
					$query = new \MongoDB\Driver\Query($this->_filter, $this->_options);
					$cursor   = $this->_mongo->executeQuery('test.test', $query)->toArray();
					$this->_total = count($cursor);
				}
				
				public function getData()
				{
					$query = new \MongoDB\Driver\Query($this->_filter, $this->_options);
					$cursor   = $this->_mongo->executeQuery('test.test', $query);
					
					foreach ($cursor as $data)
					{
						$results[] = $data;
					}
					
					return $results;
				}
			}
		?>
	</body>
</html>