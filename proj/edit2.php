<?php


	if(isset($_GET['submit2']))
		{
			$conn = mysqli_connect('localhost', 'tupai', 'tupai1234','project1');

			$contact_id = $_GET['contact_id'];
			$first_name = $_GET['first_name'];
			$middle_name = $_GET['middle_name'];
			$last_name = $_GET['last_name'];

			$home_phone = $_GET['home_phone'];
			$cell_phone = $_GET['cell_phone'];

			$home_address = $_GET['home_address'];
			$home_city = $_GET['home_city'];
			$home_state = $_GET['home_state'];
			$home_zip = $_GET['home_zip'];
			$work_phone = $_GET['work_phone'];
			$work_address = $_GET['work_address'];

			$work_city = $_GET['work_city'];
			$work_state = $_GET['work_state'];
			$work_zip = $_GET['work_zip'];
			$birth_day = $_GET['birth_day'];


			$sql1 = "UPDATE contact1 SET contact_id = '$contact_id', first_name = '$first_name', middle_name ='$middle_name' , last_name = '$last_name' WHERE contact_id = '$contact_id';";
			$result1 = mysqli_query($conn,$sql1);

			$sql2 = "UPDATE phone SET contact_id = '$contact_id', home_phone = '$home_phone',   cell_phone = '$cell_phone',    work_phone = '$work_phone' WHERE contact_id = '$contact_id';";
			$result2 = mysqli_query($conn,$sql2);

			$sql3 = "UPDATE address SET contact_id = '$contact_id', home_address ='$home_address',home_city = '$home_city', home_state = '$home_state', home_zip = '$home_zip', work_address = '$work_address', work_city = '$work_city', work_state = '$work_state', work_zip = '$work_zip'  WHERE contact_id = '$contact_id';";
			$result3 = mysqli_query($conn,$sql3);

			$sql4 = "UPDATE date SET contact_id = '$contact_id', birth_day = '$birth_day' WHERE contact_id = '$contact_id';";
			$result4 = mysqli_query($conn,$sql4);
			
			


			

			
			
			
			mysqli_close($conn);
			?>
			<div class="alert alert-success" role="alert">
			  <h4 class="alert-heading"><?php echo 'SUCCESS'; ?></h4>
			  <hr>
			  <p class="mb-0">Updation done</p>
			</div>

	<?php		
		}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="demo.css"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
	<a class="btn btn-primary btn-lg btn-block" href="index.php">HOME</a>

</body>
</html>