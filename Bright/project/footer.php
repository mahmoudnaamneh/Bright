<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Footer Example</title>
    <style>
        /* Add some basic styling for the footer */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position:fixed;
            bottom: 0;
            width: 100%;
              /* Ensure fixed footer doesn't overlap content */
              height:auto;
        }

        body {
            margin-bottom: 10px; /* Prevent overlap between body and footer */
        }
        
    </style>
</head>
<body>

<!-- Your website content goes here -->

<?php
// Define your footer content
$footerContent = '&copy; ' . date('Y') . ' Your Website Name. All Rights Reserved.';

// Display the footer
echo '</body>';
echo '<footer>' . $footerContent . '</footer>';
?>

</body>
</html>
