<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start(); // 헤더 출력 오류 방지

// POST 요청으로 받은 데이터 확인
$post_id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
$page = isset($_POST["page"]) ? trim($_POST["page"]) : 1;
$category = isset($_POST["category"]) ? trim($_POST["category"]) : "";

// 제목과 내용 가져오기
$subject = isset($_POST["subject"]) ? htmlspecialchars($_POST["subject"], ENT_QUOTES) : "";
$content = isset($_POST["content"]) ? htmlspecialchars($_POST["content"], ENT_QUOTES) : "";

// 유효성 검증
if ($post_id <= 0 || empty($subject) || empty($content)) {
    echo "
        <script>
            alert('잘못된 요청입니다.');
            history.go(-1);
        </script>
    ";
    exit;
}

// 데이터베이스 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL 쿼리로 데이터 업데이트
$sql = "UPDATE posts SET title='$subject', content='$content' WHERE id=$post_id";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo "
        <script>
            alert('게시글 수정 중 오류가 발생했습니다.');
            history.go(-1);
        </script>
    ";
    mysqli_close($con);
    exit;
}

// DB 연결 종료
mysqli_close($con);

// 리다이렉트 처리
$query_string = "page=$page&category=" . urlencode($category);
header("Location: board_list.php?$query_string");
exit;
?>
