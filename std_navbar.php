<style>
	.collapse a{
	text-indent:10px;
	}
	

	nav#sidebar {
    height: calc(100%);
    position: fixed;
    z-index: 99;
    left: 0;
    width: 200px;
    font-size: 12px;
    top: 2.5em;
}
a.nav-item {
    position: relative;
    display: block;
    padding: .75rem 1.25rem;
    margin-bottom: -1px;
    border: 1px solid rgba(0,0,0,.125);
    background-color: #ffffffc4;
    color: #484343;
    font-weight: 600;
}
a.nav-item:hover, .nav-item.active {
    background-color: #000000ad;
    color: #fffafa;
}

	.div
	{
		background-color: #034;
		padding:10px;
	}
	.div2{
		font-size: 16px;
	}
</style>
<body>
<nav id="sidebar" class="div" >
	<div class="div2">
		<div class="sidebar-list">
				<a href="std_index.php?page=std_home" class="nav-item nav-std_home"><span class='icon-field'><i class="fa fa-tachometer-alt "></i></span> Dashboard</a>
				<!-- <a href="index.php?page=fees" class="nav-item nav-fees"><span class='icon-field'><i class="fa fa-money-check "></i></span> Student Fees</a> -->

				<div class="mx-2 text-white">Master List</div>
				<a href="std_index.php?page=manage_payment" class="nav-item nav-manage_payment"><span class='icon-field'><i class="fa fa-receipt "></i></span> Payments</a>
                <a href="std_index.php?page=payments_forstd" class="nav-item nav-payments_forstd"><span class='icon-field'><i class="fa fa-money-check "></i></span> View Payment History</a>

				<!-- <a href="std_index.php?page=notice" class="nav-item nav-notice"><span class='icon-field'><i class="fa fa-receipt "></i></span> Notice</a> -->
				<div class="mx-2 text-white">Manage</div>
				<a href="std_index.php?page=manage_profile" class="nav-item nav-manage_profile"><span class='icon-field'><i class="fa fa-cog"></i></span> Change Password</a>
		</div>
	</div>
</nav>
</body>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>