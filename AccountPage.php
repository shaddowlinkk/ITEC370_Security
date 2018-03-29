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

		<style>
			.disabled 
			{
				display: none;
			}
		</style>
	</head>
	
	<body bgcolor="ffffff">
	  <section >
		<div class="hero-body">
		  <div class="container has-text-centered">
			<div class="column is-4 is-offset-4">
				<?php 
					session_start();
					//echo $_SESSION['login'];
					
					$limit = 10;
					$page = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
					$links = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
					$filter = [];
					$options = [];
					$Paginator = new Paginator( $filter , $options);
					
					$results  = $Paginator->getData($limit, $page);
				?>
					
				<table class="">
					<thead>
						<tr>
							<th>First Name</th>
							<th>Last Name</th>
							<th> ID</th>
							<th>Message</th>
						</tr>
                     </thead>
					<tbody>
						<?php for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
						<tr>
								<td><?php echo $results->data[$i]->FirstName; ?></td>
								<td><?php echo $results->data[$i]->LastName; ?></td>
								<td><?php echo $results->data[$i]->ID; ?></td>
								<td><?php echo $results->data[$i]->MSG; ?></td>
						</tr>
						<?php endfor; ?>
					</tbody>
                </table>
				
				<?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?> 	
				
				<?php
					class Paginator {
						public $_mongo;
						public $_limit;
						public $_filter;
						public $_options;
						public $_total;
						
						public function __construct($filter, $options)
						{
							//connection to the database
							$this->_limit = 10;
							$this->_mongo = new \MongoDB\Driver\Manager('mongodb://localhost/db');
							$this->_filter = $filter;
							$this->_options = $options;
							//Preforms the query to find how much many results are in the search
							$query = new \MongoDB\Driver\Query($this->_filter, $this->_options);
							$cursor   = $this->_mongo->executeQuery('test.test', $query)->toArray();
							$this->_total = count($cursor);
						}
						
						/*
							Gathers the data and places it into an array of results with characteristics such as limit and page
							
							I am not sure what the if else stamtent does as of yet
						*/
						public function getData ($limit = 10, $page = 1)
						{
							$this->_limit = $limit;
							$this->_page = $page;
							
							if ( $this->_limit == 'all' ) 
							{
								$option = [];
							} 
							
							else 
							{
								$option = ['limit' => 10 * $this->_page];
							}
							
							$query = new \MongoDB\Driver\Query([], $option);
							$cursor   = $this->_mongo->executeQuery('test.test', $query);
							$i = 0;
							
							foreach ($cursor as $data)
							{
								if (($this->_page-1)*10 < $i && $i < ($this->_page-1)*10 + 10)
								{
									$results[] = $data;
								}
							
								$i++;
							}
							
							$result = new stdClass();
							$result->page   = $this->_page;
							$result->limit  = $this->_limit;
							$result->total  = $this->_total;
							$result->data   = $results;
							
							return $result;
						}
						
						public function createLinks ($links, $list_class)
						{
							if ($this->_limit == "all")
							{
								return "";
							}
							
							//Calculates what the last page will be numbered as 
							//(Basicly how many pages we have total based on the amount of results and limit per page)
							$last = ceil($this->_total / $this->_limit);
							
							$start = (($this->_page - $links) > 0) ? $this->_page - $links : 1;
							$end = (($this->_page + $links) < $last) ? $this->_page + $links : $last;
							
							$html = "<ul class='" . $list_class . "'>";
							$class = ($this->_page == 1) ? "disabled" : "";
							$html .= "<li class='" . $class . "'> <a href='?limit=" . $this->_limit . "&page=" . ($this->_page - 1) . "'>&laquo;</a></li>";
							
							if ($start > 1)
							{
								$html .= "<li<a href='?limit=" . $this->_limit . "&page=1'>1</a></li>";
								$html   .= "<li class='disabled'><span>...</span></li>";
							}
							
							for ($i = $start; $i <= $end; $i++)
							{
								$class = ($this->_page == $i) ? "active" : "";
								$html .= "<li class='" . $class . "'><a href='?limit=" . $this->_limit . "&page=" . $i . "'>" . $i . "</a></li>";
							}
							
							if ($end < $last)
							{
								$html   .= "<li class='disabled'><span>...</span></li>";
								$html   .= "<li><a href='?limit=" . $this->_limit . "&page=" . $last . "'>" . $last . "</a></li>";
							}
							
							$class      = ( $this->_page == $last ) ? "disabled" : "";
							$html       .= "<li class='" . $class  . "'><a href='?limit=" . $this->_limit . "&page=" . ( $this->_page + 1 ) . "'>&raquo;</a></li>";
						 
							$html       .= "</ul>";
						 
							return $html;
						}
					}
				?>
			</div>
		  </div>
		</div>
	  </section>
	  <script async type="text/javascript" src="../js/bulma.js"></script>
	</body>
</html>