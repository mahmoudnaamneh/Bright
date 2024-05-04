<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Navigation Bar</title>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333; /* Example background color */
        }

        li {
            float: left;
        }

        li.right-align {
            float: right;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }
    </style>
</head>
<body>
<?php
session_start();

// Define common navigation links
$commonNavLinks = array(
    'Home' => 'home1.php',
    'About' => 'home1.php',
    'Contact' => 'contact-form.php',
    'Courses' => 'courses.php',
    'Cart' =>'cart.php',
    'Orders' => 'orders.php',
    'Sign Up' => 'register.php',
    'Log Out' => 'log-out.php',
    'Profile' => 'user-details.php'
);

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Check if the user is an admin
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        // Admin navigation links
        $navLinks = array_merge($commonNavLinks, array(
            'Update Courses' => 'update_course.php',
            'Add Courses' => 'addcourses.php',
        ));
    } else {
        // Normal user navigation links
        $navLinks = $commonNavLinks;
    }
} else {
    // Display default navigation links for guests
    $navLinks = array(
        'Home' => 'home1.php',
        'Sign Up' => 'register.php',
        'Log In' => 'loginform.php',
    );
}

// Display the navigation bar
echo '<ul>';
foreach ($navLinks as $title => $link) {
    $class = in_array($title, ['Sign Up', 'Log In']) ? 'right-align' : '';

    echo '<li class="' . $class . '"><a href="' . $link . '">' . $title . '</a></li>';
}
echo '</ul>';
?>


<!-- The rest of your HTML content goes here -->

</body>
</html>
