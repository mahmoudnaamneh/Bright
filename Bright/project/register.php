<?php
include("navbar.php");

$con = mysqli_connect("localhost", "root", "1234", "bright");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

function validateName($name) {
    if (strlen($name) < 5 || strlen($name) > 20) {
        return false;
    }
    return true;
}

function validatepass($confirm_password, $password) {
    if ($password !== $confirm_password) {
        return false;
    }
    return true;
}

function validateEmail($email) {
    if (strpos($email, '@') === false) {
        return false;
    }
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateID($id) {
    if (!is_numeric($id) || strlen($id) > 11) {
        return false;
    }
    if ($id < 0 || $id > 99999999999) {
        return false;
    }
    return true;
}

$errors = [];
$successMessage = "";
$submittedData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $birthdate = $_POST["birthdate"];
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $phone = $_POST["phone"];

    if (empty($id)) {
        $errors[] = "ID is required";
    } elseif (!validateID($id)) {
        $errors[] = "Invalid ID format or out of range";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!validateEmail($email)) {
        $errors[] = "Invalid email format";
    }

    if (empty($username)) {
        $errors[] = "Username is required";
    }

    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (!empty($password)) {
        if (empty($confirm_password)) {
            $errors[] = "Confirm Password is required";
        } elseif (!validatepass($confirm_password, $password)) {
            $errors[] = "Passwords do not match";
        }
    }

    if (empty($birthdate)) {
        $errors[] = "Date of Birth is required";
    }

    if (empty($fname)) {
        $errors[] = "First Name is required";
    }

    if (empty($lname)) {
        $errors[] = "Last Name is required";
    }

    if (empty($phone)) {
        $errors[] = "Number Phone is required";
    }

    if (empty($errors)) {
        $query = "INSERT INTO user (id,email, username, password, birthdate, fname, lname, phone) VALUES ('$id','$email', '$username', '$password', '$birthdate', '$fname', '$lname', '$phone')";
        if (mysqli_query($con, $query)) {
            echo "Registration successful. You can now <a href='loginform.php'>login here</a>.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
        mysqli_close($con);
    } else {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
                body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
 <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-container">
                    <h2 class="text-center">Registration to bright</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="form-group">
                            <label for="id">ID:</label>
                            <input type="text" class="form-control" id="id" name="id" required>
                            <span class="error"><?php echo isset($errors) && in_array("ID is required", $errors) ? "ID is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <span class="error"><?php echo isset($errors) && in_array("Invalid email format", $errors) ? "Invalid email format" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <span class="error"><?php echo isset($errors) && in_array("Username is required", $errors) ? "Username is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <span class="error"><?php echo isset($errors) && in_array("Password is required", $errors) ? "Password is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" <?php if (!empty($password) && $password !== $confirm_password) echo 'required'; ?>>
                            <span class="error"><?php echo isset($errors) && in_array("Passwords do not match", $errors) ? "Passwords do not match" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Date of Birth:</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            <span class="error"><?php echo isset($errors) && in_array("Date of Birth is required", $errors) ? "Date of Birth is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="fname">First Name:</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                            <span class="error"><?php echo isset($errors) && in_array("First Name is required", $errors) ? "First Name is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name:</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                            <span class="error"><?php echo isset($errors) && in_array("Last Name is required", $errors) ? "Last Name is required" : "";?></span>
                        </div>
                        <div class="form-group">
                            <label for="phone">Number Phone:</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                            <span class="error"><?php echo isset($errors) && in_array("Number Phone is required", $errors) ? "Number Phone is required" : "";?></span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="loginform.php">Login here</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for Bootstrap features like dropdowns, modals, etc.) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include("footer.php");
?>