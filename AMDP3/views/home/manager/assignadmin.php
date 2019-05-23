<?php  
	if(!empty($_POST['chosenstaff']))
	{
		include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DAO/staffDAO.php";

		$staffDAO = new StaffDAO();

		foreach($_POST['chosenstaff'] as $staffId) 
		{
			$s = $staffDAO->getById($staffId);
			$s->setRole('admin');
			echo $s->role;
			$staffDAO->update($s);
		}
	}	
	header("Location:../parkingavailability.php");
?>