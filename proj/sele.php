
<a class="btn btn-primary btn-lg btn-block" href="index.php">HOME</a>
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


		
	

		foreach ($fetres as $tup) { ?>

		<table class="table table-hover table-dark">
		  <thead>
		    <tr>
		      <th scope="col">CONTACT ID</th>
		      <th scope="col">NAME</th>
		      <th scope="col">MIDDLE NAME</th>
		      <th scope="col">LAST NAME</th>

		      <th scope="col">HOME PHONE</th>
		      <th scope="col">CELL PHONE</th>
		      <th scope="col">HOME ADDRESS</th>
		      

		      <th scope="col">WORK STATE</th>
		      <th scope="col">WORK ZIP</th>
		      <th scope="col">WORK PHONE</th>
		      <th scope="col">WORK ADDRESS</th>

		      
		      <th scope="col">WORK STATE</th>
		      <th scope="col">WORK ZIP</th>
		      <th scope="col">B'DAY</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row"><?php echo $tup['contact_id']; ?></th>
		      <td><?php echo $tup['first_name']; ?></td>
		      <td><?php echo $tup['middle_name']; ?></td>
		      <td><?php echo $tup['last_name']; ?></td>
		      <td><?php echo $tup['home_phone']; ?></td>

		      <td><?php echo $tup['cell_phone']; ?></td>
		      <td><?php echo $tup['home_address']; ?> ,<?php echo $tup['home_city']; ?></td>
		      
		      <td><?php   echo $tup['home_state']; ?></td>

		      <td><?php echo $tup['home_zip']; ?></td>
		      <td><?php echo $tup['work_phone']; ?></td>
		      <td><?php echo $tup['work_address']; ?> ,<?php echo $tup['work_city'];?></td>
		      

		      <td><?php echo $tup['work_state']; ?></td>
		      <td><?php echo $tup['work_zip']; ?></td>
		      <td><?php echo $tup['birth_day']; ?></td>
		      

		     
		    </tr>
		  </tbody>
		</table>
		<?php
	}

	}
?>


<!DOCTYPE html>
<html>
<title>
	
</title>

<head>
	
<script src="demo.css"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>


<body>
	<div class="col text-center">
		<a class="btn btn-primary" href="edit.php?id=<?php echo$tup['contact_id']?> "> edit </a>
	    <a class="btn btn-primary" href="delete.php?id=<?php echo$tup['contact_id']?> "> delete </a>
	</div>
    

	
</body>
</html>