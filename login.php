<?php
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    if ($password === $row["password"]) {
        // 로그인 성공, 세션에 모든 정보 저장
        $_SESSION["username"] = $row["username"];
        $_SESSION["nickname"] = $row["nickname"] ?? "닉네임 없음"; // 닉네임이 없으면 기본값 설정
        $_SESSION["email"] = $row["email"] ?? "이메일 없음";


        echo "<script>
                alert('로그인 성공!');
                location.href = 'index.php';
              </script>";
              var_dump($_SESSION);
exit; // 디버깅 후 제거

    } else {
        echo "<script>
                alert('비밀번호가 틀립니다!');
                history.go(-1);
              </script>";
    }
} else {
    echo "<script>
            alert('등록되지 않은 계정입니다!');
            history.go(-1);
          </script>";
}

mysqli_close($con);
?>
