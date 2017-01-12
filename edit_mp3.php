<?php include("includes/header.php");

	require("includes/function.php");
	$kwallpaper=new  k_wallpaper;
	
	
	//Get all Category 
	$qry="SELECT * FROM tbl_category";
	$result=mysql_query($qry);
	
	if(isset($_GET['mp3_id']))
	{
		$mp3_qry="SELECT * FROM  tbl_gallery WHERE id='".$_GET['mp3_id']."'";
		$mp3_res=mysql_query($mp3_qry);
		$mp3_row=mysql_fetch_assoc($mp3_res);
		 
		 
	}
	 	
	if(isset($_POST['submit']) and isset($_GET['mp3_id']))
	{
	 
		$kwallpaper->editmp3();
		
		 
		echo "<script>document.location='manage_gallery.php';</script>"; 
	    exit;
		
	}	
	 
?>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#upload_type").change(function () {
                var type = $("#upload_type").val();
                if (type == "server") {
                    $("#server").show();
                    $("#local").hide();
                    $("#progressBar").hide();
                    $("#server_url").show();
                    $("#thumbnail").hide();
                } else if (type == "local") {
                    $("#local").show();
                    $("#server").hide();
                    $("#progressBar").show();
                    $("#server_url").hide();
                    $("#thumbnail").show();
                } else {
                    $("#server").hide();
                    $("#local").hide();
                    $("#progressBar").hide();
                    $("#server_url").hide();
                    $("#thumbnail").hide();
                }

            });
        });
    </script>
    <script>
        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
            var file = _("local_url").files[0];
            var formdata = new FormData();
            formdata.append("local_url", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            ajax.open("POST", "file_upload_parser.php");
            ajax.send(formdata);

        }

        function progressHandler(event) {
            _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
            _("status").innerHTML = Math.round(percent) + "% uploaded... please wait";
        }

        function completeHandler(event) {
            _("status").innerHTML = event.target.responseText;
            _("progressBar").value = 0;
        }

        function errorHandler(event) {
            _("status").innerHTML = "Upload Failed";
        }

        function abortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
        }
    </script>
    <script src="js/gallery.js" type="text/javascript"></script>

    <!-- h2 stays for breadcrumbs -->
    <div id="main">
        <h2><a href="home.php">Dashboard</a> &raquo; <a href="#" class="active"></a></h2>
        <h3>Edit Mp3</h3>

        <form action="" method="post" enctype="multipart/form-data" onsubmit="">
            <fieldset>

                <p>
                    <label>Select Category:</label>


                    <select name="category_id" id="category_id">

                        <option value="0">--Select Category--</option>
                        <?php
												while($row=mysql_fetch_array($result))
												{
										 			if(isset($_POST['category']))
													{
															if($_POST['category']==$row['cid']){
															?>
                            <option value="<?php echo $row['cid'];?>" selected="selected">
                                <?php echo $row['category_name'];?>
                            </option>
                            <?php }else{?>
                                <option value="<?php echo $row['cid'];?>">
                                    <?php echo $row['category_name'];?>
                                </option>
                                <?php 				}?>

                                    <?php }
													else
													{
														 if($mp3_row['cat_id']==$row['cid']){
											 ?>
                                        <option value="<?php echo $row['cid'];?>" selected="selected">
                                            <?php echo $row['category_name'];?>
                                        </option>
                                        <?php }else{?>
                                            <option value="<?php echo $row['cid'];?>">
                                                <?php echo $row['category_name'];?>
                                            </option>
                                            <?php 				}
														}
												}
										?>
                    </select>
                </p>

                <p>
                    <label>Mp3 Title:</label>
                    <input type="text" name="mp3_title" id="mp3_title" value="<?php echo $mp3_row['mp3_title'];?>" class="text-long" placeholder="Test mp3" />
                </p>
                <p>Current mp3 Path:
                    <br/>
                    <?php echo $mp3_row['mp3_url'];?>
                </p>
                <p>
                    <audio controls>
                        <source src="<?php echo $mp3_row['mp3_url'];?>" type="audio/mpeg"> Your browser does not support the audio element.
                    </audio>

                </p>



                <p>
                    <label>Select mp3 Uplaod Option</label>
                    <select name="upload_type" id="upload_type" style="width:280px; height:25px;">
                        <option value="">--Select Category--</option>
                        <option value="server">upload from Server</option>
                        <option value="local">upload from your device</option>
                    </select>
                </p>
                <p id="server_url" style="display:none;">
                    <label>Server Mp3 Path</label>
                    <input type="text" name="server_url" id="server_url" class="text-long" placeholder="http://xyz.com/videoplayback_16.MP4" />
                </p>
                <p id="local" style="display:none;">
                    <label>Upload Mp3</label>
                    <input type="file" name="local_url" id="local_url" class="text-long" />
                    <input type="button" name="mp3" value="Upload File" onclick="uploadFile()">
                    <h3 id="status"></h3>
                    <progress id="progressBar" value="0" max="100" style="width:300px; height:20px;display:none;"></progress>
                    <label id="loaded_n_total"></label>
                </p>
                <p>
                    <label>Share Url:</label>
                    <input type="text" name="share_url" id="share_url" value="<?php echo $mp3_row['share_url'];?>" class="text-long" placeholder="http://example.com?p=12" />
                </p>
                <p id="thumbnail" style="display:none;">
                    <?php if($mp3_row['mp3_thumbnail']) {?>
                        <img src="images/thumbs/<?php echo $mp3_row['mp3_thumbnail'];?>" />
                        <?php } ?>
                            <label>Select Mp3 Thumbnail</label>
                            <input type="file" name="thumbnail" id="thumb" class="text-long" />
                </p>
                <p>
                    <label>Mp3 Duration:</label>
                    <input type="text" name="mp3_duration" id="mp3_duration" value="<?php echo $mp3_row['mp3_duration'];?>" class="text-long" placeholder="3:50" />
                </p>
                <p>
                    <label>mp3 Description:</label>
                    <textarea name="mp3_description" id="mp3_description" class="text-long">
                        <?php echo $mp3_row['mp3_description'];?>
                    </textarea>
                </p>

                <input type="submit" name="submit" value="Edit mp3" />
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