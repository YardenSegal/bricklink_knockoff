<?php
	require "header.php"; //simple header
	require 'dbh.inc.php'; //create database connection
	include 'displays.inc.php'; //functions used in file
?>

	<main>
		

		<?php

			createPartTable($conn);

			if(isset($_GET['id'])){ //check if ID is set in URL (user's clicked a submit button) to perform either an add, delete or update to the database
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


