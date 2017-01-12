<?php error_reporting(0);
require_once("thumbnail_images.class.php");
class k_wallpaper
{

//Category Query	
	function addCategory()
	{
		
		
		
		
		$albumimgnm=rand(0,99999)."_".$_FILES['image']['name'];
			 $pic1=$_FILES['image']['tmp_name'];
			  if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$albumimgnm;
				
				 copy($pic1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$albumimgnm;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  else
						  {
						  		 
								$cat_result=mysql_query('INSERT INTO `tbl_category` (`category_name` ,`category_image`) VALUES (  \''.addslashes($_POST['category_name']).'\',\''.$albumimgnm.'\')');
		
								
						  }

		
	}
	
	function editCategory()
	{
			 
			 
	if($_FILES['image']['name']=="")
		 {
		
		$cat_result=mysql_query('UPDATE `tbl_category` SET `category_name`=\''.addslashes($_POST['category_name']).'\' WHERE cid=\''.$_GET['cat_id'].'\'');

		}
		else
		{
		
			//Image Unlink
			
			$img_res=mysql_query('SELECT * FROM tbl_category WHERE cid=\''.$_GET['cat_id'].'\'');
			$img_row=mysql_fetch_assoc($img_res);
			
			if($img_row['category_image']!="")
			{
				unlink('images/'.$img_row['category_image']);
				unlink('images/thumbs/'.$img_row['category_image']);
			}	
		
			//Image Upload
			$albumimgnm=rand(0,99999)."_".$_FILES['image']['name'];
			 $pic1=$_FILES['image']['tmp_name'];
			   
		
			   if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$albumimgnm;
				
				 copy($pic1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$albumimgnm;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  else
						  {
						  		 
								 $cat_result=mysql_query('UPDATE `tbl_category` SET `category_name`=\''.addslashes($_POST['category_name']).'\',`category_image`=\''.$albumimgnm.'\' WHERE cid=\''.$_GET['cat_id'].'\'');
 	 
						  }
		}

			
	}
	
	function deleteCategory()
	{
		
		
		$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE cat_id=\''.$_GET['cat_id'].'\'');
		while($mp3_row=mysql_fetch_assoc($mp3_res)){
		
			if($mp3_row['mp3_url']!="")
			{
				$string=$mp3_row['mp3_url'];
				list($a,$b)=split('mp3/',$string);
				unlink('mp3/'.$b);
			}
			if($mp3_row['mp3_thumbnail']!="")
			{
				unlink('images/thumbs/'.$mp3_row['mp3_thumbnail']);
				unlink('images/'.$mp3_row['mp3_thumbnail']);
			}
		}
		$mp3_result=mysql_query('DELETE FROM `tbl_gallery` WHERE cat_id=\''.$_GET['cat_id'].'\'');
		
		$img_res=mysql_query('SELECT * FROM tbl_category WHERE cid=\''.$_GET['cat_id'].'\'');
		$img_row=mysql_fetch_assoc($img_res);
			
			if($img_row['category_image']!="")
			{
				unlink('images/thumbs/'.$img_row['category_image']);
				unlink('images/'.$img_row['category_image']);
				 
			}	
		
		$cat_result=mysql_query('DELETE FROM `tbl_category` WHERE cid=\''.$_GET['cat_id'].'\'');
	}

 
//Image Gallery
	function addmp3()
	{
		
	if($_FILES['local_url']['name']!="")
	{	
	
	$mp3=$_FILES['local_url']['name'];
	$mp31=$_FILES['local_url']['tmp_name'];
	if(!is_dir('mp3'))
	{mkdir('mp3', 0777);
	}
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/mp3/';
	if($_FILES['thumbnail']['name']!="")	
	{
	$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  
	}
	$res=mysql_query('INSERT INTO `tbl_gallery` (`cat_id`,`mp3_title`,`mp3_url`,`share_url`,`mp3_thumbnail`,`mp3_duration`,`mp3_description`) VALUES (\''.$_POST['category_id'].'\',\''.addslashes($_POST['mp3_title']).'\',\''.$file_path.$mp3.'\',\''.$_POST['share_url'].'\',\''.$thumbname.'\',
	\''.$_POST['mp3_duration'].'\',\''.addslashes($_POST['mp3_description']).'\')');
}
	
	if($_POST['server_url']!="")
	{
		if($_FILES['thumbnail']['name']!="")	
	{
	$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						 
	}
	
		$mp3_id="000q1w2";
		$res=mysql_query('INSERT INTO `tbl_gallery` (`cat_id`,`mp3_title`,`mp3_url`,`share_url`,`mp3_thumbnail`,`mp3_duration`,`mp3_description`) VALUES (\''.$_POST['category_id'].'\',\''.addslashes($_POST['mp3_title']).'\',\''.$_POST['server_url'].'\',
		\''.$_POST['share_url'].'\',\''.$thumbname.'\',\''.$_POST['mp3_duration'].'\',\''.addslashes($_POST['mp3_description']).'\')');
	}
	
	}
		
	function editmp3()
	{
	if(($_FILES['local_url']['name']=="") &&($_POST["server_url"]==""))
	{
		if($_FILES['thumbnail']['name']!="")
	{
		$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  $mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
							  $mp3_row=mysql_fetch_assoc($mp3_res);
							  if($mp3_row['mp3_thumbnail']!="")
							{
							unlink('images/thumbs/'.$mp3_row['mp3_thumbnail']);
								unlink('images/'.$mp3_row['mp3_thumbnail']);
							}
	}
	else
	{
		$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
		$mp3_row=mysql_fetch_assoc($mp3_res);
		$thumbname=$mp3_row['mp3_thumbnail'];
	}
	$res=mysql_query('UPDATE `tbl_gallery` SET `cat_id`=\''.$_POST['category_id'].'\',`mp3_title`=\''.addslashes
	($_POST['mp3_title']).'\',`share_url`=\''.$_POST['share_url'].'\',`mp3_duration`=\''.$_POST['mp3_duration'].'\',`mp3_thumbnail`=\''.$thumbname.'\',`mp3_description`=\''.addslashes($_POST['mp3_description']).'\' WHERE id=\''.$_GET['mp3_id'].'\'');
	}
	
	else
	{
	if($_FILES['local_url']['name']!="")
	{	
	
	$mp3=$_FILES['local_url']['name'];
	$mp31=$_FILES['local_url']['tmp_name'];
		if(!is_dir('mp3'))
		{
			mkdir('mp3', 0777);
		}
	 
	
	$file_path = 'http://'.$_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/mp3/';
		
	$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
			$mp3_row=mysql_fetch_assoc($mp3_res);
			
			if($mp3_row['mp3_url']!="")
			{
				$string=$mp3_row['mp3_url'];
				list($a,$b)=split('mp3/',$string);
				unlink('mp3/'.$b);
			}
			
	if($_FILES['thumbnail']['name']!="")
	{
		$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  $mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
							  $mp3_row=mysql_fetch_assoc($mp3_res);
							  if($mp3_row['mp3_thumbnail']!="")
							{
							unlink('images/thumbs/'.$mp3_row['video_thumbnail']);
								unlink('images/'.$mp3_row['video_thumbnail']);
							}
	}
	else
	{
		$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
		$mp3_row=mysql_fetch_assoc($mp3_res);
		$thumbname=$mp3_row['mp3_thumbnail'];
	}
	$res=mysql_query('UPDATE `tbl_gallery` SET `cat_id`=\''.$_POST['category_id'].'\',`mp3_title`=\''.addslashes($_POST['mp3_title']).'\',`mp3_url`=\''.$file_path.$mp3.'\',`share_url`=\''.$_POST['share_url'].'\',`mp3_thumbnail`=\''.$thumbname.'\',`mp3_duration`=\''.$_POST['mp3_duration'].'\',`mp3_description`=\''.addslashes($_POST['mp3_description']).'\' WHERE id=\''.$_GET['mp3_id'].'\'');
	}
	
	
	else if($_POST['server_url']!="")
	{
		$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
			$mp3_row=mysql_fetch_assoc($mp3_res);
			
			if($mp3_row['mp3_url']!="")
			{
				$string=$mp3_row['mp3_url'];
				list($a,$b)=split('mp3/',$string);
				unlink('mp3/'.$b);
			}
	
	
	
		if($_FILES['thumbnail']['name']!="")
	{
		$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  $mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
							  $mp3_row=mysql_fetch_assoc($mp3_res);
							  if($mp3_row['mp3_thumbnail']!="")
							{
							unlink('images/thumbs/'.$mp3_row['mp3_thumbnail']);
								unlink('images/'.$mp3_row['mp3_thumbnail']);
							}
	}
	else
	{
		$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
		$mp3_row=mysql_fetch_assoc($mp3_res);
		$thumbname=$mp3_row['mp3_thumbnail'];
	}
	$res=mysql_query('UPDATE `tbl_gallery` SET `cat_id`=\''.$_POST['category_id'].'\',`mp3_title`=\''.addslashes($_POST['mp3_title']).'\',`mp3_url`=\''.$_POST['server_url'].'\',`share_url`=\''.$_POST['share_url'].'\',`mp3_thumbnail`=\''.$thumbname.'\',`mp3_duration`=\''.$_POST['mp3_duration'].'\',`mp3_description`=\''.addslashes($_POST['mp3_description']).'\' WHERE id=\''.$_GET['mp3_id'].'\'');
	}
	
	else if(($_FILES['thumbnail']['name']!="")&& $_POST["local_url"]=="")
	{
	$thumbname=rand(0,99999)."_".$_FILES['thumbnail']['name'];
			 $thumb1=$_FILES['thumbnail']['tmp_name'];
			 if(!is_dir('images'))
			   {
			
			   		mkdir('images', 0777);
			   }
			  $tpath1='images/'.$thumbname;
				
				 copy($thumb1,$tpath1);
				 
				 
					    $thumbpath='images/thumbs/'.$thumbname;
						$obj_img = new thumbnail_images();
						$obj_img->PathImgOld = $tpath1;
						$obj_img->PathImgNew =$thumbpath;
						$obj_img->NewWidth = 100;
						$obj_img->NewHeight = 100;
						if (!$obj_img->create_thumbnail_images()) 
						  {
							echo $_SESSION['msg']="Thumbnail not created... please upload image again";
						    exit;
						  }
						  else
						  {
							  $mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
							  $mp3_row=mysql_fetch_assoc($mp3_res);
							  if($mp3_row['mp3_thumbnail']!="")
							{
							unlink('images/thumbs/'.$mp3_row['mp3_thumbnail']);
								unlink('images/'.$mp3_row['mp3_thumbnail']);
							}
							  $res=mysql_query('UPDATE `tbl_gallery` SET `cat_id`=\''.$_POST['category_id'].'\',`mp3_title`=\''.addslashes($_POST['mp3_title']).'\',`mp3_url`=\''.$_POST['server_url'].'\',
		`share_url`=\''.$_POST['share_url'].'\',`mp3_thumbnail`=\''.$thumbname.'\',`mp3_duration`=\''.$_POST['mp3_duration'].'\',`mp3_description`=\''.addslashes($_POST['mp3_description']).'\' WHERE id=\''.$_GET['mp3_id'].'\'');
						  }
	}
	}	}
	
	function deletemp3()
	{
			$mp3_res=mysql_query('SELECT * FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
			$mp3_row=mysql_fetch_assoc($mp3_res);
			
			if($mp3_row['mp3_url']!="")
			{
				$string=$mp3_row['mp3_url'];
				list($a,$b)=split('mp3/',$string);
				unlink('mp3/'.$b);
			}
		
			if($mp3_row['mp3_thumbnail']!="")
			{
				unlink('images/thumbs/'.$mp3_row['mp3_thumbnail']);
				unlink('images/'.$mp3_row['mp3_thumbnail']);
			}
			
			$img_result=mysql_query('DELETE FROM `tbl_gallery` WHERE id=\''.$_GET['mp3_id'].'\'');
	}	
	
	function editProfile()
 {
    
   $res=mysql_query('UPDATE `tbl_admin` SET `username`=\''.$_POST['username'].'\',`password`=\''.$_POST['password'].'\',`email`=\''.$_POST['email'].'\' WHERE id=\''.$_SESSION['id'].'\'');
 }	
}
?>