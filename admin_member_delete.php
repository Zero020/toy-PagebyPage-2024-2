<?php
    session_start();
    if (isset($_SESSION["isadmin"])) $isadmin = $_SESSION["isadmin"];
    else $isadmin = "";

    if ( $isadmin != 1 )
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
                exit;
    }

    $num   = $_GET["id"];

$con = mysqli_connect("localhost", "root", "", "book_platform");
    $sql = "delete from users where id = $num";
    mysqli_query($con, $sql);

    mysqli_close($con);

    echo "
	     <script>
	         location.href = 'admin.php';
	     </script>
	   ";
?>

