<?php
include("navbar.php");
// Database connection
$con = mysqli_connect("localhost", "root", "1234", "bright");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate user input
    $email = mysqli_real_escape_string($con, $_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        $errorMessage = "Invalid email format";
    } else {
        // Check if email exists in the database
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) == 1) {
            // Generate a random token
            $token = bin2hex(random_bytes(8));

            // Store the token in the database
            $updateQuery = "UPDATE user SET password = '$token', forget = 1  WHERE email = '$email'";
            mysqli_query($con, $updateQuery);

            // Send the token to the user's email address
            $subject = "Password Reset";
            $message = "To reset your password, click the following link: http://localhost/labs/project-322476813-212794531/loginform.php , your random password is => $token";
            $headers = "From: saeedawad809@gmail.com";

            if (mail($email, $subject, $message, $headers)) {
                $successMessage = "Password reset instructions have been sent to your email address";
                $updateQuery = "UPDATE user SET locked = 0, login_attempts = 0 WHERE email = '$email'";
                mysqli_query($con, $updateQuery);
            } else {
                $errorMessage = "Failed to send password reset instructions";
            }
        } else {
            // Email not found in the database
            $errorMessage = "Email address not registered";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <h2 class="text-center mt-5">Forgot Password</h2>
        <?php if (isset($errorMessage)): ?>
            <p class="text-danger"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (isset($successMessage)): ?>
            <p class="text-success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <form class="mt-3 col-3 mx-auto" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Reset Password</button>
        </form>
        <p class="mt-3 text-center">Remember your password? <a href="loginform.php">Log in here</a></p>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include("footer.php");
?>
