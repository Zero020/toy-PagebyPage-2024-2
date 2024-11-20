<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>게시판 목록보기</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
</head>
<body> 
<header>
    <?php include "header.php"; ?>
</header>  
<section>
	<div id="main_img_bar">
        <img src="./img/main_img.png">
    </div>
   	<div id="board_box">
	    <h3>게시판 > 목록보기</h3>
	    <ul id="board_list">
			<li>
				<span class="col1">번호</span>
				<span class="col2">제목</span>
				<span class="col3">글쓴이</span>
				<span class="col4">첨부</span>
				<span class="col5">등록일</span>
				<span class="col6">조회</span>
			</li>
<?php
	// 페이지 및 카테고리 처리
	$page = isset($_GET["page"]) ? $_GET["page"] : 1;
	$category = isset($_GET["category"]) ? $_GET["category"] : '';

	$con = mysqli_connect("localhost", "root", "", "book_platform");
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// 카테고리별 필터 적용
	$sql = "SELECT posts.*, users.nickname FROM posts 
            LEFT JOIN users ON posts.author_id = users.nickname";
	if ($category) {
		$sql .= " WHERE category = '$category'";
	}
	$sql .= " ORDER BY posts.id DESC";

	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result); // 전체 글 수

	$scale = 10; // 한 페이지당 보여줄 글 수

	// 전체 페이지 수 계산
	$total_page = ceil($total_record / $scale);
	$start = ($page - 1) * $scale;

	// 페이징에 맞는 데이터 가져오기
	$sql .= " LIMIT $start, $scale";
	$result = mysqli_query($con, $sql);
	$number = $total_record - $start;

	while ($row = mysqli_fetch_array($result)) {
		$id = $row["id"];
		$title = $row["title"];
		$nickname = $row["nickname"];
		$created_at = $row["created_at"];
		$view_count = $row["view_count"];
		$file_name = $row["file_name"];

		$file_image = $file_name ? "<img src='./img/file.gif'>" : " ";
?>
			<li>
				<span class="col1"><?= $number ?></span>
				<span class="col2">
				    <a href="board_view.php?id=<?= $id ?>&page=<?= $page ?>&category=<?= $category ?>">
				        <?= htmlspecialchars($title, ENT_QUOTES) ?>
				    </a>
				</span>

				<span class="col4"><?= $file_image ?></span>
				<span class="col5"><?= $created_at ?></span>
				<span class="col6"><?= $view_count ?></span>
			</li>
<?php
		$number--;
	}
	mysqli_close($con);
?>
	    </ul>
		<ul id="page_num"> 	
<?php
	// 이전 페이지
	if ($page > 1) {
		$new_page = $page - 1;
		echo "<li><a href='board_list.php?page=$new_page&category=$category'>◀ 이전</a></li>";
	}

	// 페이지 번호 출력
	for ($i = 1; $i <= $total_page; $i++) {
		if ($page == $i) {
			echo "<li><b> $i </b></li>";
		} else {
			echo "<li><a href='board_list.php?page=$i&category=$category'> $i </a></li>";
		}
	}

	// 다음 페이지
	if ($page < $total_page) {
		$new_page = $page + 1;
		echo "<li><a href='board_list.php?page=$new_page&category=$category'>다음 ▶</a></li>";
	}
?>
		</ul> <!-- page -->	    	
		<ul class="buttons">
			<li><button onclick="location.href='board_list.php'">목록</button></li>
			<li>
<?php 
   if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
    if (isset($_SESSION["username"])) {
?>
				<button onclick="location.href='board_form.php?category=<?= $category ?>'">글쓰기</button>
<?php
	} else {
?>
				<a href="javascript:alert('로그인 후 이용해 주세요!')"><button>글쓰기</button></a>
<?php
	}
?>
			</li>
		</ul>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php"; ?>
</footer>
</body>
</html>
