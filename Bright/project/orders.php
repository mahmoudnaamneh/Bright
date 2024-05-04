<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    // Start or resume the session
    include("navbar.php");

    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        // Redirect the user to the login page if not logged in
        header("Location: loginform.php");
        exit(); // Stop further execution
    }

    // Check if the user is an admin
    $is_admin = false;
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        $is_admin = true;
    }

    // Database connection
    $con = mysqli_connect("localhost", "root", "1234", "bright");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
    }

    // Fetch orders grouped by user ID and order date
    $orders_query_by_user_date = "SELECT orders.user_id, orders.order_date, 
                    GROUP_CONCAT(course.language SEPARATOR ', ') AS course_names, 
                    SUM(course.price) AS total_price
                    FROM orders
                    INNER JOIN course ON orders.course_id = course.idcourse";

    // If the user is not an admin, filter orders for the logged-in user
    if (!$is_admin) {
        $user_id = $_SESSION['id'];
        $orders_query_by_user_date .= " WHERE user_id = '$user_id'";
    }

    // Group the results by user_id and order_date
    $orders_query_by_user_date .= " GROUP BY orders.user_id, orders.order_date";

    // Execute the query for orders grouped by user ID and order date
    $orders_result_by_user_date = mysqli_query($con, $orders_query_by_user_date);

    // Check if there are any orders grouped by user ID and order date
    if (mysqli_num_rows($orders_result_by_user_date) > 0) {
        // Output the orders grouped by user ID and order date
        echo "<div class='container mt-5'>";
        echo "<h2>Orders Grouped by User ID and Order Date</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead class='thead-dark'>";
        echo "<tr><th>User ID</th><th>Order Date</th><th>Course Names</th><th>Total Price</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($orders_result_by_user_date)) {
            echo "<tr>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td>" . $row['course_names'] . "</td>";
            echo "<td>" . $row['total_price'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No orders grouped by user ID and order date found.";
    }

    // Fetch orders grouped by order ID
    $orders_query_by_order_id = "SELECT orders.order_id, orders.user_id, orders.order_date, 
                    GROUP_CONCAT(course.language SEPARATOR ', ') AS course_names, 
                    SUM(course.price) AS total_price
                    FROM orders
                    INNER JOIN course ON orders.course_id = course.idcourse";

    // If the user is not an admin, filter orders for the logged-in user
    if (!$is_admin) {
        $user_id = $_SESSION['id'];
        $orders_query_by_order_id .= " WHERE user_id = '$user_id'";
    }

    // Group the results by order_id
    $orders_query_by_order_id .= " GROUP BY orders.order_id, orders.user_id, orders.order_date";

    // Execute the query for orders grouped by order ID
    $orders_result_by_order_id = mysqli_query($con, $orders_query_by_order_id);

    // Check if there are any orders grouped by order ID
    if (mysqli_num_rows($orders_result_by_order_id) > 0) {
        // Output the orders grouped by order ID
        echo "<div class='container mt-5'>";
        echo "<h2>Orders Grouped by Order ID</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead class='thead-dark'>";
        echo "<tr><th>Order ID</th><th>User ID</th><th>Order Date</th><th>Course Names</th><th>Total Price</th></tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($orders_result_by_order_id)) {
            echo "<tr>";
            echo "<td>" . $row['order_id'] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";
            echo "<td>" . $row['course_names'] . "</td>";
            echo "<td>" . $row['total_price'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "No orders grouped by order ID found.";
    }

    // Close the database connection
    mysqli_close($con);
    include("footer.php");
    ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
