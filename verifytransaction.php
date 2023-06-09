<?php
session_start();
include("dbconnection.php");
if(isset($_GET['trpass']))
{
	$trpass = md5($_GET['trpass']);
	$sqlcustomer = "SELECT * FROM customer where customer_id='$_SESSION[customer_id]' AND trans_password='$trpass'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	$rscustomer = mysqli_fetch_array($qsqlcustomer);
	//verifytransaction.php?otp="+otp+"&trpass="+trpass
	if((mysqli_num_rows($qsqlcustomer) == 1))
	{
		echo "1";
	}
	else
	{
		?>
        <font color='red'>Invalid credentials..</font> <button type="button" class="btn btn-default" onClick="otpverification()">Verify</button>
        <?php		
	}
}
else
{
	$sqlcustomer = "SELECT * FROM customer where customer_id='$_SESSION[customer_id]'";
	$qsqlcustomer = mysqli_query($con,$sqlcustomer);
	$rscustomer = mysqli_fetch_array($qsqlcustomer);
}
?>