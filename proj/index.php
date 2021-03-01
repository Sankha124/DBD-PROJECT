
<?php

if(isset($_POST['submit'])){ 
	

$conn = mysqli_connect('localhost', 'tupai', 'tupai1234','project1');

if(!$conn){
	echo 'error' . mysqli_connect_error();

}

$n = $_POST['val'];


$sql = "SELECT * FROM contact1 Where first_name LIKE '%$n%'";

$result = mysqli_query($conn,$sql);

$fetres = mysqli_fetch_all($result, MYSQLI_ASSOC);



mysqli_free_result($result);

mysqli_close($conn);

if(!$fetres){ ?>
	<div class="alert alert-success" role="alert">
		<h4 class="alert-heading"><?php echo 'OOPS'; ?></h4>
		<hr>
		<p class="mb-0">NO RESULT FOUND</p>
	</div>
<?php
}


foreach ($fetres as $tup) { ?>

	<table class="table table-hover table-dark">
	  <thead>
	    <tr>
	      <th scope="col">ID</th>
	      <th scope="col">NAME</th>
	      <th scope="col">SURNAME</th>
	      <th scope="col">MIDDLE NAME</th>
	      <th scope="col"></th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <th scope="row"><?php echo $tup['contact_id']; ?></th>
	      <td><?php echo $tup['first_name']; ?></td>
	      <td><?php echo $tup['last_name']; ?></td>
	      <td><?php echo $tup['middle_name']; ?></td>
	      <td>
	      	<a class="btn btn-primary" href="edit.php?id=<?php echo$tup['contact_id']?> "> edit </a>
        	<a class="btn btn-primary" href="delete.php?id=<?php echo$tup['contact_id']?> "> delete </a>
        	<a class="btn btn-primary" href="sele.php?id=<?php echo$tup['contact_id']?> "> select </a>
        	</td>
	    </tr>
	  </tbody>
	</table>


	
	


<?php }



}

?>


<!DOCTYPE html>
<html>
<title>
	
</title>
<head>
<script src="demo.css"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<style type="text/css">
	h1
	{
		background-color: #48dbfb;
		background-image: linear-gradient(to right,  blue, white);
	}

</style>

</head>


<body>

	<h1> CONTACT LIST</h1>


	<br>
	<br>
	<br>
	<br>


	<div class="p-3 mb-2 bg-dark text-white">


	

	<div class="row justify-content-center">
		<form action="index.php" method="POST">


		


			<div class="form-group">
		
					<input class="form-control input-lg" type="text"  name="val" placeholder="SEARCH">
				</div>

				
			<div class="form-group">
				<input type="submit" name="submit">
			</div>
			
		</form>
	</div>

	<div class="col-md-12 text-center">
		<a class="btn btn-primary" href="add.php" role="button"> ADD NEW CONTACT </a>
	</div>
	</div>


	
</body>
</html>

