function customerRegisValidation()
{
	var flag = true;
	var name = $('#name').val().trim();
	var address = $('#address').val().trim();
	var hp = $('#HP').val().trim();
	var email = $('#email').val().trim();
	var password = $('#password').val().trim();

	var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
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
	if(!regex.test(email))
	{
		$('#warningEmail').html("Invalid email");
		$('#warningEmail').css('margin-left','1%');
		flag = false;
	}
	else
	{
		$('#warningEmail').html("");
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
	//console.log($("#picture").val().replace(/^.*\./, ''));
	var pictureExt = '.'+$("#picture").val().replace(/^.*\./, '');
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
	if(flag == false)
	{
		flag = true;
		return false;
	}

	return true;
}

$(document).ready(function()
{
	var formregister = document.getElementById('customerRegisForm');
	formregister.onsubmit = function(e){
		e.preventDefault();
		if(customerRegisValidation()){
			this.submit();
		}
	};
});