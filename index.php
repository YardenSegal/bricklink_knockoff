<?php
	require "header.php"; //simple header
	require 'dbh.inc.php'; //create database connection
?>

	<main>
		

		<?php

	    $result = mysqli_query($conn,"SELECT * FROM legopieces");

		echo "<table border='1'>
		<tr>
		<th>Name</th>
		<th>Plate ID</th>
		<th>Type</th>
		<th>Colour</th>
		<th>Price ($)</th>
		<th>Quantity</th>
		<th>Remove</th>
		</tr>";

		while($row = mysqli_fetch_array($result))
		{
			
		echo "<tr>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['plateId'] . "</td>";
		echo "<td>" . $row['type'] . "</td>";
		echo "<td>" . $row['colour'] . "</td>";
		echo "<td>" . number_format($row['price'], 2, '.', '') . "</td>";
		echo '<td><form action="index.php?action=add&id='.$row['plateId'].'&price='.$row['price'].'" method="post">
			<input type="text" name="qty"><button type="submit" name="add">Add</button></form></td>';
		echo '<td><form action="index.php?action=del&id='.$row['plateId'].'" method="post">
			<button type="submit" name="del">Remove</button></form></td>';
		echo "</tr>";
		
		}
		

		if (isset($_POST['add'])){
			if(isset($_GET['id'])){
				$sql = "SELECT * FROM cart WHERE id=?;";
				$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)){

					}
					else {
						mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);
						$resultCheck = mysqli_stmt_num_rows($stmt);
						mysqli_stmt_free_result($stmt);
						if ($resultCheck > 0){
							$updateQty = $_POST['qty'];
							$result = mysqli_query($conn,"SELECT * FROM cart WHERE id=".$_GET['id'].";");
							while($row = mysqli_fetch_array($result))
							{
								$updateQty += $row['qty'];
							}

							$sql = "UPDATE cart SET qty=? WHERE id=?;";
							$stmt = mysqli_stmt_init($conn);
							if (!mysqli_stmt_prepare($stmt, $sql)){
								echo"ERROR UPDATING CART<br>";
							}
							else {
								mysqli_stmt_bind_param($stmt, "ss", $updateQty,  $_GET['id'],);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_close($stmt);
							}
						} else {
							$sql = "INSERT INTO cart(qty, id, price) VALUES (?, ?, ?);";
							$stmt = mysqli_stmt_init($conn);
							if (!mysqli_stmt_prepare($stmt, $sql)){
								echo"ERROR ADDING ITEM TO CART<br>";
							}
							else {
								mysqli_stmt_bind_param($stmt, "sss", $_POST['qty'], $_GET['id'],$_GET['price']);
								mysqli_stmt_execute($stmt);
								mysqli_stmt_close($stmt);
							}
					}
				}

			}
		}

		if (isset($_POST['del'])){
			if(isset($_GET['id'])){
				$sql = "DELETE FROM cart WHERE id=?;";
				$stmt = mysqli_stmt_init($conn);
					if (!mysqli_stmt_prepare($stmt, $sql)){
						echo"ERROR DELETING ".$_GET['id']."<br>";
					}
					else {
						mysqli_stmt_bind_param($stmt, "s", $_GET['id']);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_close($stmt);
					}
			}
		}

		echo "</table>";


		echo "<hr><table border='1'>
		<tr>
		<th>Plate ID</th>
		<th>Quantity</th>
		<th>Total</th>
		</tr>";
		$result = mysqli_query($conn,"SELECT * FROM cart");

		$totalPrice = 0.0;
		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['id'] . "</td>";
			echo "<td>" . $row['qty'] . "</td>";
			echo "<td>" . number_format($row['qty']*$row['price'], 2, '.', ''). "</td>";
			echo "</tr>";
			$totalPrice += $row['qty']*$row['price'];
		}
		

		if ($totalPrice > 0){
			echo "Order Total: $totalPrice";
		}

		echo"</table>";
		mysqli_close($conn);
		?>

		<br>

	</main>


