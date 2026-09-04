<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM payments where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
	$idd = $_SESSION['login_username'];
    $stmt = $conn->prepare("SELECT * FROM student WHERE id_no=?");
    $stmt->bind_param("s", $idd);
    $stmt->execute();
    $result = $stmt->get_result();
    $stdid_noname = $result->fetch_array();
	$sid=$stdid_noname['id'] ; 
	$query=mysqli_query($conn,"select * from payments where ef_id=$sid order by id desc limit 1");
	$paymentresult=mysqli_fetch_assoc($query);
	//$id=$paymentresult['id'];
?>
<div class="containe-fluid" style="font-size: 16px;">
<div class="row mt-9 ml-0 mr-0">
<div class="col-lg-7">
<div class="card">
<div class="card-body">
	<form id="manage-payment" action="#" method="post">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<h4 class="form-group text-left">Payment</h4>
		<div class="form-group">
    <?php

    $fees = $conn->query("SELECT ef.*, s.name as sname, s.id_no FROM student_ef_list ef INNER JOIN student s ON s.id = ef.student_id WHERE s.id_no = '$idd'");
    $row = $fees->fetch_assoc();
	if(!empty($row['id'])){
    $paid = $conn->query("SELECT SUM(amount) AS paid FROM payments WHERE ef_id=" . $row['id'] . (isset($id) ? " AND id!=$id " : ''));
    $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid'] : '';
    $balance = $row['total_fee'] - $paid;
	}
    ?>
    <div class="form-group">
        <label for="" class="control-label">MKPT NO./Student</label>
		<input type="hidden" name="student_id" value="<?php echo $stdid_noname['id'] ?>">
		<!-- <input type="text" class="form-control text-right" id="stdid_noname" name="stud_id" value="<?php echo $stdid_noname['id_no'] ?>" readonly> -->
        <input type="text" class="form-control text-right" id="stdid_noname" name="stud_id" value="<?php echo $stdid_noname['id_no'] . ' | ' . ucwords($stdid_noname['name']) ?>" readonly>
    </div>
</div>
<div class="form-group">
    <label for="" class="control-label">Total Payable Fees</label>
    <input type="text" class="form-control text-right" id="balance" name="balance" value="<?php echo isset($balance) ? $balance : 0 ?>" required readonly>
</div>
<div class="form-group">
    <label for="" class="control-label">Amount</label>
    <input type="text" class="form-control text-right" name="amount" value="<?php echo isset($amount) ? number_format($amount) : 0 ?>" required>
</div>
<div class="modal-footer">
	<input type="submit" name="pay1" class="btn btn-primary" value="Pay">
</div>

</form>
</div></div></div>
</div>
</div>
<?php
if (isset($_POST['pay1'])) {
    $payment_id = $_POST['id'];
    $student_id1 = $_POST["student_id"];
    $balance = $_POST['balance'];
    $amount = $_POST['amount'];

    // Check if the payment is already processed for this transaction
    $stmt = $conn->prepare("SELECT id FROM payments WHERE ef_id = ?");
    $stmt->bind_param("i", $student_id1);
    $stmt->execute();
    $pay = $stmt->get_result();
    $pay = $result->fetch_array();

    if (empty($pay['id'])) {
        if ($balance > 0 && $balance!=0) 
		{
            if ($amount > $balance) 
			{
                echo "<script>alert('Amount is greater than Total Payable Fees')</script>";
            } 
			elseif ($amount == $balance && $balance != 0) 
			{
                // Insert payment into payments table using prepared statement
                $stmt = $conn->prepare("INSERT INTO payments(ef_id, amount, remarks) VALUES (?, ?, 'Completed!')");
                $stmt->bind_param("id", $student_id1, $amount);
				echo "<script>alert('Payment successful!')</script>";
                if ($stmt->execute()) {
                    $id = $stmt->insert_id;

                    // Update the amount column in the transactions table using prepared statement
                    $stmt = $conn->prepare("UPDATE transactions SET amount = amount - ? WHERE student_id = ?");
                    $stmt->bind_param("di", $amount, $student_id1);

                    if ($stmt->execute()) {
                        // Payment successful
                        echo "<script>alert('Payment successful!')</script>";
                    } else {
                        // Handle update failure
                        echo "<script>alert('Error updating transactions')</script>";
                    }
                } else {
                    // Handle insert failure
                    echo "<script>alert('Error in processing payment')</script>";
                }
            } else {
                // Handle incorrect amount case
                echo "<script>alert('Incorrect amount. Please fill the Amount exactly as the Total Payable Fees.')</script>";
            }
        } else {
            // Handle invalid balance case
            echo "<script>alert('Invalid balance')</script>";
        }
    } else {
        // Payment already processed for this amount
        echo "<script>alert('Payment already saved')</script>";
    }
}
?>


<script>
	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#ef_id').change(function(){
		var amount= $('#ef_id option[value="'+$(this).val()+'"]').attr('data-balance')
		$('#balance').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	})
	$('#manage-payment').submit1(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_payment',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				resp = JSON.parse(resp)
				if(resp.status == 1){
					alert_toast("Data successfully saved.",'success')
						// setTimeout(function(){
						// 	var nw = window.open('receipt_forstd.php?ef_id='+resp.ef_id+'&pid='+resp.pid,"_blank","width=900,height=600")
						// 	setTimeout(function(){
						// 		nw.print()
						// 		setTimeout(function(){
						// 			nw.close()
						// 			location.reload()
						// 		},500)
						// 	},500)
						// },500)
				}
			}
		})
	})
</script>