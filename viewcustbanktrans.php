<?php
include("header.php");
include("sidebar.php");

if(isset($_GET['trans_id']))
{
	$sql = "UPDATE transaction SET payment_status='$_GET[st]' WHERE trans_id='$_GET[trans_id]'";
	$qsql = mysqli_query($con,$sql);
	if(mysqli_affected_rows($con) ==1 )
	{
		echo "<script>alert('Transaction record updated successfully...');</script>";
	}
	$sqltransaction = "SELECT * FROM transaction WHERE trans_id='$_GET[trans_id]'";
	$qsqltransaction = mysqli_query($con,$sqltransaction);
	$rstransaction = mysqli_fetch_array($qsqltransaction);
	$sqltransaction = "UPDATE accounts SET unclear_bal=unclear_bal-$rstransaction[amount],acc_balance=acc_balance+$rstransaction[amount],transaction_type='Credit' WHERE acc_no='$_GET[acno]'";
	$qsqltransaction = mysqli_query($con,$sqltransaction);	
/*	
	$sql = "UPDATE accounts SET payment_status='$_GET[st]' WHERE trans_id='$_GET[trans_id]'";
	$qsql = mysqli_query($con,$sql);
*/	
	//acno
}
?> 
      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">

          <h1>View Transactions</h1>
          <p>View Transactions records.</p>

          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
<table  id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
<thead>
  <tr>
    <th scope="col">&nbsp;Account No.</th>
    <th scope="col">&nbsp;Amount</th>
    <th scope="col">&nbsp;Particulars</th>
    <th scope="col">&nbsp;Transaction Type</th>
    <th scope="col">&nbsp;Transaction date time</th>
    <th scope="col">&nbsp;Approve Date time</th>
    <th scope="col">&nbsp;Payment status</th>
  </tr>
  </thead>
  <tbody>
 <?php 
 $sql ="SELECT * FROM transaction INNER JOIN accounts ON transaction.to_acc_no=accounts.acc_no WHERE accounts.customer_id='$_SESSION[customer_id]'";
 $qsql = mysqli_query($con,$sql);
 while($rs = mysqli_fetch_array($qsql))
 {
  echo "<tr><td>";
  if($rs['from_acc_no'] != 0)
  {
	  echo "From : " . $rs['from_acc_no'] . "<hr />";
  }
	echo $rs['to_acc_no'];
	echo "</td>
    <td>$_SESSION[currency] $rs[amount]</td>
    <td>$rs[particulars]</td>
	<td>$rs[transaction_type]</td>
	<td>" .  date("d-M-Y H:i A",strtotime($rs['trans_date_time'])) ."</td>
	<td>" .  date("d-M-Y H:i A",strtotime($rs['approve_date_time'])) ."</td>
	<td>";
	if($rs['payment_status'] == "Active")
	{
		echo "Approved";
	}
	else
	{
		echo $rs['payment_status'];
	}
	echo "</td>
	</tr>";
  }
?> 
</tbody> 
</table>
            </div>
          </div>
        </div>
      </div>

<script type="application/javascript">
function confirmtransaction()
{
	if(confirm("Are you sure want to approve this transaction?") == true)
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