<?php
// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

// 세션 처리, 사용자 ID 가져오기
session_start();
$username = $_SESSION["username"] ?? "";

// 데이터 가져오기
$bookTitle = htmlspecialchars($_POST["book_title"] ?? '', ENT_QUOTES);
$bookReview = htmlspecialchars($_POST["book_review"] ?? '', ENT_QUOTES);
$recommend = htmlspecialchars($_POST["recommend"] ?? '', ENT_QUOTES);
$selectedDate = htmlspecialchars($_POST["selected_date"] ?? '', ENT_QUOTES);
$bookImage = htmlspecialchars($_POST["book_image"] ?? '', ENT_QUOTES);

// 유효성 검사
if (empty($bookTitle) || empty($selectedDate)) {
    echo json_encode(["status" => "error", "message" => "필수 입력 사항이 누락되었습니다."]);
    exit;
}

// 사용자 ID 가져오기
$sql_user_id = "SELECT id FROM users WHERE username = ?";
$stmt_user = mysqli_prepare($con, $sql_user_id);
mysqli_stmt_bind_param($stmt_user, "s", $username);
mysqli_stmt_execute($stmt_user);
mysqli_stmt_bind_result($stmt_user, $user_id);
mysqli_stmt_fetch($stmt_user);
mysqli_stmt_close($stmt_user);

// 데이터 삽입
$sql = "INSERT INTO calendar (user_id, book_title, memo, recommend, date, book_image, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, NOW())";
$stmt = mysqli_prepare($con, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssss", $user_id, $bookTitle, $bookReview, $recommend, $selectedDate, $bookImage);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "캘린더 데이터가 저장되었습니다."]);
    } else {
        echo json_encode(["status" => "error", "message" => "데이터 저장 중 오류 발생: " . mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["status" => "error", "message" => "SQL 준비 중 오류 발생: " . mysqli_error($con)]);
}

mysqli_close($con);
?>
