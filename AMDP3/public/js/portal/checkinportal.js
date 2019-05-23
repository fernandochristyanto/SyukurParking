$(document).ready(function()
{
	$('#bookingNumberTxt').on('input',function()
	{
		var bookingNumber = $('#bookingNumberTxt').val();
		var locationId = $('#locId').val();

		$.ajax(
		{
			type: 'POST',
			url : 'inputbookingnumber.php',
			data : 
			{
				bookingNumber : bookingNumber,
				locationId : locationId
			},
			success : function(data)
			{
				if(data == 1)
				{
					$('#panelbtnDiv').html('<button type="button" class="btn btn-default" id="bookedTicketBtn">Get Booked Ticket</button>');	
				}
				else
				{
					$('#panelbtnDiv').html('<button type="button" class="btn btn-default" id="ticketBtn">Get Ticket</button>');
				}
			}
		});	
	});
});

setInterval(function()
{
	var locationId = $('#locId').val();

	$.ajax(
	{
		type: 'GET',
		url : 'getlocationdetail.php',
		data : {
			locationId : locationId
		},
		success : function(data)
		{
			$('#locationDetail').html(data);
		}
	});	
},1000);

setInterval(function()
{
	$.ajax(
	{
		type: 'GET',
		url : '../home/checkbookingvalidity.php'
	});	
},10000);

$(document).on('click','#ticketBtn', function()
{
	console.log('clickbtn');
	//generate ticket for customer

	var locationId = $('#locId').val();
	var vehicleType = $('#vehicleType').val();

	$.ajax(
	{
		type: 'POST',
		url : 'generateticket.php',
		data : {
			booked : 0,
			vehicleType : vehicleType,
			locationId : locationId
		},
		success : function(data)
		{
			console.log(data);
			$('#bookingNumberTxt').val('');
		}
	});	
});

$(document).on('click','#bookedTicketBtn', function()
{
	//generate ticket for BOOKED customer
	console.log('clicktbtn');
	var locationId = $('#locId').val();
	var vehicleType = $('#vehicleType').val();
	var bookingNumber = $('#bookingNumberTxt').val();

	$.ajax(
	{
		type: 'POST',
		url : 'generateticket.php',
		data : {
			booked : 1,
			bookingId : bookingNumber,
			vehicleType : vehicleType,
			locationId : locationId
		},
		success : function(data)
		{
			console.log(data);
			$('#bookingNumberTxt').val('');	
			$('#panelbtnDiv').html('<button type="button" class="btn btn-default" id="ticketBtn">Get Ticket</button>');
		}
	});	
});