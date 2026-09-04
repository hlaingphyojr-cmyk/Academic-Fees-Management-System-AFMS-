<?php
// session_start();
$_SESSION['login_username'];
$conn = mysqli_connect("localhost", "root", "", "sfps_db") or die("Connection Error: " . mysqli_error($conn));

if (count($_POST) > 0) {
    $result = mysqli_query($conn, "SELECT password from student WHERE id_no='" . $_SESSION['login_username'] . "'");
    
    if ($result) {
        $row = mysqli_fetch_array($result);

        if(empty($_POST["newPassword"]) && empty($_POST["currentPassword"]))
        {
            $message = "Current Password and New Password fields are empty.";
        }

        else if(empty($_POST["newPassword"]))
            {
                $message = "New Password field is empty.Please fill this field can able to be changed your password.";
            }
        
        else if ($row && $_POST["currentPassword"] == $row["password"]) {
            mysqli_query($conn, "UPDATE student set password='" . $_POST["newPassword"] . "' WHERE id_no='" . $_SESSION['login_username'] . "'");
            $message = "Password Changed";
        } else {
            $message = "Current Password is not correct";
            //echo "Error on line 12: Current Password is wrong"; // Add this line
        }
    }
    }
?>


<html>
<head>
<center><H3>Change Password</H3></center>
<link rel="stylesheet" href="assets/css/style.css">
<script>
function validatePassword() {
var currentPassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

document.getElementById("currentPasswordError").innerHTML = "";
document.getElementById("newPasswordError").innerHTML = "";
document.getElementById("confirmPasswordError").innerHTML = "";

if(!currentPassword.value) {
	currentPassword.focus();
	document.getElementById("currentPassword").innerHTML = "required";
	output = false;
}
else if(!newPassword.value) {
	newPassword.focus();
	document.getElementById("newPassword").innerHTML = "required";
	output = false;
}
else if(!confirmPassword.value) {
	confirmPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "required";
	output = false;
}
if(newPassword.value != confirmPassword.value) {
	newPassword.value="";
	confirmPassword.value="";
	newPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "Passwords do not match";
	output = false;
} 	
return output;
}
</script>
</head>
<body>
    <!-- <form name="frmChange" method="post" action=""
        onSubmit="return validatePassword()">
        <div style="width: 500px;">
            <div class="message"><?php if(isset($message)) { echo $message; } ?></div>
            <table border="0" cellpadding="10" cellspacing="0"
                width="500" align="center" class="tblSaveForm">
                 <tr class="tableheader">
                    <td colspan="2">Change Password</td>
                </tr> 
                <tr>
                    <td width="40%"><label>Current Password</label></td>
                    <td width="60%"><input type="password"
                        name="currentPassword" class="txtField" /><span
                        id="currentPassword" class="required"></span></td>
                </tr>
                <tr>
                    <td><label>New Password</label></td>
                    <td><input type="password" name="newPassword"
                        class="txtField" /><span id="newPassword"
                        class="required"></span></td>
                </tr>
                <td><label>Confirm Password</label></td>
                <td><input type="password" name="confirmPassword"
                    class="txtField" /><span id="confirmPassword"
                    class="required"></span></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="submit"
                        value="Submit" class="btnSubmit"></td>
                </tr>
            </table>
        </div>
    </form> -->
    <br>
    <div class="container-fluid">
	<div class="row mt-0 ml-0 mr-0">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="login-form" method="post" action="" onSubmit="validatePassword()">

                    <?php
                            if(isset($message)) 
                            {
                                // Check if $message is "Incorrect"
                                if($message === "Password Changed") {
                                    echo '     <p style="color: green; font-size: 16px;">' . $message . '</p>';
                                }
                                else {
                                       // Assuming any other value is considered "Correct"
                                       echo '     <p style="color: red; font-size: 16px;">' . $message . '</p>';
                                    }
                            }
                    ?>
                    <br>
  						<div class="form-group">
  							<label for="username" class=""><p style="font-size:15px;">Current Password</p></label>
  							<input type="password" id="currentPassword" name="currentPassword"  class="form-control" /><span id="currentPassword" class="error"></span>
  						</div>
  						<div class="form-group">
  							<label for="password" class=""><p style="font-size:15px;">New Password</p></label>
  							<input type="password" id="newPassword" name="newPassword" class="form-control" title="at least 1 uppercase,1 digit,lowercase are more than 8 characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" /><span class="error" id="passwordError"></span>
  						
                        <!-- <?php
                          
                        ?> -->
                        </div>
                        <!-- <div class="form-group">
  							<label for="password" class=""><p style="font-size:15px;">Confirm Password</p></label>
  							<input type="password" name="confirmPassword" class="form-control" placeholder="" /><span id="confirmPassword" class="error"></span>
  						</div> -->
                        <br>
						  <p class="font"><button type="submit" style="font-size:15px;" class="btn btn-primary">Save Changes</button></p><br>
                          <!-- <p class="font" href="std_index.php?page=std_home"><button style="font-size:15px;" class="btn-sm btn-block btn-wave col-md-2 btn-lightgrey">Back</button></p><br> -->
                          <!-- <input type="submit" name="submit" value="Submit" class="btnSubmit"> -->
                        </form>
                      
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
</html>
<script>

        const loginForm = document.getElementById('login-Form');
        const passwordError = document.getElementById('passwordError');

        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();
            let valid = true;

            const password = document.getElementById('password').value;
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

            if (!passwordPattern.test(password)) {
                passwordError.textContent = 'Invalid password';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

            // if (valid) {
            //     alert('Login successful');
            // }
        });

</script>