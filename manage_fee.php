<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM student_ef_list where id = {$_GET['id']} ");
	foreach($qry->fetch_array() as $k => $v){
		$$k = $v;
	}
}
?>
<!-- <?php
if (isset($_POST['submit'])) {
    $ef_no = $_POST['ef_no'];
    $student_id = $_POST['student_id'];

    $student = $conn->query("SELECT id_no FROM student WHERE id = '$student_id'");
    if ($student->num_rows > 0) {
        $row = $student->fetch_assoc();
        if ($row['id_no'] != $ef_no) {
            echo "Invalid mkpt no.";
        }
    } else {
        echo "";
    }
}
?> -->
<div class="container-fluid" style="font-size: 13px;">
	<form id="manage-fees" method="post">
		<div id="msg"></div>
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="" class="control-label">Student</label>
			<select name="student_id" id="student_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT * FROM student order by name asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($student_id) && $student_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name'])?></option>
				<?php endwhile; ?>
			</select>
			<!-- .' | '. $row['id_no']  -->
		</div>
		 <div class="form-group">
            <label for="" class="control-label">MKPT No.</label>
            <input type="text" class="form-control" name="ef_no" id="ef_no" value="<?php echo isset($ef_no) ? $ef_no :'' ?>" required readonly>
			
        </div>
		<div class="form-group">
			<label for="" class="control-label">Class Year</label>
			<select name="course_id" id="course_id" class="custom-select input-sm select2">
				<option value=""></option>
				<?php
					$student = $conn->query("SELECT *,concat(course) as class FROM courses order by course asc ");
					while($row= $student->fetch_assoc()):
				?>
				<option value="<?php echo $row['id'] ?>" data-amount = "<?php echo $row['total_amount'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo $row['class'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		 <div class="form-group">
            <label for="" class="control-label">Fee</label>
            <input type="text" class="form-control text-right" name="total_fee"  value="<?php echo isset($total_fee) ? number_format($total_fee) :'' ?>" required readonly>
        </div>
		<div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
	</form>
</div>
<script>
	
	// $(document).ready(function(){
    //     // Triggered when the value of the student dropdown changes
    //     $("#student_id").change(function(){
    //         // Get the selected student's ID
    //         var selectedStudentId = $(this).val();

    //         // If a student is selected, update the MKPT No. field
    //         if(selectedStudentId !== ''){
    //             // Set the MKPT No. input field value
    //             $("#ef_no").val('mkpt-' + selectedStudentId);
    //         } else {
    //             // If no student is selected, reset the MKPT No. field
    //             $("#ef_no").val('');
    //         }
    //     });
    // });

	$(document).ready(function(){
    // Triggered when the value of the student dropdown changes
    $("#student_id").change(function(){
        // Get the selected student's ID
        var selectedStudentId = $(this).val();

        // If a student is selected, fetch the id_no from the student table
        if(selectedStudentId !== ''){
            $.ajax({
                url: 'std_fees.php', // Replace with your PHP file that handles the query
                type: 'POST',
                data: {student_id: selectedStudentId},
                success: function(response){
                    // Set the MKPT No. input field value
                    $("#ef_no").val(response);
                },
                error: function(error){
                    console.log('Error:', error);
                }
            });
        } else {
            // If no student is selected, reset the MKPT No. field
            $("#ef_no").val('');
        }
    });
});


	$('.select2').select2({
		placeholder:'Please select here',
		width:'100%'
	})
	$('#course_id').change(function(){
		var amount= $('#course_id option[value="'+$(this).val()+'"]').attr('data-amount')
		$('[name="total_fee"]').val(parseFloat(amount).toLocaleString('en-US',{style:'decimal',maximumFractionDigits:2,minimumFractionDigits:2}))
	})
	$('#manage-fees').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_fees',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
					alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
				}else if(resp == 2){
					$('#msg').html('<div class="alert alert-danger">ID Number already exist.</div>')
					end_load()
				}
			}
		})
	})
</script>
