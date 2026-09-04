<?php
include 'db_connect.php';
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM student where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
    $$k=$val;
}
}
?>
<div class="container-fluid" style="font-size: 13px;">
    <form id="manage-student" method="post">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div id="msg" class="form-group"></div>
        <div class="form-group">
            <label for="" class="control-label">MKPT No.</label>
            <input type="text" class="form-control" name="id_no" id="mkpt" title="mkpt-****" pattern="mkpt-\d{4}" value="<?php echo isset($id_no) ? $id_no :'' ?>" required>
            <span class="error" id="mkptError"></span>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" minlength="3" maxlength="20" title="Only lower cases, upper cases and spaces are allowed!" pattern="^[A-Za-z\s]+$" value="<?php echo isset($name) ? $name :'' ?>" required>
            <span class="error" id="nameError"></span>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" title="+959*********" pattern="\+959\d{9}" value="<?php echo isset($contact) ? $contact :'' ?>" required>
            <span class="error" id="contactError"></span>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Edu_mail</label>
            <input type="email" class="form-control" id="email" name="email" title="****@ucsm.edu.mm" pattern="[a-z]+\@ucsm\.edu\.mm$" value="<?php echo isset($email) ? $email :'' ?>" required>
            <span class="error" id="emailError"></span>
        </div>
        <div class="form-group">
            <label for="" class="control-label">Address</label>
            <textarea name="address" id="" rows="2" cols="50" minlength="3" maxlength="50" class="form-control" required=""><?php echo isset($address) ? $address :'' ?></textarea>
        </div>
        <div style="text-align:center;font-size:large">Login details</div>
        <hr>
            <div style="top:20px"></div>
  			<div class="form-group">
                <label for="" class="control-label">Username</label>
  				<input type="text" id="username" id="mkpt" name="username" title="mkpt-****" pattern="mkpt-\d{4}" class="form-control"  value="<?php echo isset($username) ? $username :'' ?>" required readonly>
  			</div>
  			<div class="form-group">
                <label for="" class="control-label">Password</label>
  				<input type="text" id="password" name="password" class="form-control" title="at least 1 uppercase,1 digit,lowercase are more than 8 characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" value="<?php echo isset($password) ? $password :'' ?>" required>
          <span class="error" id="passwordError"></span>
  			</div>
            <br>
            <!-- <div>
              <button type="submit" class="btn btn-primary">Save</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div> -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
    </form>
</div>
<script>
        const loginForm = document.getElementById('manage-student');
        const mkptError = document.getElementById('mkptError');
        const nameError = document.getElementById('nameError');
        const contactError = document.getElementById('contactError');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        loginForm.addEventListener('submit', (event) => {
            // $('#manage-student').addEventListener('submit', (event) => {
                // $('submit').click(function(){
            e.preventDefault();
            let valid = true;

            const mkpt = document.getElementById('mkpt').value;
            const name = document.getElementById('name').value;
            const contact = document.getElementById('contact').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const mkptPattern = /^mkpt-\d{4}$/;
            const namePattern = /^[A-Za-z\s]+$/;
            const contactPattern = /^\+959\d{9}$/;
            const emailPattern = /[a-z]+\@ucsm\.edu\.mm$/;
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

            if (!mkptPattern.test(mkpt)) {
                mkptError.textContent = 'Invalid MKPT';
                valid = false;
            } else {
                mkptError.textContent = '';
            }

            if (!namePattern.test(name)) {
                nameError.textContent = 'Invalid name';
                valid = false;
            } else {
                nameError.textContent = '';
            }

            if (!contactPattern.test(contact)) {
                contactError.textContent = 'Invalid contact number';
                valid = false;
            } else {
                contactError.textContent = '';
            }

            if (!emailPattern.test(email)) {
                email.textContent = 'Invalid email format';
                valid = false;
            } else {
                nameError.textContent = '';
            }

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

        $(document).ready(function() {
    $("#mkpt").on("input", function() {
        var mkpt = $(this).val();
        let valid = true;

        // Auto-populate Username field with MKPT No. value
        $("#username").val(mkpt);

        if (mkpt == "") {
            $("#mkptError").text("MKPT No. cannot be empty");
            valid = false;
        } else {
            $("#mkptError").text("");
        }

        // You can add additional validation if needed

        // Reset Username error when MKPT value changes
        $("#usernameError").text("");
    });

    $("#username").on("input", function() {
        var mkpt = $("#mkpt").val();
        var username = $(this).val();
        let valid = true;

        if (mkpt == username) {
            $("#mkptError").text("");
            $("#usernameError").text("");
        } else {
            $("#mkptError").text("MKPT no and Username don't match");
            $("#usernameError").text("MKPT no and Username don't match");
            valid = false;
        }
    });
});
 $('#manage-student').on('reset',function(){
        $('#msg').html('')
        $('input:hidden').val('')
    })
    $('#manage-student').submit(function(e){
        e.preventDefault()
        start_load()
        $('#msg').html('')
        $.ajax({
            url:'ajax.php?action=save_student',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    alert_toast("Data successfully saved.",'success')
                        setTimeout(function(){
                            location.reload()
                        },1000)
                }else if(resp == 2){
                $('#msg').html('<div class="alert alert-danger mx-2">ID # already exist.</div>')
                end_load()
                }
            }
        })
    })

    $('.select2').select2({
        placeholder:"Please Select here",
        width:'100%'
    })
</script>