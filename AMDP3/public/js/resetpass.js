$(document).ready(function()
{
	$('#customer').css('background-color','#3498db');
	$('#customer').css('color','#fff');
	$('#staff').css('background-color','#fff');
	$('#staff').css('color','#000000');
	$('#staff').css('border-bottom','2px solid #fff');
});

function reqPage(serverPage)
{
	$('#customer').click(function()
	{
		$('#customer').css('background-color','#3498db');
		$('#customer').css('color','#fff');
		$('#customer').css('border-bottom','2px solid #3498db');
		$('#staff').css('background-color','#fff');
		$('#staff').css('color','#000000');
		$('#staff').css('border-bottom','2px solid #fff');
	});
	$('#staff').click(function()
	{
		$('#staff').css('background-color','#3498db');
		$('#staff').css('color','#fff');
		$('#staff').css('border-bottom','2px solid #3498db');
		$('#customer').css('background-color','#fff');
		$('#customer').css('color','#000000');
		$('#customer').css('border-bottom','2px solid #fff');
	});
	$.ajax(
	{
		type: 'GET',
		url : '/AMDP3/views/resetpass/reset/'+serverPage,
		success : function(data)
		{
			$('#resetDiv').html(data);
		}
	});
}