<?php
session_start();
include 'db_connect.php';
$ef_id = $_GET['ef_id'];
$pay_id=$_GET['pid'];
$fees = $conn->query("SELECT ef.*, s.name as sname, s.id_no, concat(c.course) as `class` 
FROM student_ef_list ef 
inner join student s on s.id = ef.student_id 
inner join courses c on c.id = ef.course_id 
where ef.id = $ef_id");

$fee = $fees->fetch_array();

$id = $_SESSION['login_username'];

$stmt = $conn->prepare("SELECT * FROM payments p 
JOIN student_ef_list ef ON p.ef_id = ef.id 
JOIN student s ON ef.student_id = s.id 
WHERE s.id_no = ? AND ef.ef_no = ?");

$stmt->bind_param("is", $id, $fee['ef_no']);
$stmt->execute();
$payments = $stmt->get_result();
$pay_arr = array();

while($row=$payments->fetch_array()){
    $pay_arr[$row['id']] = $row;
}

//for std name
$stmt = $conn->prepare("SELECT name FROM student WHERE username = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$sname = $result->fetch_array();

//for class name
$stmt = $conn->prepare("SELECT course FROM  courses c
JOIN student_ef_list ef ON ef.ef_no =?
WHERE c.id=ef.course_id");

$stmt->bind_param("s",$fee['ef_no']);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_array();

//for class year id
$stmt = $conn->prepare("SELECT c.id FROM  courses c
JOIN student_ef_list ef ON ef.ef_no =?
WHERE c.id=ef.course_id");

$stmt->bind_param("s",$fee['ef_no']);
$stmt->execute();
$result = $stmt->get_result();
$course_id = $result->fetch_array();

// //for payment id in receipt
// $stmt = $conn->prepare("SELECT p.id FROM  payments p
// WHERE p.ef_id=$ef_id");

// $stmt->execute();
// $result = $stmt->get_result();
// $p_id = $result->fetch_array();

//for payment id in receipt

$stmt = $conn->prepare("SELECT p.id, p.date_created, p.amount, p.remarks FROM  payments p

WHERE p.ef_id=? AND p.id=?");

$stmt->bind_param("ii", $ef_id,$pay_id);

$stmt->execute();

$result = $stmt->get_result();

$pay_arr = $result->fetch_all(MYSQLI_ASSOC);

?>

<style>
	.flex{
		display: inline-flex;
		width: 100%;
	}
	.w-50{
		width: 50%;
	}
	.text-center{
		text-align:center;
		font-size: 17px;
	}
	.text-right{
		text-align:right;
	}
	table.wborder{
		width: 100%;
		border-collapse: collapse;
	}
	table.wborder>tbody>tr, table.wborder>tbody>tr>td{
		border:1px solid;
	}
	p{
		margin:unset;
	}
	.table {
    border-collapse: separate;
    border-spacing: 6px; /* Adjust the spacing as needed */
}
.caption1{
	text-align: center;
	font-size: 10px;
	font-weight: bold;
}

</style>
<div class="container-fluid">
<p class="text-center"><b><?php echo empty($pay_arr) ? "Payments" : 'Payment Receipt' ?></b></p>
	<hr>
	<div class="flex">
		<div class="w-50">
			<p>MKPT No: <b><?php echo $id ?></b></p>
			<p>Student: <b><?php echo $sname['name']; ?></b></p>
			<p>Class Year: <b><?php echo $class['course'] ?></b></p>
		</div>
		<?php if(!empty($pay_arr)): ?>
		<?php foreach($pay_arr as $payment): ?>
		<div class="w-50">
			<p>Payment Date: <b><?php echo date("M d,Y",strtotime($payment['date_created'])); ?></b></p>
			<p>Paid Amount: <b><?php echo number_format($payment['amount'],2); ?></b></p>
			<p>Remarks: <b><?php echo $payment['remarks']; ?></b></p>
		</div>
		<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<hr>
	<p><b>Payment Summary</b></p>
	<table class="wborder">
		<tr>
			<td width="50%">
				<p><b>Fee Details</b></p>
				<hr>
				<table width="100%">
					<tr>
						<td width="50%">Fee Type</td>
						<td width="50%" class='text-right'>Amount</td>
					</tr>
					<?php 
				$cfees = $conn->query("SELECT * FROM fees where course_id = {$course_id['id']}");
				$ftotal = 0;
				while ($row = $cfees->fetch_assoc()) {
					$ftotal += $row['amount'];
				?>
				<tr>
					<td><b><?php echo $row['description'] ?></b></td>
					<td class='text-right'><b><?php echo number_format($row['amount']) ?></b></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<th>Total</th>
					<th class='text-right'><b><?php echo number_format($ftotal) ?></b></th>
				</tr>
				</table>
			</td>			
			<td width="50%">
			<p><b>Payment Details</b></p>
				<table width="100%" class="wborder">
					<tr>
						<td width="50%">Date</td>
						<td width="50%" class='text-right'>Amount</td>
					</tr>
					<?php 
						$ptotal = 0;
						foreach ($pay_arr as $row) {
							if($row["id"] <= $_GET['pid'] || $_GET['pid'] == 0){
							$ptotal += $row['amount'];
					?>
					<tr>
						<td><b><?php echo date("Y-m-d",strtotime($row['date_created'])) ?></b></td>
						<td class='text-right'><b><?php echo number_format($row['amount']) ?></b></td>
					</tr>
					<?php
						}
						}
					?>
					<tr>
						<th>Total</th>
						<th class='text-right'><b><?php echo number_format($ptotal) ?></b></th>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td>Total Payable Fee</td>
						<td class='text-right'><b><?php echo number_format($ftotal) ?></b></td>
					</tr>
					<tr>
						<td>Total Paid</td>
						<td class='text-right'><b><?php echo number_format($ptotal) ?></b></td>
					</tr>
					<tr>
						<td>Balance</td>
						<td class='text-right'><b><?php echo number_format($ftotal-$ptotal) ?></b></td>
					</tr>
				</table>
			</td>			
		</tr>
	</table>
	<br>
</div>