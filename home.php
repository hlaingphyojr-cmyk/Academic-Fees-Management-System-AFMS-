<?php include 'db_connect.php' ?>
<style>

   span.float-right.summary_icon {
    font-size: 3rem;
    position: absolute;
    right: 1rem;
    top: 0;
}
.imgs{
		margin: .5em;
		max-width: calc(100%);
		max-height: calc(100%);
	}
	.imgs img{
		max-width: calc(100%);
		max-height: calc(100%);
		cursor: pointer;
	}
	#imagesCarousel,#imagesCarousel .carousel-inner,#imagesCarousel .carousel-item{
		height: 60vh !important;background: black;
	}
	#imagesCarousel .carousel-item.active{
		display: flex !important;
	}
	#imagesCarousel .carousel-item-next{
		display: flex !important;
	}
	#imagesCarousel .carousel-item img{
		margin: auto;
	}
	#imagesCarousel img{
		width: auto!important;
		height: auto!important;
		max-height: calc(100%)!important;
		max-width: calc(100%)!important;
	}
    #h3{
        text-align: left;
    }

    #cardfor{
        background-color: gainsboro;
        font-size: 13.9px;
    }

    .right{
        padding:  15px 15px 15px 15px ;
        float: right;
    }

    .div1{
        float: left;
    }
    .div2{
        float: right;
        border-radius: 6px;
        border:3px solid black;
        width: 30%;
    }
    #main{
        font-size: 14px;
    }
</style>

<div>
<div class="containe-fluid">
	<div class="row mt-3 ml-3 mr-3">
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <!-- <?php echo "Welcome to Academic Fees Management System "//. $_SESSION['login_name']."!"  ?>-->
                    <h5 id="h3">Dashboard Summary</h5>
                    <hr>
                <div class="card" id="cardfor">
                    <div class="card-body">
                        <div class="div1">
                        <div>
                            <h3>Total Student</h3>
                        </div>

                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "sfps_db";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$conn) 
                        {
                          die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT COUNT(*) as total_rows FROM student ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) 
                            {
                             $row = $result->fetch_assoc();
                               echo $row["total_rows"];
                            } 
                        else 
                            {
                                echo "0";
                            }

                        // Close connection
                        $conn->close();

                        ?> 
                    <div>
                        <a href="index.php?page=students" class="card-link">View Students</a>
                    </div>
                        <!-- <div class="div2">
                            <i  class='fas fa-user-tie' style='font-size:60px;color:#067'></i>
                        </div> -->
                    </div>
                    </div>
                </div><br>
                <div class="card" id="cardfor">
                    <div class="card-body">
                        <div>
                            <h3>Enroll Class Years</h3>
                        </div>
                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "sfps_db";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$conn) {
                          die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT COUNT(*) as total_rows FROM courses ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                        // Fetch the result row
                        $row = $result->fetch_assoc();
                        // Output the total number of rows
                        echo $row["total_rows"];
                        }
                        else {
                           echo "0";
                        }

                        // Close connection
                        $conn->close();

                        ?> 
                        <div>
                            <a href="index.php?page=courses" class="card-link">View Years</a>
                        </div>
                    </div>
                </div>
                    <!-- <div class="card-body">
                        <div>
                            <h3>Users</h3>
                        </div>

                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "sfps_db";

                        // Create connection    
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        // Check connection
                        if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT COUNT(*) as total_rows FROM users ";
                        $result = $conn->query($sql);

                        if ($result->num_rows >0) {
                        // Fetch the result row
                        $row = $result->fetch_assoc();
                        // Output the total number of rows
                        echo $row["total_rows"];    
                        } else 
                        {
                            echo "0";
                        }

                        // Close connection
                        $conn->close();

                        ?> 
                        <div>
                            <a href="index.php?page=users" class="card-link">View Users</a>
                        </div>
                    </div> -->
                    <br>
                    <div class="card" id="cardfor">
                    <div class="card-body">
                        <div class="div1">
                        <div>
                            <h3>Total Payment</h3>
                        </div>

                        <?php
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "sfps_db";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$conn) 
                        {
                          die("Connection failed: " . mysqli_connect_error());
                        }

                        $sql = "SELECT COUNT(*) as total_rows FROM payments ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) 
                            {
                             $row = $result->fetch_assoc();
                               echo $row["total_rows"];
                            } 
                        else 
                            {
                                echo "0";
                            }

                        // Close connection
                        $conn->close();

                        ?> 
                    <div>
                        <a href="index.php?page=payments" class="card-link">View Payments</a>
                    </div>
                        <!-- <div class="div2">
                            <i  class='fas fa-user-tie' style='font-size:60px;color:#067'></i>
                        </div> -->
                    </div>
                    </div>
                </div><br>
                </div>
            </div>      			
        </div>
    </div>
</div>
</div>
<script>
	$('#manage-records').submit(function(e){
        e.preventDefault()
        start_load()
        $.ajax({
            url:'ajax.php?action=save_track',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                resp=JSON.parse(resp)
                if(resp.status==1){
                    alert_toast("Data successfully saved",'success')
                    setTimeout(function(){
                        location.reload()
                    },800)

                }
                
            }
        })
    })
    $('#tracking_id').on('keypress',function(e){
        if(e.which == 13){
            get_person()
        }
    })
    $('#check').on('click',function(e){
            get_person()
    })
    function get_person(){
            start_load()
        $.ajax({
                url:'ajax.php?action=get_pdetails',
                method:"POST",
                data:{tracking_id : $('#tracking_id').val()},
                success:function(resp){
                    if(resp){
                        resp = JSON.parse(resp)
                        if(resp.status == 1){
                            $('#name').html(resp.name)
                            $('#address').html(resp.address)
                            $('[name="person_id"]').val(resp.id)
                            $('#details').show()
                            end_load()

                        }else if(resp.status == 2){
                            alert_toast("Unknow tracking id.",'danger');
                            end_load();
                        }
                    }
                }
            })
    }
</script>