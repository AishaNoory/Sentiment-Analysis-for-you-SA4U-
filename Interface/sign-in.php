<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Sentiment Analysis for Product Reviews</title>
    <link rel="stylesheet" href="Userin.css">
    <link rel="stylesheet" href="navbar.css">
    <style>
        .input-container {
            position: relative;
            margin-bottom: 15px;
        }
        .input-container .radio-buttons input[type="radio"],
        .input-container .radio-buttons label {
            display: inline-block;
            vertical-align: middle;
            margin-right: 10px;
        }
        .form input[type="password"] {
            padding-right: 30px; 
        }
        .modal {
            display: none;
            position: fixed; 
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            color: black;
            margin: 5% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .terms-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        .terms-container label {
            margin-left: 10px;
            font-size: 20px; 
        }
        .form h1 {
            color: black; 
        }
        .form label {
            font-size: 18px; 
            display: block;
            margin-bottom: 5px;
        }
        .form input[type="text"],
        .form input[type="email"],
        .form input[type="password"],
        .form select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a class="HOME" href="Homepage.html">Home</a>
            <a href="submit_review_main.php">Submit Review</a>
            <a href="viewpage.php">View Reviews</a>
            <a href="UserProfile.php">User Profile</a>
            <a href="sign-in.php">Register</a>
            <a href="login.html">Log In</a>
            <a href="adminui.php">Admin</a>
        </div>
        <div>
            <h1>SA4U</h1>
            <p style="font-size: 20px; margin-top: -10px;"><b>Sentiment Analysis for You</b></p>
        </div>
    </header>
    <div class="form" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
        <h1>Sign Up</h1>
        <?php if (!empty($error_message)): ?>
            <div style="color: red; text-align: center;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <form id="signUpForm" action="sign_in.php" method="post" onsubmit="return validateForm()" style="width: 100%; max-width: 500px; display: flex; flex-direction: column; align-items: center;">
            <div class="input-container">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Username" pattern="[A-Za-z]+" title="Only alphabets are allowed" required>
            </div>
            <div class="input-container">
                <label>Gender:</label>
                <div class="radio-buttons">
                    <input type="radio" id="male" name="gender" value="male" required>
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female" required>
                    <label for="female">Female</label>
                    <input type="radio" id="prefer_not_to_say" name="gender" value="prefer_not_to_say" required>
                    <label for="prefer_not_to_say">Prefer not to say</label>
                </div>
            </div>
            <div class="input-container">
                <label for="telephone">Telephone:</label>
                <input type="tel" name="telephone" id="telephone" placeholder="Telephone" pattern="[0-9]{10}" title="Please enter 10-digit phone number" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div class="input-container">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Password" required>
            </div>
            <p id="password-strength"></p>
            <div class="terms-container">
                <input type="checkbox" id="termsCheckbox" onclick="toggleTermsModal()" required>
                <label for="termsCheckbox">I agree to the <a href="#">Terms and Conditions</a></label>
            </div>
            <button type="submit">Sign Up</button>
        </form>
        <p>Already have an account? Log in <a href="Login.html">here</a>.</p>
    </div>

    <!-- Modal for Terms and Conditions -->
    <div id="termsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Terms and Conditions</h2>
            <p>
                Here are the Terms and Conditions for using our Sentiment Analysis for Product Reviews System. Please read these carefully before registering:

                1. Use of our service is for personal, non-commercial purposes only.<br>
                2. You agree not to misuse the service or help anyone else to do so.<br>
                3. You are responsible for the accuracy of the data you submit.<br>
                4. We do not guarantee that the service will be uninterrupted or error-free.<br>
                5. By using our service, you agree to our privacy policy.<br>
                6. We reserve the right to modify these terms at any time.<br>
                
                Please review these terms carefully and indicate your agreement to proceed with the registration.<br>
            </p>
            <button onclick="closeModal()">Agree</button>
            <!-- <button onclick="closeModal()">Disagree</button> -->
        </div>
    </div>

    <script>
        function validateForm() {
            // Validate username
            var username = document.getElementById("username").value;
            if (!/^[a-zA-Z]*$/g.test(username)) {
                alert("Username can only contain letters.");
                return false;
            }

            // Validate telephone
            var telephone = document.getElementById("telephone").value;
            if (!/^\d{10}$/.test(telephone)) {
                alert("Telephone must be a 10-digit number.");
                return false;
            }

            return true;
        }

        function checkPasswordStrength() {
            var password = document.getElementById("password").value;
            var strengthIndicator = document.getElementById("password-strength");
            var strength = 0;
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]+/)) strength += 1;
            if (password.match(/[A-Z]+/)) strength += 1;
            if (password.match(/[0-9]+/)) strength += 1;
            if (password.match(/[\W]+/)) strength += 1;

            switch (strength) {
                case 0:
                case 1:
                    strengthIndicator.innerHTML = "Weak";
                    strengthIndicator.style.color = "red";
                    break;
                case 2:
                case 3:
                    strengthIndicator.innerHTML = "Moderate";
                    strengthIndicator.style.color = "orange";
                    break;
                case 4:
                case 5:
                    strengthIndicator.innerHTML = "Strong";
                    strengthIndicator.style.color = "green";
                    break;
            }
        }

        document.getElementById("password").onkeyup = checkPasswordStrength;

        function toggleTermsModal() {
            var checkbox = document.getElementById("termsCheckbox");
            var modal = document.getElementById("termsModal");

            if (checkbox.checked) {
                modal.style.display = "block";
            } else {
                modal.style.display = "none";
            }
        }

        function closeModal() {
            document.getElementById("termsModal").style.display = "none";
        }
    </script>
</body>
</html>
