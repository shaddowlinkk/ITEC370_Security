<!DOCTYPE html>
<html>
	<head>
	 <title>I.S.M - Acount Page</title>
	  
	<link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
	<link rel="stylesheet" type="text/css" href="DataTables/TableStyle.css">
	 <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
	 <script type="text/javascript" src="DataTables/datatables.min.js"></script>
	<style>
	td.details-control 
	{
		background: url('../images/details_open.png') no-repeat center center;
		cursor: pointer;
	}
	tr.shown td.details-control 
	{
		background: url('../images/details_close.png') no-repeat center center;
	}
	</style>

		
	</head>
	
	<body bgcolor="ffffff">
		<?php 
			session_start();
			
			//Redirects them to the login page if they have not logged in yet
			
			if ($_SESSION['loggedIn'] == false)
			{
				echo "<script>location.href='Login.php';</script>";
			}
			
			$filter = ['ID' => $_SESSION['login']];
			$options = [];
			$DataTables = new GetData($filter, $options);
			
			$data = $DataTables->getData();
		?>
		<script>
			function redirect ()
			{
				location.href='Login.php';
			}
		</script>
		<div>
			<button type="button" id="logout" onclick="redirect()">Log Out</button>
		</div>
		<!-- Table goes here -->
		<table id="table_id" class="display" class="dataTable">
			<thead>
				<th></th>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Message</th>
			</thead>
			<tfoot>
				<th></th>
				<th>ID</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Message</th>
			</tfoot>
		</table>
		<script>
			/* Formatting function for row details - modify as you need */
			function format ( d ) {
				// `d` is the original data object for the row
				return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
					'<tr>'+
						'<td>Message:</td>'+
						'<td>'+d.MSG+'</td>'+
					'</tr>'+
				'</table>';
			}
			 
			$(document).ready(function() 
			{
				var table = $('#table_id').DataTable( {
					data: <?php echo json_encode($data); ?>,
					columnDefs:
					[{
						targets: 4,
						data: 'MSG',
						render: function (data, type, row, meta)
						{
							//Trims the string and appends a ... to show that there is more to the message
							if (data.length > 30)
							{
								return data.substring(0, 30) + "...";
							}
							//If smaller than 30 it will just return the normal data
							else if (data.length < 30)
							{
								return data;
							}
						}
					}],
					//Each column of data
					columns: 
					[
					{
						className:      'details-control',
						orderable:      false,
						data:           null,
						defaultContent: ''
					},
					{ data: 'ID' },
					{ data: 'FirstName' },
					{ data: 'LastName' },
					{ data: 'MSG' }
					],
					"order": [[3, 'asc']]
				} );
     
				// Add event listener for opening and closing details
				$('#table_id tbody').on('click', 'td.details-control', function () 
				{
					var tr = $(this).closest('tr');
					var row = table.row( tr );
			 
					if ( row.child.isShown() ) 
					{
						// This row is already open - close it
						row.child.hide();
						tr.removeClass('shown');
					}
					else 
					{
						// Open this row
						row.child( format(row.data()) ).show();
						tr.addClass('shown');
					}
				} );
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