<!DOCTYPE html>
<html lang="en">
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
header("location:std_index.php?page=std_home");

?>
</head>
<style>
    body{ 
		background-color: #034;
		width:100%;
		height: calc(100%);
		display: flex;
	}

	.logo {
    display: block;
    margin:auto;
    max-width: 300%;
	width: 200px;
    height: 130px;
    object-position:top;
}

.wrapper {
    width: 400px;
    height: 520px;
    margin: 80px auto;
    padding: 20px 30px 30px 30px;
    background-color: #fff;
    border-radius: 15px;
    
}
    </style>
<body>
<div class="wrapper">
	<div class="col-md-14">
	<img src="logo.png" class="logo" title="Computer" >
  				<div class="card-body">
  					<form id="login-form" method="post">
						<hr>
						<div class="p">Hello! Let's get Started <br>Login and Continue!</div><br>
  						<div class="form-group">
  							<label for="username" class="sr-only"><b>Username</b></label>
  							<input type="text"  id="fixed-prefix" name="username" class="form-control"  oninput="handleInput()" placeholder="username">
  						</div>
  						<div class="form-group">
  							<label for="password" class="sr-only"><b>Password</b></label>
  							<input type="password" id="password" name="password" class="form-control" placeholder="password">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-13 btn-primary">Login</button></center><br>
						<center><button class="btn-sm btn-block btn-wave col-md-5 btn-primary bg-light"><a href="homepage.php">Back Home</a></button></center>
  					</form>
  				</div>
  	</div>

</div>
</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'std_ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='std_index.php?page=std_home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is wrong.Try again!</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})

	function handleInput() {
            // Get the input element
            var inputElement = document.getElementById('fixed-prefix');
            
            // Set the fixed prefix
            var fixedPrefix = 'mkpt-';
            
            // Check if the input starts with the fixed prefix
            if (!inputElement.value.startsWith(fixedPrefix)) {
                // If not, prepend the fixed prefix to the input
                inputElement.value = fixedPrefix + inputElement.value;
            }
        }
</script>
</html>