<?php
include("header.php");
include("sidebar.php");
if(isset($_GET['delid']))
{
	$sql = "DELETE FROM loan WHERE loan_acc_no='$_GET[delid]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) ==1 )
	{
		echo "<script>alert(' Loan record deleted successfully...');</script>";
	}
}
?> 

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">

          <h1>View Loan Accounts</h1>
          <p>View Loan records.</p>
 
          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                    <table  id="example"  class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th scope="col">&nbsp;Loan Account No</th>
                        <th scope="col">&nbsp;Loan Type</th>
                        <th scope="col">&nbsp;Created Date</th>
                        <th>Last date</th>
                        <th scope="col">&nbsp;Loan Amount</th>
                        <th scope="col">&nbsp;Interest Amount</th>
                        <th scope="col">&nbsp;Total Payable</th>
                        <th scope="col">&nbsp;Total Paid</th>
                        <th scope="col">&nbsp;Balance</th>
                        <th scope="col">&nbsp;Action</th>
                      </tr>
                      </thead>
                      <tbody>
                     <?php 
                     $sql ="SELECT * FROM loan WHERE customer_id='$_SESSION[customer_id]' AND status='Active'";
                     $qsql = mysqli_query($con,$sql);
                     while($rs = mysqli_fetch_array($qsql))
                     {
                            $sqlloan_type= "SELECT * FROM loan_type where loan_type_id='$rs[loan_type_id]'";
                            $qsqlloan_type = mysqli_query($con,$sqlloan_type);
                            $rsloan_type = mysqli_fetch_array($qsqlloan_type);
                            $totamt =  $rs['loan_amt'] + ($rs['loan_amt'] * $rs['interest'] /100);
                            
                            $sqlloan_payment= "SELECT IFNULL(SUM(paid),0) FROM loan_payment where loan_acc_no='$rs[loan_acc_no]'";
                            $qsqlloan_payment = mysqli_query($con,$sqlloan_payment);
                            $rsloan_payment = mysqli_fetch_array($qsqlloan_payment);
                            $paidamt =$rsloan_payment[0];
                            
                            $sqlcustomer= "SELECT * FROM customer where customer_id='$rs[customer_id]'";
                            $qsqlcustomer = mysqli_query($con,$sqlcustomer);
                            $rscustomer = mysqli_fetch_array($qsqlcustomer);
                            
                            $pendingamt =$totamt - $paidamt ;
							
							if($pendingamt != 0)
							{
							echo "<tr>
							<td>&nbsp;$rs[loan_acc_no]</td>
							<td>&nbsp;$rsloan_type[loan_type]</td>
							<td>&nbsp;" .  date("d-M-y",strtotime($rs['create_date'])) ."</td>
							<td>&nbsp;";
							$year = "$rsloan_type[terms] years";
							$acdate =$rs['create_date'];
							echo date('d-m-Y', strtotime($year, strtotime($acdate)));
							echo "</td>
							<td>&nbsp;$_SESSION[currency] $rs[loan_amt]</td>
							<td>&nbsp;$_SESSION[currency]  ". ($rs['loan_amt'] * $rs['interest'] /100). " ($rs[interest]%)</td>
							<td>&nbsp;$_SESSION[currency]  ". $totamt . " </td>
							<td>&nbsp;$_SESSION[currency]  ". $paidamt . " </td>
							<td>&nbsp;$_SESSION[currency]  ". $pendingamt . " </td>
							<td>&nbsp;<a href='viewloanacdetailed.php?loan_acc_no=$rs[loan_acc_no]'>View</a></td>
							</tr>";
							}
                      }
                    ?>
                    </tbody>
                    </table>
            </div>
          </div>
        </div>
      </div>
      </div>

<script type="application/javascript">
function confirmtodelete()
{
	if(confirm("Are you sure want to delete this record?") == true)
	{
		return true;
	}
	else
	{
		return false; 
	}
}
</script>
<?php
include("datatables.php");
include("footer.php");
?>