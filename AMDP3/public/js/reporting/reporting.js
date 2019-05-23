$(document).ready(function()
{
	$('#view').on('click',function()
	{
		var sdate = $('#startDate').datepicker('getDate');
		var edate = $('#endDate').datepicker('getDate');

		var startD = sdate.getDate();
		var startMo = sdate.getMonth() + 1;
		var startY = sdate.getFullYear();

		var endD = edate.getDate();
		var endMo = edate.getMonth() + 1;
		var endY = edate.getFullYear();
		

		if(!startDate == '' && !endDate == '')
		{
			$.ajax(
			{
				type: 'GET',
				url : 'getreport.php',
				data : 
				{
					startD : startD,
					startMo : startMo,
					startY : startY,
					endD : endD,
					endMo : endMo,
					endY : endY
				},
				success : function(data)
				{
					$('#reportResult').html(data);
				}
			});	
		}
	});
});