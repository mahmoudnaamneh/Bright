<?php
$con=mysqli_connect("localhost","root","1234","bright");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM user");

// echo "<table border='1'>
// <tr>
// <th>idcourse</th>
// <th>language</th>
// <th>price</th>
// <th>description</th>
// <th>url</th>
// <th>imageurl</th>
// </tr>";

//  while($row = mysqli_fetch_array($result))
// {
// echo "<tr>";
// echo "<td>" . $row['idcourse'] . "</td>";
// echo "<td>" . $row['language'] . "</td>";
// echo "<td>" . $row['price'] . "</td>";
// echo "<td>" . $row['description'] . "</td>";
// echo "<td>" . $row['url'] . "</td>";
// echo "<td><img src='" . $row['imageurl'] . "' width=75px hieght=75px></td>";
// echo "</tr>";
// }
// echo "</table>";

// mysqli_close($con);
?>
