<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form id="loginForm">
        <label for="mkpt">MKPT:</label>
        <input type="text" id="mkpt" name="mkpt" pattern="mkpt-\d{4}" required>
        <span class="error" id="mkptError"></span>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" pattern="\+959\d{9}" required>
        <span class="error" id="contactError"></span>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="address">Address:</label>
        <textarea id="address" name="address" required></textarea>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}" required>
        <span class="error" id="passwordError"></span>
        <br>
        <input type="submit" value="Login">
    </form>
    <script>
        const loginForm = document.getElementById('loginForm');
        const mkptError = document.getElementById('mkptError');
        const contactError = document.getElementById('contactError');
        const passwordError = document.getElementById('passwordError');

        loginForm.addEventListener('submit', (event) => {
            event.preventDefault();
            let valid = true;

            const mkpt = document.getElementById('mkpt').value;
            const contact = document.getElementById('contact').value;
            const password = document.getElementById('password').value;

            const mkptPattern = /^mkpt-\d{4}$/;
            const contactPattern = /^\+959\d{9}$/;
            const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/;

            if (!mkptPattern.test(mkpt)) {
                mkptError.textContent = 'Invalid MKPT';
                valid = false;
            } else {
                mkptError.textContent = '';
            }

            if (!contactPattern.test(contact)) {
                contactError.textContent = 'Invalid contact number';
                valid = false;
            } else {
                contactError.textContent = '';
            }

            if (!passwordPattern.test(password)) {
                passwordError.textContent = 'Invalid password';
                valid = false;
            } else {
                passwordError.textContent = '';
            }

            if (valid) {
                alert('Login successful');
            }
        });
    </script>
</body>
</html>