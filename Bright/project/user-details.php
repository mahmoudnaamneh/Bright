<?php
include("navbar.php");
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: loginform.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "1234", "bright");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Retrieve user details from the database based on the user's ID
$user_id = $_SESSION['id'];
$query = "SELECT * FROM user WHERE id = $user_id";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed."); // Handle query error
}

$user_details = mysqli_fetch_assoc($result);

// Close database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add your CSS stylesheets here -->
</head>
<body>
    <!-- User Details Section -->
    <div class="container">
        <h2>User Details</h2>
        <table class="table">
            <tr>
                <td>ID:</td>
                <td><?php echo $user_details['id']; ?></td>
            </tr>
            <tr>
                <td>Username:</td>
                <td><?php echo $user_details['username']; ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $user_details['email']; ?></td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><?php echo $user_details['fname']; ?></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><?php echo $user_details['lname']; ?></td>
            </tr>
            <tr>
                <td>Number phone:</td>
                <td><?php echo $user_details['phone']; ?></td>
            </tr>
            <tr>
                <td>Role:</td>
                <td><?php echo $user_details['role']; ?></td>
            </tr>
            <!-- Add more details as needed -->
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add your HTML content here -->

</body>
</html>
<?php include("footer.php"); ?>
