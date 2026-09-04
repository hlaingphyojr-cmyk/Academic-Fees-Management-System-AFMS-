
<style>
	.collapse a{
	text-indent:10px;
	}
	nav#sidebar{
		/*background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important*/
	}
	.div
	{
		background-color: #034;
		background-image:url(pc.jpg);
		background-repeat:no-repeat;
		background-origin:content-box;
		background-position:top;
		padding:10px;
	}
	.topnav {
    background-color: #fff;
    position: relative;
    top: 10px;
    right: 100px;
	left: 0px;
    margin: 0%;
    padding: 0%;
  }
  
  /* Style the links inside the navigation bar */
  .topnav a {
    float: right;
    color: #030303;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 14px;
  }
  
  /* Change the color of links on hover */
  .topnav a:hover {
    background-color: #ddd;
    color: black;
  }
  
  /* Add a color to the active/current link */
  .topnav a.active {
    background-color: #babcb5;
    color: rgb(47, 44, 44);
  }

  .font1{
	font-size: 16px;
  }
</style>

<nav id="sidebar" class="div" >
	<!-- <div class="topnav"> -->
		<div class="sidebar-list">
			<div class="font1">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<div class="mx-2 text-white">Master List</div>
				<a href="index.php?page=students" class="nav-item nav-students"><span class='icon-field'><i class="fa fa-users "></i></span> Students</a>
				<a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-scroll "></i></span> Class_Years & Fees</a>
				
				<div class="mx-2 text-white">Transactions</div>
				<a href="index.php?page=fees" class="nav-item nav-fees"><span class='icon-field'><i class="fa fa-money-check "></i></span> Student Fees</a>
				<a href="index.php?page=payments" class="nav-item nav-payments"><span class='icon-field'><i class="fa fa-receipt "></i></span> Payments</a>
				
				<div class="mx-2 text-white">Report</div>
				<a href="index.php?page=payments_report" class="nav-item nav-payments_report"><span class='icon-field'><i class="fa fa-th-list"></i></span> Payments Report</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<div class="mx-2 text-white">System</div>
				
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users "></i></span> Users(Admin/Staff)</a>
				<!-- <a href="index.php?page=site_settings" class="nav-item nav-site_settings"><span class='icon-field'><i class="fa fa-cogs"></i></span> System Settings</a> -->
			</div>
			<?php endif; ?>
		</div>
	<!-- </div> -->
</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
