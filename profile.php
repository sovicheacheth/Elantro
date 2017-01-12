<?php include("includes/header.php");

	require("includes/function.php");
	$kwallpaper=new  k_wallpaper;
	 
	
	if(isset($_SESSION['id']))
	{
			 
		$qry="select * from tbl_admin where id='".$_SESSION['id']."'";
		 
		$result=mysql_query($qry);
		$row=mysql_fetch_assoc($result);

	}
	if(isset($_POST['submit']))
	{
		 
		$kwallpaper->editProfile();
		
		echo "<script>document.location='profile.php';</script>"; 
	    exit;
	}


?>

    <style>
        .button {
            background-color: #bc2025;
            border: none;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 10px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
    <script src="js/category.js" type="text/javascript"></script>

    <div id="main">
        <h2><a href="home.php">Dashboard</a> &raquo; <a href="#" class="active"></a></h2>


        <form action="" name="editprofile" method="post" class="jNice" enctype="multipart/form-data">


            <h3>Edit Profile</h3>
            <fieldset>

                <p>
                    <label>Username:</label>
                    <input type="text" name="username" id="username" value="<?php echo $row['username'];?>" class="text-long" />
                </p>

                <p>
                    <label>Password:</label>
                    <input type="password" name="password" id="password" value="<?php echo $row['password'];?>" class="text-long" />
                </p>

                <p>
                    <label>Email:</label>
                    <input type="text" name="email" id="email" value="<?php echo $row['email'];?>" class="text-long" />
                </p>

                <input class="button" type="submit" name="submit" value="Update" />
            </fieldset>
        </form>
    </div>
    <!-- // #main -->

    <div class="clear"></div>
    </div>
    <!-- // #container -->
    </div>
    <!-- // #containerHolder -->

    <?php include("includes/footer.php");?>