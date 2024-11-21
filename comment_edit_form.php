<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 댓글 ID 가져오기
$comment_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$post_id = isset($_GET["post_id"]) ? intval($_GET["post_id"]) : 0;
$category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"], ENT_QUOTES) : '';

if ($comment_id <= 0 || $post_id <= 0) {
    echo "<script>alert('잘못된 요청입니다.'); history.go(-1);</script>";
    exit;
}

// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// 댓글 데이터 가져오기
$sql = "SELECT * FROM comments WHERE id = $comment_id";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_array($result)) {
    $content = htmlspecialchars($row["content"], ENT_QUOTES);
} else {
    echo "<script>alert('댓글을 찾을 수 없습니다.'); history.go(-1);</script>";
    exit;
}

// DB 연결 종료
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>댓글 수정</title>
</head>
<body>
    <h3>댓글 수정</h3>
    <form method="post" action="comment_update.php">
        <input type="hidden" name="id" value="<?= $comment_id ?>">
        <input type="hidden" name="post_id" value="<?= $post_id ?>">
        <input type="hidden" name="category" value="<?= $category ?>">
        <textarea name="content" required><?= $content ?></textarea>
        <button type="submit">수정 완료</button>
    </form>
</body>
</html>
