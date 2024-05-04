<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Course</title>
    <style>
        body {
            font-family: Calibri, Helvetica, sans-serif;
            background-color: white;
        }

        label {
            color: white;
        }

        button {
            background-color: black;
            width: 100%;
            color: white;
            padding: 15px;
            margin: 10px 0;
            border: none;
            cursor: pointer;
        }

        form {
            border: 3px solid gray;
            width: 50%;
            margin-left: 390px;
        }

        input[type=text],
        input[type=password] {
            width: 100%;
            margin: 8px 0;
            padding: 12px 20px;
            display: inline-block;
            border: 2px solid gray;
            box-sizing: border-box;
        }

        button:hover {
            opacity: 0.7;
        }

        .container {
            padding: 25px;
            background-color: gray;
        }
    </style>
</head>
<body>

<?php
include("navbar.php");
$errorMessage = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to the database
    $con = mysqli_connect("localhost", "root", "1234", "bright");

    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Get form data
    $language = $_POST['language'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $url = $_POST['url'];
    $imageurl = $_POST['imageurl'];

    // SQL query to insert the course into the database
    $query = "INSERT INTO course (language, price, description, url, imageurl) VALUES ('$language', '$price', '$description', '$url', '$imageurl')";

    // Execute the query
    if (mysqli_query($con, $query)) {
        echo "Course added successfully.";
    } else {
        echo "Error adding course: " . mysqli_error($con);
    }

    // Close the connection
    mysqli_close($con);
}
?>

<center><h1>Add Course</h1></center>
<form name="addCourseForm" method="post">
    <?php if ($errorMessage): ?>
        <p style="color: red"><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <div class="container">
        <label>Language :</label>
        <input type="text" placeholder="Enter Language" id="language" name="language" required>
        <label>Price :</label>
        <input type="text" placeholder="Enter Price" id="price" name="price" required>
        <label>Description :</label>
        <input type="text" placeholder="Enter Description" id="description" name="description" required>
        <label>URL :</label>
        <input type="text" placeholder="Enter URL" id="url" name="url" required>
        <label>Image URL :</label>
        <input type="text" placeholder="Enter Image URL" id="imageurl" name="imageurl" required>
        <button type="submit">Add Course</button>
    </div>
</form>

</body>
</html>

<?php
include("footer.php");
?>




















