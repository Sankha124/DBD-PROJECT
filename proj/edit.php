<?php


		if(isset($_GET['id']))
		{ 
			
			$conn = mysqli_connect('localhost', 'tupai', 'tupai1234','project1');

			if(!$conn)
			{
				echo 'error' . mysqli_connect_error();
			}


			
			$id1 = mysqli_real_escape_string($conn, $_GET['id']);
			$sql = "SELECT * FROM contact1 INNER JOIN phone ON contact1.contact_id = phone.contact_id INNER JOIN date ON contact1.contact_id = date.contact_id INNER JOIN address ON contact1.contact_id = address.contact_id WHERE contact1.contact_id = $id1";;
			$result = mysqli_query($conn,$sql);

			$fetres = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
			mysqli_close($conn);

			
		}

?>



<!DOCTYPE html>
<html>
<title></title>
<script src="demo.css"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<body>
	<a class="btn btn-primary btn-lg btn-block" href="index.php">HOME</a>

	<?php 
	foreach ($fetres as $tup) { ?>


	<div class="row justify-content-center">
	<form action="edit2.php?" method="GET">
		<div class="form-group">
			<label for="contact_id1">ID</label>
			<input type="text" class="form-control" name="contact_id" value="<?php echo $tup['contact_id']; ?>" readonly>
		</div>
		<div class="form-group">	
			<label for="first_name">first name</label>
			<input type="text" class="form-control" name="first_name" value="<?php echo $tup['first_name']; ?>">
		</div>
		<div class="form-group">			
			<label for="middle_name">middle name</label>
			<input type="text" class="form-control" name="middle_name" value="<?php echo $tup['middle_name']; ?>">
		</div>
		<div class="form-group">	
			<label for="last_name">last name</label>		
			<input type="text" class="form-control" name="last_name" value="<?php echo  $tup['last_name']; ?>">
		</div>

		<div class="form-group">
			<label for="home_phone">home phone</label>
			<input type="text" class="form-control" name="home_phone" value="<?php echo $tup['home_phone']; ?>">
		</div>
		<div class="form-group">	
			<label for="cell_phone">cell phone</label>
			<input type="text" class="form-control" name="cell_phone" value="<?php echo $tup['cell_phone']; ?>">
		</div>
		<div class="form-group">			
			<label for="home_address">home address</label>
			<input type="text" class="form-control" name="home_address" value="<?php echo $tup['home_address']; ?>">
		</div>
		<div class="form-group">	
			<label for="home_city">home city</label>		
			<input type="text" class="form-control" name="home_city" value="<?php echo $tup['home_city']; ?>">
		</div>

		<div class="form-group">
			<label for="home_state">home state</label>
			<input type="text" class="form-control" name="home_state" value="<?php echo $tup['home_state']; ?>">
		</div>
		<div class="form-group">	
			<label for="home_zip">home zip</label>
			<input type="text" class="form-control" name="home_zip" value="<?php echo $tup['home_zip']; ?>">
		</div>
		<div class="form-group">			
			<label for="work_phone">work phone</label>
			<input type="text" class="form-control" name="work_phone" value="<?php echo $tup['work_phone']; ?>">
		</div>
		<div class="form-group">	
			<label for="work_address">work address</label>		
			<input type="text" class="form-control" name="work_address" value="<?php echo $tup['work_address']; ?>">
		</div>

		<div class="form-group">
			<label for="work_city">work city</label>
			<input type="text" class="form-control" name="work_city" value="<?php echo $tup['work_city']; ?>" >
		</div>
		<div class="form-group">	
			<label for="work_state">work state</label>
			<input type="text" class="form-control" name="work_state" value="<?php echo $tup['work_state']; ?>">
		</div>
		
		<div class="form-group">	
			<label for="work_zip">work zip</label>		
			<input type="text" class="form-control" name="work_zip" value="<?php echo $tup['work_zip']; ?>">
		</div>

		<div class="form-group">			
			<label for="birth_day">birth date</label>
			<input type="text" class="form-control" name="birth_day" value="<?php echo $tup['birth_day']; ?>">
		</div>



        <?php
    	}
    ?>

		<div class="form-group">
			<input type="submit" name="submit2">
		</div>
	</form>
	</div>


</body>
</html>