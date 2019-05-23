function staffEditValidation()
{
	var flag = true;
	var name = $('#name').val().trim();
	var address = $('#address').val().trim();
	var hp = $('#HP').val().trim();
	var password = $('#password').val().trim();

	if(name == '')
	{
		$('#warningName').html("Please fill out name");
		$('#warningName').css('margin-left','1%');	
		flag = false;
	}
	else
	{
		$('#warningName').html("");
	}
	if(!address.includes('Jalan'))
	{
		$('#warningAddress').html("Address must contain 'Jalan'");
		$('#warningAddress').css('margin-left','1%');
		flag = false;
	}
	else
	{
		$('#warningAddress').html("");
	}
	if(hp == '')
	{
		$('#warningHP').html("Please fill out Phone Number");
		$('#warningHP').css('margin-left','1%');
		flag = false;
	}
	else
	{
		$('#warningHP').html("");
	}
	if(password == '')
	{
		$('#warningPassword').html("Please fill out password");
		$('#warningPassword').css('margin-left','1%');
		flag = false;
	}
	else
	{
		$('#warningPassword').html("");	
	}
	var pictureExt = '.'+$("#picture").val().replace(/^.*\./, '');
	if(!$('#picture').val()=='')
	{
		if(!(/\.(gif|jpg|jpeg|tiff|png)$/i).test(pictureExt))
		{
			$('#warningPicture').html("Invalid extension uploaded");
			$('#warningPicture').css('margin-left','1%');
			flag = false;
		}
		else
		{
			if($("#picture")[0].files[0].size/1024/1024>2)
			{
				//console.log($("#picture")[0].files[0].size/1024/1024);
				$('#warningPicture').html("File bigger than 2mb");
				$('#warningPicture').css('margin-left','1%');
				flag = false;
			}
			else
			{
				$('#warningPicture').html('');
			}
		}
	}
	if(flag == false)
	{
		flag = true;
		return false;
	}

	return true;
}

$(document).ready(function()
{
	var formEdit = document.getElementById('staffEditProfile');
	formEdit.onsubmit = function(e){
		e.preventDefault();
		if(staffEditValidation())
		{
			this.submit();
		}
	};
});