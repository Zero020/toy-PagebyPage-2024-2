<?php
    
    session_start();
$username = $_SESSION["username"] ?? "로그인 안 됨";
$nickname = $_SESSION["nickname"] ?? "닉네임 없음";
$email = $_SESSION["email"] ?? "이메일 없음";
echo "사용자 이름: $username, 닉네임: $nickname, 이메일: $email";
?>

}
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["nickname"])) $nickname = $_SESSION["nickname"];
    else $nickname = "";
?>
<header>
    <div class="logo">
        <h1><a href="index.php">···  PAGE BY PAGE ···</a></h1>
    </div>
    <nav>
        <ul>
            <li><a href="about.php">소개</a></li>
            <li><a href="board.php">게시판</a></li>
            <li><a href="calendar.php">캘린더</a></li>
        </ul>
    </nav>
    <ul id="top_menu">  
<?php
    if(!$username) {
?>                
        <li><a href="login_form.php">로그인</a></li>
<?php
    } else {
?>
        <li><a href="logout.php">로그아웃</a></li>
        <li><a href="member_modify_form.php">정보수정</a></li>
        <li><a href="board_form.php">게시판 만들기(14장)</a></li>
<?php
    }
?>
    </ul>
</header>