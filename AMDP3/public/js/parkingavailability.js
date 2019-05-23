$(document).ready(function()
{	
	//resets content
	$.ajax(
	{
		type: 'GET',
		url : 'getparkingavailability.php',
		success : function(data)
		{
			$('.parkingSpots').html(data);
		}
	});
});

function getTables()
{
	$.ajax(
	{
		type: 'GET',
		url : 'getparkingavailability.php',
		success : function(data)
		{
			$('.parkingSpots').html(data);
		}
	});
}

setInterval(function()
{
	$.ajax(
	{
		type: 'GET',
		url : 'checkbookingvalidity.php'
	});
	getTables();
},10000);