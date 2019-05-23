$(document).ready(function()
{	
	$('.bookingLocationTable').css('margin-top','25px');
	$('#locationDropdown').on('change', function()
	{
		$('#onlineBookDetailContent').html('');
		//resets content
		$.ajax(
		{
			type: 'GET',
			url : 'locationmapping.php',
			data : {id : $('#locationDropdown').val()},
			success : function(data)
			{
				$('#onlineBookMapping').html(data);
			}
		});
	});
});

function firstRun()
{
	$.ajax(
	{
		type: 'GET',
		url : 'locationmapping.php',
		data : {id : $('#locationDropdown').val()},
		success : function(data)
		{
			$('#onlineBookMapping').html(data);
		}
	});
}