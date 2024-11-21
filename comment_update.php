<?php
// 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 데이터 가져오기
$comment_id = isset($_POST["comment_id"]) ? intval($_POST["comment_id"]) : 0; // 수정할 댓글 ID
$new_content = isset($_POST["content"]) ? htmlspecialchars($_POST["content"], ENT_QUOTES) : ''; // 수정된 댓글 내용

// 데이터 유효성 검사
if ($comment_id <= 0 || empty($new_content)) {
    echo "잘못된 요청입니다. 댓글 ID 또는 수정 내용을 확인하세요.";
    exit;
}

// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// 댓글 작성자 확인
$sql_check = "SELECT author_nickname FROM comments WHERE id = $comment_id";
$result_check = mysqli_query($con, $sql_check);

if ($row = mysqli_fetch_array($result_check)) {
    // 현재 로그인한 사용자와 댓글 작성자 비교
    $author_nickname = isset($_SESSION["nickname"]) ? htmlspecialchars($_SESSION["nickname"], ENT_QUOTES) : '익명';
    if ($row["author_nickname"] !== $author_nickname) {
        echo "댓글 작성자만 수정할 수 있습니다.";
        exit;
    }
} else {
    echo "해당 댓글을 찾을 수 없습니다.";
    exit;
}

// 댓글 수정
$sql_update = "UPDATE comments 
               SET content = '$new_content', updated_at = NOW() 
               WHERE id = $comment_id";

if (mysqli_query($con, $sql_update)) {
    echo "success"; // 성공 시 success 반환
} else {
    echo "SQL Error: " . mysqli_error($con); // 오류 시 상세 메시지 반환
}

// DB 연결 종료
mysqli_close($con);
?>
