<?php include("includes/header.php");

	require("includes/function.php");
	$kwallpaper=new  k_wallpaper;
	
	 

	$tableName="tbl_gallery";		
	$targetpage = "manage_gallery.php"; 	
	$limit = 15; 
	
	$query = "SELECT COUNT(*) as num FROM $tableName";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	$stages = 3;
	$page=0;
	if(isset($_GET['page'])){
	$page = mysql_escape_string($_GET['page']);
	}
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
		}	
	
    // Get page data
	if(isset($_POST["search"]))
{
	$mp3_name=$_POST['search_value']; 
	$qry="SELECT * FROM tbl_gallery,tbl_category WHERE cat_id=cid and mp3_title LIKE '%".$mp3_name."%' ORDER BY tbl_gallery.id DESC LIMIT $start, $limit"; 
	
}
else{ 
   $qry="SELECT * FROM tbl_gallery
LEFT JOIN tbl_category ON tbl_gallery.cat_id= tbl_category.cid ORDER BY tbl_gallery.id DESC LIMIT $start, $limit";	  
}
	$result=mysql_query($qry);

 
	
	if(isset($_GET['mp3_id']))
	{
		$kwallpaper->deletemp3();
		
		 
		echo "<script>document.location='manage_gallery.php';</script>"; 
	    exit;
		
	}	
	 
?>

    <!-- h2 stays for breadcrumbs -->
    <div id="main">
        <h2>Manage Music &raquo;</h2>

        <form method="post" action="<?php echo $_SERVER[" PHP_SELF "];?>">
            <div class="search">

                <input type="text" name="search_value" placeholder="Search music" class="search_text">
                <input type="submit" value="Search" name="search" class="search_button" style="color:white;margin-left:10px;margin-top:10px;size:20px;">

            </div>
        </form>
        <form action="" class="jNice">

            <h3 class="abtn"><a href="add_mp3.php?add=yes">Add new music</a></h3>
            <table cellpadding="0" cellspacing="0">

                <tr align="center">
                    <th>Category</th>
                    <th>Music Title</th>
                    <th>Edit</th>
                    <th>Delete</th>

                </tr>


                <?php
						
							$i=0;
							while($row=mysql_fetch_array($result))
							{
							 
						?>

                    <tr <?php if($i%2==0){?>class="odd"
                        <?php }?> align="center">
                            <td>
                                <?php echo $row['category_name'];?>
                            </td>
                            <td>
                                <?php echo $row['mp3_title'];?>
                            </td>
                            <td class="action"><a href="edit_mp3.php?mp3_id=<?php echo $row['id'];?>" class="edit">Edit</a></td>
                            <td class="action"><a href="?mp3_id=<?php echo $row['id'];?>" class="delete" onclick="return confirm('Are you sure you want to delete this mp3 file?');">Delete</a></td>
                    </tr>

                    <?php
						
							$i++;
							}
						?>

            </table>
            <br />
            <?php
								// Initial page num setup
	if ($page == 0){$page = 1;}
	$prev = $page - 1;	
	$next = $page + 1;							
	$lastpage = ceil($total_pages/$limit);		
	$LastPagem1 = $lastpage - 1;					
	
	
	$paginate = '';
	if($lastpage > 1)
	{	
	

	
	
		$paginate .= "<div class='paginate'>";
		// Previous
		if ($page > 1){
			$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";
		}else{
			$paginate.= "<span class='disabled'>previous</span>";	}
			

		
		// Pages	
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page){
					$paginate.= "<span class='current'>$counter</span>";
				}else{
					$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
			}
		}
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
		{
			// Beginning only hide later pages
			if($page < 1 + ($stages * 2))		
			{
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
			}
			// Middle hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?page=1'>1</a>";
				$paginate.= "<a href='$targetpage?page=2'>2</a>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		
			}
			// End only hide early pages
			else
			{
				$paginate.= "<a href='$targetpage?page=1'>1</a>";
				$paginate.= "<a href='$targetpage?page=2'>2</a>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page){
						$paginate.= "<span class='current'>$counter</span>";
					}else{
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					
				}
			}
		}
					
				// Next
		if ($page < $counter - 1){ 
			$paginate.= "<a href='$targetpage?page=$next'>next</a>";
		}else{
			$paginate.= "<span class='disabled'>next</span>";
			}
			
		$paginate.= "</div>";		
	
	
}
  
 // pagination
 echo $paginate;
								?>
                <br />

    </div>
    <!-- // #main -->

    <div class="clear"></div>
    </div>
    <!-- // #container -->
    </div>
    <!-- // #containerHolder -->

    <?php include("includes/footer.php");?>