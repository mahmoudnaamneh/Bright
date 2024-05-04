<!DOCTYPE html>
<html lang="he">
<head>
  <meta charset="UTF-8">
  <title>Contact-US</title>
  <style>
    body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  width: 80%;
  margin: 20px auto;
  background-color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  color: #333;
}

p {
  margin: 10px 0;
}

label {
  font-weight: bold;
}

  </style>
</head>
<body>
<?php
session_start();

// Access expected session variables
$firstName = $_SESSION["firstName"] ?? "";
$lastName = $_SESSION["lastName"] ?? "";
$email = $_SESSION["email"] ?? "";
$phone = $_SESSION["phone"] ?? "";
$message = $_SESSION["message"] ?? "";

// Display data with fallback values
echo "<h1>the details have been sent successfully!!</h1>  ";
echo "<h2>Contact Details:</h2>  ";
echo "<p>שם פרטי: $firstName</p>  ";
echo "<p>שם משפחה: $lastName</p>  ";
echo "<p>מייל: $email</p></br>   ";
echo "<p>טלפון: $phone</p></br>   ";
echo "<p>תוכן: $message</p></br>  ";

?>
</body>
</html>
















































<?php

/*
$users = [
    [
        "id" => 322476813,
        "username" => "mahmoud",
        "email" => "mahmoud@gmail.com",
        "password" => "mahmoud123",
    ],
    [
        "id" => 212794531,
        "username" => "saed123",
        "email" => "saed@gmail.com",
        "password" => "saed288",
    ],
    [
        "id" => 333333333,
        "username" => "bshara",
        "email" => "bshara@example.com",
        "password" => "bshara015",
    ],
    [
        "id" => 789654211,
        "username" => "shady123",
        "email" => "shady@example.com",
        "password" => "shady2",
    ],
    [
        "id" => 955522562,
        "username" => "nasem123",
        "email" => "nasem@example.com",
        "password" => "nasem455",
    ],
    [
        "id" => 254255524,
        "username" => "basel123",
        "email" => "basel@example.com",
        "password" => "basel644",
    ],
    [
        "id" => 232323232,
        "username" => "hana",
        "email" => "hana@example.com",
        "password" => "hana62551",
    ],
    [
        "id" => 525525222,
        "username" => "ahmed",
        "email" => "ahmed@example.com",
        "password" => "ahmed57877",
    ],
    [
        "id" => 121331225,
        "username" => "yasen",
        "email" => "yasen@example.com",
        "password" => "yasen8629",
    ],
    [
        "id" => 882822834,
        "username" => "omar",
        "email" => "omar@example.com",
        "password" => "omar58911",
    ],
    ];
    */
    ?>