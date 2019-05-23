setInterval(function()
{
	$.ajax(
	{
		type: 'GET',
		url : 'getcurrtime.php',
		success : function(data)
		{
			$('#currTime').html(data);
		}
	});	
},1000);

$(document).on('input','#checkoutTxt', function()
{
	//shows the invoice 

	var input = $('#checkoutTxt').val();
	var locationId = $('#locId').val();

	$.ajax(
	{
		type: 'GET',
		url : 'generateinvoice.php',
		data : 
		{
			input : input,
			locationId : locationId
		},
		success : function(data)
		{
			if(data == 0)
			{
				$('#invoice').html('');
			}
			else
			{
				$('#invoice').html(data);	
			}
		}
	});	
});

$(document).on('click', '#generateBillBtn', function()
{
	//prints the bill
	if($('#parkingBookingId').length)
	{
		var trParkingBookingId = $('#parkingBookingId').val();

		console.log(trParkingBookingId);

		$.ajax(
		{
			type: 'POST',
			url : 'generatebill.php',
			data : 
			{
				trParkingBookingId : trParkingBookingId
			},
			success : function(data)
			{
				console.log(data);
				$('#checkoutTxt').val('');
				$('#invoice').html('');	
			}
		});	
	}
});