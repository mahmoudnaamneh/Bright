<?php
include("navbar.php");
// Database connection
$con = mysqli_connect("localhost", "root", "1234", "bright");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new password
    $username=$_SESSION['username'];
    $newpass=$_POST['new_password'];
    $new_Password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_Password = mysqli_real_escape_string($con, $_POST['confirm_password']);
    // Update the condition as per your database schema
    if(isset($new_Password)&& isset($confirm_Password))
    {
    if ($new_Password !== $confirm_Password) {
        // Passwords do not match
        $errorMessage = "Passwords do not match.";
    } elseif ($new_Password == $confirm_Password){
        $query = "UPDATE user SET password = '$new_Password' ,forget=0 WHERE username = '$username'";
        mysqli_query($con, $query);
        echo "test";
        header("Location: loginform.php");
    }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <h2 class="text-center mt-5">Reset Password</h2>
        <?php if (isset($errorMessage)): ?>
            <p class="text-danger"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (isset($successMessage)): ?>
            <p class="text-success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
        <form class="mt-4 col-4 mx-auto" method="post">
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-dark btn-block">Reset Password</button>
        </form>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include("footer.php");
?>
