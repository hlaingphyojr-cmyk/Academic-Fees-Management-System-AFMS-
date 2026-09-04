<?php
// session_start();
include 'db_connect.php';


//for class name
$id = $_SESSION['login_username'];
$stmt = $conn->prepare("SELECT course FROM  courses c
JOIN student_ef_list ef ON ef.ef_no =?
WHERE c.id=ef.course_id");

$stmt->bind_param("s",$id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_array();

//for class's amout
$stmt = $conn->prepare("SELECT total_amount FROM  courses c
JOIN student_ef_list ef ON ef.ef_no =?
WHERE c.id=ef.course_id");

$stmt->bind_param("s",$id);
$stmt->execute();
$result = $stmt->get_result();
$amout = $result->fetch_array();

// $id = $_SESSION['login_username'];
    // $stmt = $conn->prepare("SELECT id FROM student s WHERE s.id_no=?");
    // $stmt->bind_param("s",$id);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $idd = $result->fetch_array();

    // $stmt = $conn->prepare("SELECT amount FROM transactions t WHERE t.student_id=?");
    // $stmt->bind_param("s",$idd);
    // $stmt->execute();
    // $result = $stmt->get_result();
    // $iddd = $result->fetch_array();

    $stmt = $conn->prepare("SELECT amount FROM transactions tr 
    join student s on s.id_no=?
    WHERE tr.student_id=s.id");
    $stmt->bind_param("s",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $idd = $result->fetch_array();

    $stmt = $conn->prepare("SELECT ef_id FROM payments p 
    join student s on s.id_no=?
    WHERE p.ef_id=s.id");
    $stmt->bind_param("s",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $pay = $result->fetch_array();
?>
<style>
    #h3{
        text-align: left;
    }

    #cardfor{
        background-color: gainsboro;
        font-size: 13.9px;
    }
    .card-body{
        font-size: 16px;
    }
    

    
</style>
<div>
<div class="containe-fluid" id="save_payment" style="font-size: 13px;">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <!-- <?php echo "Welcome to Academic Fees Management System ". $_SESSION['login_username']."!"  ?> -->
                    <h5 id="h3">Dashboard Summary</h5>
                    <hr>
                    <div class="card-body">
                    
                        <p>"<b><?php 
                        

                        if(!isset($amout['total_amount']) || $amout['total_amount'] === null) {
                        
                            echo " ";
                        
                        } else {
                        
                            echo $amout['total_amount'];
                        
                        }
                        ?></b>Ks" 
                        is total amount for your enroll class "
                        <b><?php 
                        if(!isset($class['course']) || $class['course'] === null) {

                            echo " ";
                        
                        } else {
                        
                            echo $class['course'];
                        
                        }
                        ?></b>"</p>

                        <br>
                        <div class="card-body" style="font-size: 17px;">
                        <?php 
                        $message="Please pay amount for the your enroll class year fees.";
                        $message1="You have already pay.Please check your payment details.";

                            if(empty($pay['ef_id']))
                            {
                                echo '     <p style="color: red; font-size: 17px;">' . $message . '</p>';
                            
                            }
                            else
                            {
                                echo '     <p style="color: green; font-size: 17px;">' . $message1 . '</p>';
                            }

                        ?>
                        </div>
                    <div>
                        <a href="std_index.php?page=payments_forstd" class="card-body">View Payments Details</a>
                    </div>

                        
                    
            </div>      			
        </div>
    </div>
</div></div></div>
</div>
<script>
    $(document).ready(function () {
        // Assume you have a form with id="paymentForm"
        $("#paymentForm").submit(function (event) {
            event.preventDefault();

            // Get form data
            var formData = $(this).serialize();

            // AJAX call to save_pay function
            $.ajax({
                type: "POST",
                url: "std_ajax?action=save_pay", // Adjust the path accordingly
                data: formData,
                success: function (response) {
                    if (response == 1) {
                        alert("Payment saved successfully!");
                        // You can perform additional actions after successful save
                    } else if (response == 2) {
                        alert("Student not found!");

} else {
                        alert("Failed to save payment!");
                    }
                },
                error: function () {
                    alert("Error in AJAX request");
                }
            });
        });
    });
</script>