<?php 

    include("includes/connection.php");
	
	$username=$_POST['username'];
	$password=trim($_POST['password']);
	
	if($username=="")
	{
		echo "<script>document.location='index.php?msg=1';</script>"; 
	}
	else if($password=="")
	{
		echo "<script>document.location='index.php?msg=2';</script>"; 
	}	 
	else
	{
		$qry="SELECT * FROM tbl_admin WHERE username='".$username."' AND password='".$password."'";
		 
		$result=mysql_query($qry);
		$row=mysql_fetch_assoc($result);
		
		if($row > 0)
		{ 
			$_SESSION['id']=$row['id'];
		    $_SESSION['admin_name']=$row['username'];
			 
			if(isset($_POST['remember']))
			{
			  setcookie("id", $_SESSION['id'], time()+60*60*24);
			  setcookie("admin_name",$_SESSION['admin_name'], time()+60*60*24);
				  
			}
						 
			echo "<script>document.location='home.php';</script>"; 
				
		}
		else
		{
			echo "<script>document.location='index.php?msg=4';</script>"; 
		}
	}
	
	
	


?>