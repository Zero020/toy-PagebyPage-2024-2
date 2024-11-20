<?php
// UTF-8 설정
header('Content-Type: text/html; charset=utf-8');

// 세션 시작 및 사용자 정보 확인
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    //echo "예스";
} else {
    $username = "";
    //echo "노우";
}

if (isset($_SESSION["nickname"])) {
    $nickname = $_SESSION["nickname"];
    //echo "예스";
} else {
    $nickname = "";
    //echo "노우";
}

if (!$username) {
    echo "<script>
            alert('게시판 글쓰기는 로그인 후 이용해 주세요!');
            history.go(-1);
          </script>";
    exit;
}

// 입력값 가져오기 및 안전한 처리
$subject = htmlspecialchars($_POST["subject"], ENT_QUOTES);
$content = htmlspecialchars($_POST["content"], ENT_QUOTES);
$recommend = htmlspecialchars($_POST["recommend"], ENT_QUOTES);
$book_info = htmlspecialchars($_POST["book_info"], ENT_QUOTES);
$category = htmlspecialchars($_POST["category"], ENT_QUOTES);

$regist_day = date("Y-m-d H:i:s"); // 현재의 '년-월-일 시:분:초' 저장

// 파일 업로드 처리
$upload_dir = './data/';
$upfile_name = $_FILES["upfile"]["name"] ?? "";
$upfile_tmp_name = $_FILES["upfile"]["tmp_name"] ?? "";
$upfile_type = $_FILES["upfile"]["type"] ?? "";
$upfile_size = $_FILES["upfile"]["size"] ?? 0;
$upfile_error = $_FILES["upfile"]["error"] ?? UPLOAD_ERR_NO_FILE;

if ($upfile_name && $upfile_error === UPLOAD_ERR_OK) {
    $file = explode(".", $upfile_name);
    $file_name = $file[0];
    $file_ext = $file[1];

    $new_file_name = date("Y_m_d_H_i_s");
    $copied_file_name = $new_file_name . "." . $file_ext;
    $uploaded_file = $upload_dir . $copied_file_name;

    if ($upfile_size > 1000000) {
        echo "<script>
                alert('업로드 파일 크기가 지정된 용량(1MB)을 초과합니다! 파일 크기를 확인해주세요.');
                history.go(-1);
              </script>";
        exit;
    }

    if (!move_uploaded_file($upfile_tmp_name, $uploaded_file)) {
        echo "<script>
                alert('파일을 지정한 디렉토리에 복사하는데 실패했습니다.');
                history.go(-1);
              </script>";
        exit;
    }
} else {
    $upfile_name = "";
    $upfile_type = "";
    $copied_file_name = "";
}

echo "현재 세션 닉네임: " . $_SESSION["nickname"] . "<br>";

// DB에서 해당 닉네임이 존재하는지 확인
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
// 게시판 데이터 저장
$sql = "INSERT INTO posts (title, content, author_id, category, created_at, file_name, file_type) 
        VALUES ('$subject', '$content', '$nickname', '$category', '$regist_day', '$upfile_name', '$upfile_type')";
if (!mysqli_query($con, $sql)) {
    echo "<script>
            alert('게시글 저장 중 오류가 발생했습니다.');
            console.error('" . mysqli_error($con) . "');
            history.go(-1);
          </script>";
    exit;
}


$nickname_check = $_SESSION["nickname"];
$sql = "SELECT * FROM users WHERE nickname = '$nickname_check'";
$result = mysqli_query($con, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "닉네임 '$nickname_check'은(는) DB에 존재합니다.<br>";
} else {
    echo "닉네임 '$nickname_check'은(는) DB에 존재하지 않습니다. DB를 확인하세요.<br>";
}



// DB 연결 종료
mysqli_close($con);

// 게시판 목록 페이지로 이동
echo "<script>
        location.href = 'board_list.php?category=$category';
      </script>";
?>
