<style>
  .body{
    background-color: bisque;
    width: 100px;
    height: 20px;
  }
  .body1{
    background-color: #034;
    width: 100px;
    height: 20px;
  }

	.logo {
    margin: auto;
    font-size: 20px;
    background: #034;
    background-color: #034;
    padding: 7px 11px 20px;
    border-radius:  100% 100%;
    color: #002600;
}

  .title{
    color:azure;
    font-size: 14.5px;
    color: ghostwhite;
    /* color: darkslategrey ; */
  }

  nav{
    background-color: #034;
    font-size: 0px;
  }
</style>
<div class="body" >
<nav class="navbar navbar-light bg- fixed-top" style="padding: 0px;">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12" >
  		<div class="col-md-4 float-left text-dark">
          <div class="title">Academic Fees Management System</div>
  		</div>
      <!-- <div class="col-md-4 float-left text-dark">
        
        <p><i><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : 'Academic Fees Management System' ?></i></p>
        
      </div> -->
      <div class="title">
	  	<div class="float-right">
        <div class=" dropdown mr-4">
            <a href="#" class="text-white dropdown-toggle"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_username'] ?> </a>
              <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                <!-- <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account"><i class="fa fa-cog"></i> Manage Account</a> -->
                <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
              </div>
        </div>
      </div>
      </div>
  </div>
  
</nav>
</div>
<script>
  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
</script>