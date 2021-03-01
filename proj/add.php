<!DOCTYPE html>
<html>
<head>
	<title></title>
<script src="demo.css"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>

	<a class="btn btn-primary btn-lg btn-block" href="index.php">HOME</a>

<div class="row justify-content-center">
	<form action="add.php" method="GET">
		<div class="form-group">
		<label>contact_id</label>
		<input type="text" class="form-control" name="contact_id" placeholder="ID">
	</div>

	<div class="form-group">
		<label>first_name</label>
		<input type="text" class="form-control" name="first_name" placeholder="name">
	</div>

	<div class="form-group">
		<label>middle_name</label>
		<input type="text" class="form-control" name="middle_name" placeholder="middle name">
	</div>

	<div class="form-group">
		<label>last_name</label>
		<input type="text" class="form-control" name="last_name" placeholder="last name">
	</div>

	
	<div class="form-group">
		<label>home_phone</label>
		<input type="text" class="form-control" name="home_phone" placeholder="home phone">
	</div>
	<div class="form-group">
		<label>cell_phone</label>
		<input type="text" class="form-control" name="cell_phone" placeholder="cellphone">
	</div>
	<div class="form-group">
		<label>home_address</label>
		<input type="text" class="form-control" name="home_address" placeholder="home address">
	</div>
	<div class="form-group">
		<label>home_city</label>
		<input type="text" class="form-control" name="home_city" placeholder="home city">
	</div>

	<div class="form-group">
		<label>home_state</label>
		<input type="text" class="form-control" name="home_state" placeholder="home state">
	</div>
	<div class="form-group">
		<label>home_zip</label>
		<input type="text" class="form-control" name="home_zip" placeholder="home zip">
	</div>
	<div class="form-group">
		<label>work_phone</label>
		<input type="text" class="form-control" name="work_phone" placeholder="work phone">
	</div>
	<div class="form-group">
		<label>work_address</label>
		<input type="text" class="form-control" name="work_address" placeholder="work address">
	</div>

	<div class="form-group">
		<label>work_city</label>
		<input type="text" class="form-control" name="work_city" placeholder="work city">
	</div>
	<div class="form-group">
		<label>work_state</label>
		<input type="text" class="form-control" name="work_state" placeholder="work state">
	</div>
	<div class="form-group">
		<label>work_zip</label>
		<input type="text" class="form-control" name="work_zip" placeholder="work zip">
	</div>
	<div class="form-group">
		<label>birth_date</label>
		<input type="text" class="form-control" name="birth_date" placeholder="Birthday">
	</div>
	
	
	<div class="form-group">
		<input type="submit" name="submit">
	</div>
	</form>
</div>


	

</body>
</html>








<?php


	if(isset($_GET['submit'])) 
	{ 
		
		$conn = mysqli_connect('localhost', 'tupai', 'tupai1234','project1');

		if(!$conn)
		{
			echo 'error' . mysqli_connect_error();
		}

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
		$birth_date = $_GET['birth_date'];

		
		

		//$id1 = mysqli_real_escape_string($conn, $_GET['id']);
		$sql = "INSERT INTO contact1  VALUES 
		('$contact_id','$first_name','$middle_name','$last_name')";
		mysqli_query($conn,$sql);



		$sql2 = "INSERT INTO phone VALUES('$contact_id','$contact_id',
		'$home_phone','$cell_phone','$work_phone')";
		mysqli_query($conn,$sql2);

		$sql3 = "INSERT INTO address VALUES('$contact_id','$contact_id','$home_address','$home_city','$home_state',
		'$home_zip','$work_address','$work_city','$work_state','$work_zip')";
		mysqli_query($conn,$sql3);

		$sql4 = "INSERT INTO date VALUES('$contact_id','$contact_id','$birth_date')";


		mysqli_query($conn,$sql4);
			
		mysqli_close($conn);

		?>
		<div class="alert alert-success" role="alert">
		  <h4 class="alert-heading"><?php echo 'SUCCESS'; ?></h4>
		  <hr>
		  <p class="mb-0">Addition done</p>
		</div>

	<?php		
	}
	
?>

