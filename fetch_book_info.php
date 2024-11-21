<?php
$title = $_GET['title'];
$response = file_get_contents("https://openlibrary.org/search.json?title=" . urlencode($title));
$data = json_decode($response, true);

if (!empty($data['docs'][0])) {
    $book = $data['docs'][0];
    $result = [
        'success' => true,
        'image' => "https://covers.openlibrary.org/b/id/{$book['cover_i']}-L.jpg",
        'description' => $book['first_publish_year'] ?? '설명 없음',
    ];
} else {
    $result = ['success' => false];
}

echo json_encode($result);
?>
