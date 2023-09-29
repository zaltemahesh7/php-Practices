<?php
// Initialize variables to store form data
$username = $email = $password = "";
$errors = array();
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform server-side validation (customize as needed)
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($username)) {
        $errors[] = "Username is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    if (count($errors) === 0) {
        // Include the database connection (update with your database credentials)
        $servername = "localhost";
        $usernamedb = "root";
        $db_password = "";
        $database = "test";

        $conn = new mysqli($servername, $usernamedb, $db_password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database (use prepared statements)
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            // Registration successful
            $successMessage = "Registration successful.";
        } else {
            // Registration failed
            $errors[] = "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php require 'components/_nav.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center">Registration Form</h2>
        <!-- Display Errors and Success Message -->
        <div id="error-messages"></div>
        <div id="success-message"></div>
        <form action="login.php" method="post" id="registration-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById("registration-form").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Get form values
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;

            // Validate form data with JavaScript
            var errorMessages = [];
            if (username.trim() === "") {
                errorMessages.push("Username is required.");
            }
            if (email.trim() === "" || !isValidEmail(email)) {
                errorMessages.push("Invalid email format.");
            }
            if (password.trim() === "" || password.length < 6) {
                errorMessages.push("Password must be at least 6 characters long.");
            }

            // Display error messages or submit the form
            var errorContainer = document.getElementById("error-messages");
            if (errorMessages.length > 0) {
                errorContainer.innerHTML = '<div class="alert alert-danger">' + errorMessages.join('<br>') + '</div>';
            } else {
                // Form is valid, you can submit it here
                errorContainer.innerHTML = '';
                // You can submit the form via AJAX or by setting the form's action attribute
                // Example: document.getElementById("registration-form").action = "registration_process.php";
                // Then, submit the form: document.getElementById("registration-form").submit();
                // For now, just show a success message:
                var successContainer = document.getElementById("success-message");
                successContainer.innerHTML = '<div class="alert alert-success">Registration successful.</div>';
            }
        });

        function isValidEmail(email) {
            // A simple email validation regex, you can use a more robust one if needed
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
            return emailRegex.test(email);
        }
    </script>
</body>

</html>