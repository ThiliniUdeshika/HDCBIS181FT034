<?php
	$servername="localhost";
	$username="root";
	$password="";
	$dbname="guest_book";
	$msg="";
	$con=mysqli_connect($servername,$username,$password);
	mysqli_select_db($con,$dbname);
	if (isset($_POST['send']))
	{
		$Comment=$_POST['comment'];
		$query="insert into commentTb (msg) values('$Comment') ";
		$ret=mysqli_query($con,$query);
		if(!mysqli_query($con,$query))
		{
			die('Error:'.mysqli_error($con));
		}
		else
			echo "Your comment was inserted";
	}
mysqli_close($con);
?>
