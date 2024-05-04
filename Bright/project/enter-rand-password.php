<?php
// Database connection
$con = mysqli_connect("localhost", "root", "1234", "bright");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered random password and email
    $randomPassword = mysqli_real_escape_string($con, $_POST['random_password']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Retrieve the random password from the database for the provided email
    $query = "SELECT password FROM user WHERE email = '$email'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        // Compare the entered random password with the stored password
        if ($randomPassword === $storedPassword) {
            $stam = "SELECT email FROM user WHERE RPC = $randomPassword";
            $result2 = mysqli_query($con,$stam);
            $row2=mysqli_fetch_assoc($result2);
            $useremail=$row['email'];
            $_SESSION["Email"]=$useremail;
            // Random password matches, proceed to reset password page
            header("Location: reset-password.php?email=$email");
            exit;
        } else {
            // Random password does not match
            $errorMessage = "Invalid random password. Please try again.";
        }
    } else {
        // Email not found in the database
        $errorMessage = "Email address not registered.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <h2>Enter your random password</h2>
    <?php if (isset($errorMessage)): ?>
        <p style="color: red;"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <form method="post" action="reset-password.php">
        <label>Enter your random password:</label>
        <input type="password" name="random_password" required><br>
        <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
        <button type="submit">Go to Reset your Password</button>
    </form>
</body>
</html>
