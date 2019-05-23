$(document).on('click','.available', function()
{
	// console.log(this.id);
	//==> locationId - row - col

	var id = this.id;
	var locationId = id.slice(0,id.search('-')).trim();
	// console.log('LocationId : '+locationId);
	var row = id.slice(id.search('-')+1, id.lastIndexOf('-')).trim();
	// console.log('row : '+row);
	var col = id.slice(id.lastIndexOf('-')+1, id.length).trim();
	// console.log('col : '+col);

	$.ajax(
	{
		type: 'GET',
		url : 'locationdetail.php',
		data : {
			locationId : locationId,
			row : row,
			col : col
		},
		success : function(data)
		{
			$('#onlineBookDetailContent').html(data);
		}
	});
});

function checkBookingDetail()
{
	if($('#agreement').prop("checked") == false)
	{
		alert('You need to check the agreement');
		return false;
	}
	return true;	
}

$(document).on('submit','#bookingForm',function(e)
{
	e.preventDefault();
	if(checkBookingDetail())
	{
		this.submit();
	}
});