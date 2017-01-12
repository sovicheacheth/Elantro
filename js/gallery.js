function checkValidation()
{
	 
	if(document.getElementById('category_id').value=="")
	{
		alert("Please Select Category.!");
		 
		document.getElementById('category_id').focus();		 
		return false;
	}
	if(document.getElementById('mp3_title').value=="")
	{
		alert("Please enter mp3 title!");
		 
		document.getElementById('mp3_title').focus();
		document.getElementById('mp3_title').select();		 
		return false;
	}
	if(document.getElementById('upload_type').value=="")
	{
		alert("Please enter mp3 uplaod method!");
		 
		document.getElementById('upload_type').focus();		 
		return false;
	}
	if((document.getElementById('server_url').value=="")&&(document.getElementById('upload_type').value=="server"))
	{
		alert(" Insert a Path of mp3!");
		 
		document.getElementById('mp3_url').focus();
		document.getElementById('mp3_url').select();
		 
		return false;
	}
	if((document.getElementById('local_url').value=="")&&(document.getElementById('upload_type').value=="local"))
	{
		alert("Please select a mp3 from your device");
		 
		document.getElementById('local_url').focus();
		document.getElementById('local_url').select();
		 
		return false;
	}
	
		if(document.getElementById('share_url').value=="")
	{
		alert("Please enter mp3 share_url!");
		 
		document.getElementById('share_url').focus();	
		document.getElementById('share_url').select();	 
		return false;
	}

	if(document.getElementById('mp3_duration').value=="")
	{
		alert("Please enter mp3 duration!");
		 
		document.getElementById('mp3_duration').focus();
		document.getElementById('mp3_duration').select();
		 
		return false;
	}
	
	if(document.getElementById('mp3_description').value=="")
	{
		alert("Please enter mp3 description!");
		 
		document.getElementById('mp3_description').focus();	
		document.getElementById('mp3_description').select();	 
		return false;
	}
	 
	 
	return true;
} 
function editValidation()
{
	 
	if(document.getElementById('category_id').value=="")
	{
		alert("Please Select Category.!");
		 
		document.getElementById('category_id').focus();		 
		return false;
	}
	if(document.getElementById('mp3_title').value=="")
	{
		alert("Please enter mp3 title!");
		 
		document.getElementById('mp3_title').focus();
		document.getElementById('mp3_title').select();		 
		return false;
	}
	
	
	if(document.getElementById('mp3_duration').value=="")
	{
		alert("Please enter mp3 duration!");
		 
		document.getElementById('mp3_duration').focus();
		document.getElementById('mp3_duration').select();
		 
		return false;
	}
	if(document.getElementById('mp3_description').value=="")
	{
		alert("Please enter mp3 description!");
		 
		document.getElementById('mp3_description').focus();	
		document.getElementById('mp3_description').select();	 
		return false;
	}
	if(document.getElementById('mp3_description').value.length<20)
	{
		alert("Please enter mp3 description at least 20 characters.!");
		 
		document.getElementById('mp3_description').focus();
		document.getElementById('mp3_description').select();
		return false;
	}
	
	 
	return true;
}