<?php
// 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 데이터 가져오기
$post_id = isset($_POST["post_id"]) ? intval($_POST["post_id"]) : 0;
$category = isset($_POST["category"]) ? htmlspecialchars($_POST["category"], ENT_QUOTES) : '';
$content = isset($_POST["content"]) ? htmlspecialchars($_POST["content"], ENT_QUOTES) : '';
$author_nickname = isset($_SESSION["nickname"]) ? htmlspecialchars($_SESSION["nickname"], ENT_QUOTES) : '익명'; // 익명 처리

// 데이터 유효성 검사
if ($post_id <= 0 || empty($content)) {
    echo "<script>
            alert('잘못된 요청입니다. 게시글 ID와 댓글 내용을 확인하세요.');
            history.go(-1);
          </script>";
    exit;
}

// 기본값 설정 (카테고리)
if (empty($category)) {
    $category = "default";
}

// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// 댓글 삽입
$sql = "INSERT INTO comments (post_id, content, author_nickname, created_at) 
        VALUES ('$post_id', '$content', '$author_nickname', NOW())";
if (!mysqli_query($con, $sql)) {
    echo "<script>
            alert('댓글 작성 중 오류가 발생했습니다. 다시 시도하세요.');
            history.go(-1);
          </script>";
    exit;
}

// DB 연결 종료
mysqli_close($con);

// 성공적으로 댓글 작성 후 해당 게시글 페이지로 이동
echo "<script>
        location.href = 'board_view.php?id=$post_id&category=$category';
      </script>";
?>
