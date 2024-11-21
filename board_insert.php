<?php
// UTF-8 설정
header('Content-Type: text/html; charset=utf-8');

// 세션 시작 및 사용자 정보 확인
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION["username"] ?? "";
$nickname = $_SESSION["nickname"] ?? "";

// 로그인 확인
if (!$username) {
    echo "<script>
            alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
            history.go(-1);
          </script>";
    exit;
}

// 입력값 가져오기 및 안전한 처리
$subject = htmlspecialchars($_POST["subject"] ?? '', ENT_QUOTES);
$content = htmlspecialchars($_POST["content"] ?? '', ENT_QUOTES);
$recommend = htmlspecialchars($_POST["recommend"] ?? '', ENT_QUOTES);
$book_info = htmlspecialchars($_POST["book_info"] ?? '', ENT_QUOTES);
$category = htmlspecialchars($_POST["category"] ?? '', ENT_QUOTES);
//var_dump($subject, $content, $category); exit;

// 입력값 유효성 검사
if (empty($subject) || empty($content) || empty($category)) {
    echo "<script>
            alert('제목, 내용, 카테고리는 필수 입력 사항입니다.');
            history.go(-1);
          </script>";
    exit;
}

$regist_day = date("Y-m-d H:i:s"); // 현재의 '년-월-일 시:분:초' 저장

// 파일 업로드 처리
$upload_dir = './data/';
$upfile_name = $_FILES["upfile"]["name"] ?? "";
$upfile_tmp_name = $_FILES["upfile"]["tmp_name"] ?? "";
$upfile_type = $_FILES["upfile"]["type"] ?? "";
$upfile_size = $_FILES["upfile"]["size"] ?? 0;
$upfile_error = $_FILES["upfile"]["error"] ?? UPLOAD_ERR_NO_FILE;

$copied_file_name = ""; // 초기화

if ($upfile_name && $upfile_error === UPLOAD_ERR_OK) {
    $file = explode(".", $upfile_name);
    $file_name = $file[0];
    $file_ext = $file[1];

    $new_file_name = date("Y_m_d_H_i_s");
    $copied_file_name = $new_file_name . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;

    if ($upfile_size > 1000000) {
        echo "<script>
                alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다!');
                history.go(-1);
              </script>";
        exit;
    }

    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        echo "<script>
                alert('파일 업로드 실패.');
                history.go(-1);
              </script>";
        exit;
    }
}

// DB 연결
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    echo "<script>
            alert('DB 연결 실패: " . mysqli_connect_error() . "');
          </script>";
    exit;
}

// 게시글 저장
$sql = "INSERT INTO posts (title, content, author_id, category, created_at, file_name, file_type, file_copied) 
        VALUES ('$subject', '$content', '$nickname', '$category', '$regist_day', '$upfile_name', '$upfile_type', '$copied_file_name')";
if (!mysqli_query($con, $sql)) {
    echo "<script>
            alert('게시글 저장 중 오류 발생: " . mysqli_error($con) . "');
          </script>";
    exit;
}

// 새로 추가된 게시글의 ID 가져오기
$post_id = mysqli_insert_id($con);

// 책 정보 저장
$sql = "INSERT INTO book_posts (post_id, book_name, book_info, recommend) 
        VALUES ('$post_id', '$subject', '$book_info', '$recommend')";
if (!mysqli_query($con, $sql)) {
    echo "<script>
            alert('책 정보 저장 중 오류 발생: " . mysqli_error($con) . "');
          </script>";
    exit;
}

// DB 연결 종료
mysqli_close($con);

// 성공적으로 저장 후 이동
echo "<script>
        alert('게시글이 성공적으로 등록되었습니다.');
        location.href = 'board_list.php?category=$category';
      </script>";
?>
