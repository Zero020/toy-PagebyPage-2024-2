<?php
    $username = $_GET["username"];

    $pass = $_POST["password"];
    $name = $_POST["nickname"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
          
$con = mysqli_connect("localhost", "root", "", "book_platform");
    $sql = "update users set password='$pass', nickname='$name' , email='$email'";
    $sql .= " where username='$username'";
    mysqli_query($con, $sql);

    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>

   
