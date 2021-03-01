
<!DOCTYPE html>
<html>
<script src="demo.css"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<body>
	<a class="btn btn-primary btn-lg btn-block" href="index.php">HOME</a>

</body>
</html>



<?php


	if(isset($_GET['id']))
	{ 
		
		$conn = mysqli_connect('localhost', 'tupai', 'tupai1234','project1');

		if(!$conn)
		{
			echo 'error' . mysqli_connect_error();
		}


		
		$id1 = mysqli_real_escape_string($conn, $_GET['id']);
		$sql = "DELETE FROM date WHERE contact_id=$id1;";
		mysqli_query($conn,$sql);

		$sql1 = "DELETE FROM phone WHERE contact_id=$id1;";
		mysqli_query($conn,$sql1);


		$sql2 = "DELETE FROM address WHERE contact_id=$id1;";
		mysqli_query($conn,$sql2);

		
		$sql3 = "DELETE FROM contact1 WHERE contact_id=$id1;";
		mysqli_query($conn,$sql3);

		
		mysqli_close($conn);
		?>
		<div class="alert alert-success" role="alert">
		  <h4 class="alert-heading"><?php echo 'SUCCESS'; ?></h4>
		  <hr>
		  <p class="mb-0">Deletion done</p>
		</div>

	<?php		

		

	}
?>