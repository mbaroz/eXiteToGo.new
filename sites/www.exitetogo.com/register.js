function doRegisterNewCustomer() {
	var reg_details=$(".registerForm form").serialize();
	
	$(".etg_message").load("doRegister.php?params=1&"+reg_details);
	return false;
}