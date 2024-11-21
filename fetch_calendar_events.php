<?php
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$sql = "SELECT date, book_title FROM calendar";
$result = mysqli_query($con, $sql);

$events = [];
while ($row = mysqli_fetch_assoc($result)) {
    $events[] = [
        'title' => $row['book_title'],
        'start' => $row['date'],
    ];
}
mysqli_close($con);

echo json_encode($events);
?>
