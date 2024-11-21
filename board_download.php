<?php
// 파일 이름 가져오기
$file = isset($_GET["file"]) ? basename($_GET["file"]) : "";
$file_path = "./data/" . $file;

// 파일이 존재하는지 확인
if (!$file || !file_exists($file_path)) {
    echo "<script>alert('파일이 존재하지 않습니다.'); history.go(-1);</script>";
    exit;
}

// 파일 정보 설정 및 다운로드
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($file) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));

// 파일 출력
readfile($file_path);
exit;
?>
