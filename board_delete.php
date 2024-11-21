<?php
// UTF-8 설정
header('Content-Type: text/html; charset=utf-8');

// 파라미터 가져오기
$post_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0; // 기존 num 대신 id 사용
$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
$category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"], ENT_QUOTES) : '';

// 유효성 검증
if ($post_id <= 0) {
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

// 게시글 정보 가져오기 (파일명 확인용)
$sql = "SELECT file_copied FROM posts WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $copied_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// 파일 삭제 처리
if (!empty($copied_name)) {
    $file_path = "./data/" . $copied_name;
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// 게시글 삭제
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $post_id);
$result = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

if (!$result) {
    echo "
        <script>
            alert('게시글 삭제 중 오류가 발생했습니다.');
            history.go(-1);
        </script>
    ";
    mysqli_close($con);
    exit;
}

// 관련된 책 정보 삭제 (book_posts 테이블)
$sql = "DELETE FROM book_posts WHERE post_id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $post_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

// DB 연결 종료
mysqli_close($con);

// 목록 페이지로 리다이렉트
echo "
    <script>
        location.href = 'board_list.php?page=$page&category=$category';
    </script>
";
?>
