<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
// if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
// }
ob_end_flush();
?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Academic Fees Management System</title>
	<link rel="stylesheet" href="assets/font-awesome/css/all.min.css">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style3.css">
 	

<?php include('./header1.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    position: fixed;
	    top:0;
	    left: 0;
		background-color: #034;
	}
	.form{
		width: 80%;
		height: 50%;
		position: fixed;
		content: center;
		border-color: #067;

	}
	main#main{
		width:100%;
		height: calc(100%);
		display: flex;
		background-color: #034;
	}
	.div2
	{
		color:#000;
		text-align:center;
	}

	.hover-example {
      width: 77px;
      height: 37px;
      background-color: #289;
      color: black;
      text-align: center;
      line-height: 20px;
	  font-size: 15px;
      transition: background-color 0.1s ease;
	}
	.hover-example:hover {
      background-color: hsl(235, 87%, 57%);
    }

	.logo {
    display: block;
    margin:auto;
    max-width: 300%;
	width: 280px;
    height: 180px;
    object-position:top;
}

#login-container {
    width: 400px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.wrapper {
    width: 480px;
    height: 500px;
    margin: 80px auto;
    padding: 40px 30px 30px 30px;
    background-color: #fff;
    border-radius: 15px;
    
}

.active {
    background-color: white;
    color: rgb(47, 44, 44);
	margin-top: 15px;
	font-size: 15px;
  }

.font{
	font-size: 12px;
}

</style>
<body class="bg-dark">

  <main id="main" >
  	
  		<div class="align-self-center w-100">
		<div class="wrapper">
		<h3 class="div2" >
		<img src="logo.png" class="logo" title="Computer" >
		<b><?php $_SESSION['system']['image'] = 'logo.png';
		echo $_SESSION['system']['name']="";?></b></h3>
  		
		<div id="login-center" class="row justify-content-center">
			
  			<div class="col-md-11">
  				<div class="card-body">
  					<form id="login-form" method="post">
  						<div class="form-group">
  							<label for="username" class="sr-only"><b>Username</b></label>
  							<input type="text" id="username" name="username"  class="form-control"  placeholder="Username">
  						</div>
  						<div class="form-group">
  							<label for="password" class="sr-only"><b>Password</b></label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="Password">
  						</div>
  						<!-- <center><button class="hover-example">Login</button></center><br> -->
						  <center class="font"><button class="btn-sm btn-block btn-wave col-md-13 btn-primary">Login</button></center><br>
						<!-- <center><button class="active"><a href="homepage.php">Back Home</a></button></center> -->
						<center><button class="btn-sm btn-block btn-wave col-md-5 btn-primary bg-light"><a href="homepage.php">Back Home</a></button></center>
  					</form>
  				</div>
  			</div>
  		</div>
  		</div>
		</div>
		
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="submit"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
			},
			success:function(resp){
				if(resp == 1){
					window.location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is wrong.Try again!</div>')
					$('#login-form button[type="submit"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>