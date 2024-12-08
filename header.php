<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION["username"])) $username = $_SESSION["username"];
else $username = "";
if (isset($_SESSION["nickname"])) $nickname = $_SESSION["nickname"];
else $nickname = "";
if (isset($_SESSION["isadmin"])) $isadmin = $_SESSION["isadmin"];
else $isadmin = "";
if (isset($_SESSION["profile_image"]) && $_SESSION["profile_image"]) {
    $profile_image = $_SESSION["profile_image"];
} else {
    $profile_image = "../img/default-profile.png";
}
?>

<div id="top">
    <!-- 메뉴바 -->
    <div id="menu_bar">
        <ul>
            <li><a href="board_list.php?category=novel">게시판</a></li>
            <li><a href="calendar_view.php">캘린더</a></li>
        </ul>
    </div>

    <!-- 로고 -->
    <h3 class="logo"><a href="index.php">Page By Page</a></h3>

    <!-- 사용자 정보 -->
    <div class="user-container">
        <!-- 프로필 이미지 -->
        <img src="./uploads/<?= $profile_image ?>" alt="User Logo" class="user-logo">
        <?php if ($username) : ?>
            <!-- 드롭다운 메뉴 -->
            <div class="dropdown">
                <button class="dropdown-btn"><?= $nickname ?>님 ▼</button>
                <div class="dropdown-content">
                    <a href="logout.php">로그아웃</a>
                    <a href="member_modify_form.php">정보수정</a>
                    <?php if ($isadmin == 1) : ?>
                        <a href="admin.php">관리자모드</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <!-- 로그인 및 회원가입 메뉴 -->
            <ul id="top_menu">
                <li><a href="member_form.php">회원가입</a></li>
                <li>|</li>
                <li><a href="login_form.php">로그인</a></li>
            </ul>
        <?php endif; ?>
    </div>
</div>
