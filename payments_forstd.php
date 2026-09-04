<?php include 'db_connect.php'; ?>
<div class="container-fluid" style="font-size: 13px;">
	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>List of Payments </b>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="">Date</th>
									<th class="">MKPT No.</th>
									<th class="">Name</th>
									<th class="">Paid Amount</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$id = $_SESSION['login_username'];
							$stmt = $conn->prepare("SELECT p.*, s.name as sname, ef.ef_no, s.id_no 
                            FROM payments p 
                            JOIN student_ef_list ef ON p.ef_id = ef.id
                            JOIN student s ON ef.student_id = s.id
                            WHERE s.id_no = ? AND ef.ef_no = ?");
							$ef_no = $_SESSION['login_username'];
							$stmt->bind_param("is", $id, $ef_no);
							$stmt->execute();

							$payments = $stmt->get_result();

							if($payments->num_rows > 0):
							    $i = 1;
   							 while($row=$payments->fetch_assoc()):
    					    $paid = $conn->query("SELECT sum(amount) as paid FROM payments where ef_id=".$row['id']);
	  					    $paid = $paid->num_rows > 0 ? $paid->fetch_array()['paid']:'';
							?>
							<tr>
						    <td>
    						    <p> <b><?php echo date("M d,Y H:i A",strtotime($row['date_created'])) ?></b></p>
						    </td>
						    <td>
						        <p> <b><?php echo $row['id_no'] ?></b></p>
						    </td>
						    <td>
 						       <p> <b><?php echo ucwords($row['sname']) ?></b></p>
						    </td>
						    <td class="text-right">
						        <p> <b><?php echo number_format($row['amount'],2) ?></b></p>
						    </td>
						    <td class="text-center">
						        <button class="btn btn-sm btn-outline-primary viewonly_payment" type="button" data-id="<?php echo $row['id'] ?>" data-ef_id="<?php echo $row['ef_id'] ?>">View</button>
						    </td>
							</tr>
							<?php 
							    endwhile; else:
							?>
							<tr>
							    <th class="text-center" colspan="7">No data.</th>
							</tr>
							<?php
							    endif;
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	$('.viewonly_payment').click(function(){
		uni_modal("Payment Details","viewonly_payment.php?ef_id="+$(this).attr('data-ef_id')+"&pid="+$(this).attr('data-id'),"mid-large")
		
	})
</script>