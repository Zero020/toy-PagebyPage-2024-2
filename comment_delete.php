<?php
// 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 데이터 가져오기
$comment_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$post_id = isset($_GET["post_id"]) ? intval($_GET["post_id"]) : 0;
$category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"], ENT_QUOTES) : '';

// 유효성 검사
if ($comment_id <= 0 || $post_id <= 0) {
    echo "<script>
            alert('잘못된 요청입니다.');
            history.go(-1);
          </script>";
    exit;
}

// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// 댓글 삭제
$sql = "DELETE FROM comments WHERE id = $comment_id";
if (!mysqli_query($con, $sql)) {
    echo "<script>
            alert('댓글 삭제 중 오류가 발생했습니다.');
            history.go(-1);
          </script>";
    exit;
}

// DB 연결 종료
mysqli_close($con);

// 댓글 삭제 후 게시글 보기 페이지로 이동
echo "<script>
        location.href = 'board_view.php?id=$post_id&category=$category';
      </script>";
?>
