<?php
	require "header.php"; //simple header
	require 'dbh.inc.php'; //create database connection
	include 'displays.inc.php';
?>

	<main>
		

		<?php

			createPartTable($conn);

			if(isset($_GET['id'])){
				if (isset($_POST['add'])){
					addItem($conn, $_GET['id'], $_POST['qty'], $_GET['price']);
				}
				
				
				if (isset($_POST['del'])){
					delItem($conn, $_GET['id']);
				}
			}
				
	
			createCartTable($conn);
		
			mysqli_close($conn);
		?>

		<br>

	</main>


