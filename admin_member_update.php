<?php
    session_start();
    if (isset($_SESSION["isadmin"])) $isadmin = $_SESSION["isadmin"];
    else $isadmin = "";

    if ( $isadmin != 1 )
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 회원정보 수정은 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
        exit;
    }

    $num   = $_GET["id"];
    $is_admin = $_POST["is_admin"];

$con = mysqli_connect("localhost", "root", "", "book_platform");
    $sql = "update users set is_admin=$is_admin where id=$num";
    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

