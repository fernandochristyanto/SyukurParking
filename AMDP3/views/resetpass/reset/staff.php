<div class="resetDivContent">
	<form action="reset/submitreset.php" method="POST" role="form">
		<input type="hidden" name="role" value="staff">
		<div class="form-group">
			<label for="ktp">ID Card Number</label>
			<input type="text" class="form-control" id="ktp" name="ktp" placeholder="123456789">
		</div>

		<div class="form-group">
			<label for="tglLahir">Birth Date</label>
			<input type="date" class="form-control" id="tglLahir" name="tglLahir" placeholder="Input field">
		</div>

		<div class="form-group">
			<label for="email">Email Address</label>
			<input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
		</div>
		
		
		<button type="submit" class="btn btn-primary">Reset My Password</button>
	</form>
</div>