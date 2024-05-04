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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['course_id'])) {
        $course_id = $_POST['course_id'];
        
        // Fetch user details from the database
        $user_id = $_SESSION['id'];

        $check_cart_query = "SELECT * FROM cart WHERE iduser = '$user_id' AND idcourse = '$course_id'";
        $check_cart_result = mysqli_query($con, $check_cart_query);
        
        // Check if the course has already been purchased by the user
        $check_purchase_query = "SELECT purchased FROM orders WHERE user_id = '$user_id' AND course_id = '$course_id'";
        $result = mysqli_query($con, $check_purchase_query);
        $row = mysqli_fetch_assoc($result);
        if ($row && $row['purchased'] == 1) {
            echo "You have already purchased this course.";
        } else if (mysqli_num_rows($check_cart_result) > 0) {
            echo "This course is already in your cart.";
        } else {
            // Check if places are available for the course
            $check_places_query = "SELECT places FROM course WHERE idcourse = '$course_id'";
            $places_result = mysqli_query($con, $check_places_query);
            $places_row = mysqli_fetch_assoc($places_result);
            $places_available = intval($places_row['places']);
            
            if ($places_available == 0) {
                echo "Sorry, this course is currently unavailable.";
            } else {
                // Insert the cart item into the database
                $insert_query = "INSERT INTO cart (iduser, idcourse) VALUES ('$user_id', '$course_id')";
                if (mysqli_query($con, $insert_query)) {
                    echo "Course added to cart successfully.";
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            }
        }
    }
}

$result = mysqli_query($con, "SELECT * FROM course");

$dataArray= array();
$i=0;
while($row = mysqli_fetch_array($result) ){
    $dataArray[$i]["idcourse"]=$row[0];
    $dataArray[$i]["language"]=$row[1];
    $dataArray[$i]["price"]=$row[2];  
    $dataArray[$i]["places"] = $row[3]; 
    $dataArray[$i]["description"]=$row[4];
    $dataArray[$i]["url"]=$row[5];
    $dataArray[$i]["imageurl"]=$row[6];
    $i++;
}

$courses =$dataArray;

function displayCourseCard($course) {
    echo "<div class='col-md-4'>";
    echo "<div class='card product-card'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>id: {$course['idcourse']}</h5>";
    echo "<p class='card-text'>language: {$course['language']}</p>";
    echo "<p class='card-text'>description: {$course['description']}</p>";
    echo "<p class='card-text'>price: {$course['price']}</p>";
    echo "<p class='card-text'>places: {$course['places']}</p>";
    echo "<form class='add-to-cart-form' method='post' action='".$_SERVER['PHP_SELF']."'>";
    echo "<input type='hidden' name='course_id' value='".$course['idcourse']."'>";
    // Check if places are available and disable the button if not
    echo "<button type='submit' class='add_to_cart_btn'>Add to Cart</button>";
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
        .card-title {
            color: #333;
            font-weight: bold;
            font-size: 20px;
        }
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
        .table-container {
            margin-top: 20px;
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
                <?php displayCourseCard($course); ?>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Button to show the highest-priced course
        document.getElementById('highest-price-btn').addEventListener('click', function() {
            document.getElementById('course-table-container').style.display = 'block';
        });

        // Button to color the table
        document.getElementById('color-btn').addEventListener('click', function() {
            document.getElementById('course-table').style.backgroundColor = 'black';
            document.getElementById('course-table').style.color = 'red';
        });

        // Handle adding to cart
        
        document.querySelectorAll('.add_to_cart_btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const form = button.closest('.add-to-cart-form');
                form.submit();
            });
        });
    </script>
</body>
</html>
<?php
include("footer.php");
?>