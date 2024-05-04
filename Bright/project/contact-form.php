<?php
include("navbar.php");

// Define functions
function validateName($name) {
  if (strlen($name) < 5 || strlen($name) > 20) {
    return false;
  }
  return true;
}

function validateEmail($email) {
  $atCount = substr_count($email, "@");
  if ($atCount !== 1) {
    return false;
  }
  return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Variables
$errors = [];
$successMessage = "";
$submittedData = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get data from the form
  $firstName = trim($_POST["firstName"]);
  $lastName = trim($_POST["lastName"]);
  $email = trim($_POST["email"]);
  $phone = trim($_POST["phone"]);
  $message = trim($_POST["message"]);

  // Validate data
  if (empty($firstName)) {
    $errors[] = "שם פרטי הוא שדה חובה";
  } elseif (!validateName($firstName)) {
    $errors[] = "שם פרטי חייב להכיל בין 5 ל-20 תווים";
  }

  if (empty($lastName)) {
    $errors[] = "שם משפחה הוא שדה חובה";
  } elseif (!validateName($lastName)) {
    $errors[] = "שם משפחה חייב להכיל בין 5 ל-20 תווים";
  }

  if (empty($email)) {
    $errors[] = "כתובת מייל היא שדה חובה";
  } elseif (!validateEmail($email)) {
    $errors[] = "כתובת מייל לא תקינה";
  }

  if (empty($phone)) {
    $errors[] = "טלפון הוא שדה חובה";
  }

  if (empty($message)) {
    $errors[] = "תוכן ההודעה הוא שדה חובה";
  }

  // If there are no errors
  if (empty($errors)) {
    // Set session variables with submitted data
    $_SESSION["firstName"] = $firstName;
    $_SESSION["lastName"] = $lastName;
    $_SESSION["email"] = $email;
    $_SESSION["phone"] = $phone;
    $_SESSION["message"] = $message;

    // Display success message
    $successMessage = "הטופס נשלח בהצלחה!";

    // Redirect to the page showing form details
    header("Location: show_details.php");
    exit();
  }
}

?>

<!DOCTYPE html>
<html lang="he">
<head>
  <meta charset="UTF-8">
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
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
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
</style>
</head>
<body>
  <h1>CONTACT-US</h1>

  <?php
  // Display errors as JavaScript alert
  if (!empty($errors)) {
    echo "<script>alert('";
    echo implode("', '", $errors);
    echo "')</script>";
  }

  // Display success message
  if (!empty($successMessage)) {
    echo "<p>$successMessage</p>";
  }
  ?>
  <form method="post">
    <label for="firstName">שם פרטי:</label>
    <input type="text" name="firstName" id="firstName" required>
    <br>
    <label for="lastName">שם משפחה:</label>
    <input type="text" name="lastName" id="lastName" required>
    <br>
    <label for="email">מייל:</label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="phone">טלפון:</label>
    <input type="tel" name="phone" id="phone" required>
    <br>
    <label for="message">תוכן:</label>
    <br><textarea name="message" rows="5" cols="30" required></textarea>
    <br><br>
    <button type="submit">שלח</button>
  </form>
</body>
</html>
 <?php
  include("footer.php");
  ?>