<?php include("includes/connection.php");
 
	
	if(isset($_GET['cat_id']))
	{
		
		$cat_id=$_GET['cat_id'];		
	
			$query="SELECT * FROM tbl_gallery
		LEFT JOIN tbl_category ON tbl_gallery.cat_id= tbl_category.cid 
		where tbl_gallery.cat_id='".$cat_id."' ORDER BY tbl_gallery.id DESC";
		
	}
	else if(isset($_GET['latest']))
	{
		$limit=$_GET['latest'];	 	
		$query="SELECT * FROM tbl_gallery
		LEFT JOIN tbl_category ON tbl_gallery.cat_id= tbl_category.cid 
		ORDER BY tbl_gallery.id DESC LIMIT $limit";
	}
	else if(isset($_GET['all']))
	{
		$query="SELECT * FROM tbl_gallery
		LEFT JOIN tbl_category ON tbl_gallery.cat_id= tbl_category.cid 
		ORDER BY tbl_gallery.id DESC";
		}
	else
	{
		$query="SELECT cid,category_name,category_image FROM tbl_category ORDER BY tbl_category.cid DESC";
	}
	
	$resouter = mysql_query($query);
     
    $set = array();
     
    $total_records = mysql_numrows($resouter);
    if($total_records >= 1){
     
      while ($link = mysql_fetch_array($resouter, MYSQL_ASSOC)){
	   
        $set['Online Mp3'][] = $link;
      }
    }
     
     echo $val= str_replace('\\/', '/', json_encode($set));
	 	 
	 
?>