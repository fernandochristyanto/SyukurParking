function staffRegisValidation()
{
	var flag = true;
	var name = $('#name').val().trim();
	var ktp = $('#ktp').val().trim();
	var address = $('#address').val().trim();
	var birthDate = $('#tglLahir').val();
	var hp = $('#HP').val().trim();
	var joinDate = $('#tglGabung').val();
	var email = $('#email').val().trim();
	var password = $('#password').val().trim();

	var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var date_regex = /(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/;
	var date_regex2 = /^((0|1)\d{1})-((0|1|2)\d{1})-((19|20)\d{2})/;
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
	if(ktp == '')
	{
		$('#warningKtp').html("Please fill out ID Card");
		$('#warningKtp').css('margin-left','1%');	
		flag = false;
	}
	else
	{
		$('#warningKtp').html("");
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
	if($("#pria").attr("checked", "checked")||$("#wanita").attr("checked", "checked"))
	{
		$('#warningGender').html("");
	}
	else
	{
		$('#warningGender').html("Address must contain 'Jalan'");
		$('#warningGender').css('margin-left','1%');
		flag = false;	
	}
	// console.log(birthDate);
	// if(!date_regex.test(birthDate)&&!date_regex2.test(birthDate))
	// {
	// 	$('#warningTglLahir').html("Invalid Date");
	// 	$('#warningTglLahir').css('margin-left','1%');
	// 	flag = false;
	// }
	// else
	// {
	// 	$('#warningTglLahir').html("");
	// }
	if(birthDate == '')
	{
		$('#warningTglLahir').html("Column must not be empty");
		$('#warningTglLahir').css('margin-left','1%');
		flag = false;	
	}
	else
	{
		$('#warningTglLahir').html("");
	}
	if(joinDate == '')
	{
		$('#warningTglGabung').html("Column must not be empty");
		$('#warningTglGabung').css('margin-left','1%');
		flag = false;	
	}
	else
	{
		$('#warningTglGabung').html("");
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
	// if(!date_regex.test(joinDate) && !date_regex2.test(joinDate))
	// {
	// 	$('#warningTglGabung').html("Invalid Date");
	// 	$('#warningTglGabung').css('margin-left','1%');
	// 	flag = false;
	// }
	// else
	// {
	// 	$('#warningTglGabung').html("");
	// }
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
	var formregister = document.getElementById('staffRegisForm');
	formregister.onsubmit = function(e){
		e.preventDefault();
		if(staffRegisValidation()){
			this.submit();
		}
	};
});