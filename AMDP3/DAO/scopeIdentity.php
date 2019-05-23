<?php 
	class ScopeIdentity
	{
		private $scopeIdentitySP = 
		"
		CREATE PROCEDURE scopeIdentity
		AS
		BEGIN
			SELECT SCOPE_IDENTITY() as id
		END
		";

		function getScopeIdentity()
		{
			include "$_SERVER[DOCUMENT_ROOT]/AMDP3/DB/connection.php";

			$query = 
			"{CALL scopeIdentity}";

			$pst = sqlsrv_query($con, $query);
			if($pst == false) //SP exec fails
			{
				$createSP = sqlsrv_query($con, $this->scopeIdentitySP); //try to create SP
				$pst = sqlsrv_query($con, $query);
			}
			if($pst)
			{
				while($obj = sqlsrv_fetch_object($pst))
				{
					//
					$id = $obj->id;
					return $id;
				}
			}
		}
	}
 ?>