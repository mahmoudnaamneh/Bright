
<!DOCTYPE html>   
<html>   
<head>  
<meta name="viewport" content="width=device-width, initial-scale=1">  
<title> Login Page </title>  
<style>   
Body {  
  font-family: Calibri, Helvetica, sans-serif;  
  background-color: white;  
}  
label{
    color: white;
}
button {   
       background-color: black;   
       width: 100%;  
        color: white;   
        padding: 15px;   
        margin: 10px 0px;   
        border: none;   
        cursor: pointer;   
         }   
 form {   
        border: 3px solid gray;   
        width: 50%;
        margin-left: 390px;
    }   
 input[type=text], input[type=password] {   
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
  .cancelbtn {   
        width: auto;   
        padding: 10px 18px;  
        margin: 10px 5px;  
        color: white;
    }   
 .container {   
        padding: 25px;   
        background-color: gray;  
    }   
</style>   
</head>    
<body> 
<?php
include("navbar.php");?>
<?php
$errorMessage= '';
$con=mysqli_connect("localhost","root","1234","bright");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,"SELECT * FROM user");





$dataArray= array();
$i=0;
while($row = mysqli_fetch_array($result) ){
    $dataArray[$i]["id"]=$row['id'];
    $dataArray[$i]["username"]=$row['username'];
    $dataArray[$i]["password"]=$row['password'];
    $dataArray[$i]["locked"]=$row['locked'];
    $dataArray[$i]["attemptdate"]=$row['attemptdate'];
    $dataArray[$i]["role"]=$row['role'];
    $dataArray[$i]["forget"]=$row['forget'];
    $i++;
}


$users =$dataArray;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id=$_POST['id'];
    // $locked = $_POST['locked'];
    // $attemptdate = $_POST['attemptdate'];
    
    $userFound = false;

    
foreach($users as $user)
 {
  
    $num=0;
    if ($username === $user['username']) {
        $userFound = true;
        echo "Role for user {$user['username']}: {$user['role']}<br>";

        if($user['forget'] ==1 && $password === $user['password']){
            $_SESSION['username']=$username;
            header("Location: reset-password.php");
            exit; 
        }
        // Check if the account is locked
        if ($user['locked']) {
            $errorMessage = 'Your account has been locked.';
            break;
        }

        // Check if the password matches
        if ($password === $user['password']) {
            // Set the username in the session
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $user['id'];

            // Update user's status
            $query = "UPDATE user SET locked = 0, attemptdate = NOW() WHERE username = '$username'";
            mysqli_query($con, $query);

            // Redirect based on user's role
            if ($user['role'] == 'admin') {
                $_SESSION["role"] = $user['role'];
                header("Location: addcourses.php");
            } elseif($user['role'] == 'normal') {
                    // Set session variables
            $_SESSION["role"] =$user['role'];
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $username;
                header("Location: home1.php");
            }
            exit; 
        } else {
            if (isset($_SESSION['login_attempts'][$username]) && $_SESSION['login_attempts'][$username] >= 2) {
                $errorMessage = 'You have reached the maximum number of login attempts. Please try again later.';
                $query = "UPDATE user SET locked = 1, attemptdate = NOW() WHERE username = '$username'";
                mysqli_query($con, $query);
            } else {
                $_SESSION['login_attempts'][$username] = isset($_SESSION['login_attempts'][$username]) ? $_SESSION['login_attempts'][$username] + 1 : 1;
                $num=$_SESSION['login_attempts'][$username];
                $query = "UPDATE user SET login_attempts = $num  WHERE username = '$username'";
                mysqli_query($con, $query);
                $errorMessage = 'Incorrect password.';
            }
            break;
        }
    }
}

// בדיקת התחברות נכשלה - ניהול נסיונות הכניסה
if (!$userFound) {
    $errorMessage = 'User not found.';
}
}
?>   
    <center> <h1> Student Login Form </h1> </center>   
    <form name="loginform"  method="post">  
        <?php if($errorMessage): ?>
            <p style="color: red"><?php echo $errorMessage;?></p>
        <?php endif;?>
        <div class="container">   
            <label>Username : </label>   
            <input type="text" placeholder="Enter Username" id="username" name="username" required>  
            <label>Password : </label>   
            <input type="password" placeholder="Enter Password" id="password" name="password" required>  
            <button type="submit">Login</button>  
             
            <a href="forgot_password.php">Forgot Password?</a>
        </div>   
    </form>     


    </body>     
</html>
<?php
include("footer.php");
?>


<!-- 

$adminornormal= "SELECT role FROM user";
      if($adminornormal === "adminuser"){
        header("Location: courses.php"); 
        break;
      } -->