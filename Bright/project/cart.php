<?php  
include("navbar.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: loginform.php");
    exit(); // Stop further execution
}

$con = mysqli_connect("localhost", "root", "1234", "bright");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Check if the Remove button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_course_id'])) {
    $remove_course_id = $_POST['remove_course_id'];
    $user_id = $_SESSION['id'];

    // Construct the DELETE query
    $delete_query = "DELETE FROM cart WHERE iduser = '$user_id' AND idcourse = '$remove_course_id'";

    // Execute the DELETE query
    if (mysqli_query($con, $delete_query)) {
        echo "Course removed from cart successfully.";
    } else {
        echo "Error removing course from cart: " . mysqli_error($con);
    }
}

// Fetch user details from the session
$user_id = $_SESSION['id'];
$user_name = ""; // Fetch the user name from the database based on the user ID

// Fetch cart items for the user from the database
$cart_query = "SELECT cart.idcourse, course.language, course.price FROM cart JOIN course ON cart.idcourse = course.idcourse WHERE cart.iduser = '$user_id'";
$result = mysqli_query($con, $cart_query);

// Store cart items in an array
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
}

// Fetch courses that the user has already purchased
$purchased_courses = [];
$purchased_query = "SELECT course_id FROM orders WHERE user_id = '$user_id' AND purchased = 1";
$purchased_result = mysqli_query($con, $purchased_query);
while ($row = mysqli_fetch_assoc($purchased_result)) {
    $purchased_courses[] = $row['course_id'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS can go here */
        /* Add any additional styles specific to this page */
    </style>
</head>
<body>
    <div class="container mt-5">
        <?php
        // Check if any rows are returned
        if (!empty($cart_items)) {
            echo "<h2>Cart Contents:</h2>";
            echo "<table class='table'>";
            echo "<thead class='thead-dark'>";
            echo "<tr><th>Course ID</th><th>Course Name</th><th>Price</th><th>User ID</th><th>User Name</th><th>Action</th></tr>";
            echo "</thead>";
            echo "<tbody>";

            $total_price = 0; // Initialize total price variable
            foreach ($cart_items as $row) {
                // Check if the course is newly added to the cart
                if (!in_array($row['idcourse'], $purchased_courses)) {
                    echo "<tr>";
                    echo "<td>{$row['idcourse']}</td>";
                    echo "<td>{$row['language']}</td>";
                    echo "<td>{$row['price']}</td>";
                    echo "<td>{$user_id}</td>";
                    echo "<td>{$user_name}</td>";
                    echo "<td>";
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='remove_course_id' value='{$row['idcourse']}'>";
                    echo "<button type='submit' class='btn btn-danger'>Remove</button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";

                    // Increment total price with the price of the current course
                    $total_price += $row['price'];
                }
            }
            echo "<tr>";
            echo "<td colspan='2'></td><td>Total Price</td><td></td><td></td>";
            echo "<td>$total_price</td>";
            echo "</tr>";

            echo "</tbody>";
            echo "</table>";
            echo "<div class='mt-3'>";
            echo "<a href='courses.php'><button type='submit' name='return_to_courses' class='btn btn-info'>Continue shopping</button></a>";
            // Add a "Buy All" button
            echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' >";
            echo "<input type='hidden' name='add_buy_all_orders' value='1'>";
            echo "<button type='submit' name='buy_all' class='btn btn-success'>Buy All</button>";
            echo "</form>";
            echo "</div>";

        } else {
            echo "<p>Your cart is empty.</p>";
        }

        // Handle the Buy All button click
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy_all'])) {
            // Loop through the cart items and insert orders into the orders table
            foreach ($cart_items as $row) {
                $course_id = $row['idcourse'];
                
                // Check if the course has already been purchased by the user
                if (!in_array($course_id, $purchased_courses)) {
                    // Insert the order into the orders table
                    $insert_order_query = "INSERT INTO orders (user_id, course_id) VALUES ('$user_id', '$course_id')";
                    if (mysqli_query($con, $insert_order_query)) {
                        // Update the orders table to mark the course as purchased
                        $update_order_query = "UPDATE orders SET purchased = 1 WHERE user_id = '$user_id' AND course_id = '$course_id'";
                        if (!mysqli_query($con, $update_order_query)) {
                            echo "Error updating order: " . mysqli_error($con);
                        }
                    } else {
                        echo "Error placing order: " . mysqli_error($con);
                    }
                }
                
                // Update available places for the course
                $update_places_query = "UPDATE course SET places = places - 1 WHERE idcourse = '$course_id'";
                mysqli_query($con, $update_places_query);
            }
            // Clear the cart after purchase
            $clear_cart_query = "DELETE FROM cart WHERE iduser = '$user_id'";
            if (mysqli_query($con, $clear_cart_query)) {
                echo "<script>alert('All orders placed successfully.');</script>";
                echo "<script>window.location.href = 'orders.php';</script>";
            } else {
                echo "Error clearing cart: " . mysqli_error($con);
            }
        }
        
        // Close the database connection
        mysqli_close($con);
        
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include("footer.php");
?>
