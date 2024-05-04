<?php  
include("navbar.php");

if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: loginform.php");
    exit(); // Stop further execution
}

$con = mysqli_connect("localhost", "root", "1234", "bright");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if the user is an admin
$is_admin = false;
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $is_admin = true;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the admin updating the places
        $course_id = $_POST['course_id'];
        $new_places = $_POST['new_places'];

        // Update the places for the course in the database
        $update_places_query = "UPDATE course SET places = '$new_places' WHERE idcourse = '$course_id'";
        if (mysqli_query($con, $update_places_query)) {
            echo "Places updated successfully.";
        } else {
            echo "Error updating places: " . mysqli_error($con);
            
        }
    } 


$result = mysqli_query($con, "SELECT * FROM course");

$dataArray= array();
$i=0;
while($row = mysqli_fetch_array($result) ){
    $dataArray[$i]["idcourse"]=$row[0];
    $dataArray[$i]["language"]=$row[1];
    $dataArray[$i]["price"]=$row[2];
    $dataArray[$i]["description"]=$row[3];
    $dataArray[$i]["url"]=$row[4];
    $dataArray[$i]["imageurl"]=$row[5];
    $dataArray[$i]["places"] = $row[6]; // Max enrollment count
    $i++;
}

$courses =$dataArray;

function displayCourseCardForAdmin($course) {
    echo "<div class='col-md-4'>";
    echo "<div class='card product-card'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>{$course['idcourse']}</h5>";
    echo "<p class='card-text'>{$course['language']}</p>";
    echo "<p class='card-text'>{$course['price']}</p>";
    echo "<p class='card-text'>{$course['description']}</p>";
    echo "<form class='update-card-form' method='post' action='".$_SERVER['PHP_SELF']."'>";
    echo "<input type='hidden' name='course_id' value='{$course['idcourse']}'>";
    echo "<input type='number' name='new_places' value='{$course['places']}' required>";
    echo "<button type='submit' name='update_places' class='update-places-btn'>Update Places</button>"; // Added name attribute
    echo "</form>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
}

usort($courses, function($a, $b) {
    return $b['price'] - $a['price'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .product-card {
            margin-bottom: 20px;
        }
        /* .card-title {
            color: #333;
            font-weight: bold;
            font-size: 20px;
        } */
        .card-text {
            color: #666;
            font-size: 16px;
        }
        button {
            background-color: aqua;
            color: blue;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        input[type='number'] {
            width: 60px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="btn-group">
            <button id="highest-price-btn">Highest Price</button>
            <button id="close-btn">Close</button>
            <button id="color-btn" class="color-button">Color Table</button>
        </div>
        <div class="row">
            <?php foreach ($courses as $course) : ?>
                <?php 
                        displayCourseCardForAdmin($course);
                ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    // Handle updating places
   // Handle updating places
document.querySelectorAll('.update-places-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        console.log('Button clicked'); // Add console log
        const form = button.closest('.update-card-form');
        console.log(form); // Add console log
        form.submit();
    });
});

</script>
</body>
</html>
<?php
include("footer.php");
?>
