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

	    <!-- 카테고리 선택 -->
	    <form method="get" action="board_list.php">
	        <label for="category">카테고리 선택:</label>
	        <select name="category" id="category" onchange="this.form.submit()">
	            <option value="novel" <?= isset($_GET['category']) && $_GET['category'] == 'novel' ? 'selected' : '' ?>>소설/문학</option>
	            <option value="philosophy" <?= isset($_GET['category']) && $_GET['category'] == 'philosophy' ? 'selected' : '' ?>>심리/철학</option>
	            <option value="society" <?= isset($_GET['category']) && $_GET['category'] == 'society' ? 'selected' : '' ?>>사회/현대 이슈</option>
	            <option value="economy" <?= isset($_GET['category']) && $_GET['category'] == 'economy' ? 'selected' : '' ?>>경제/경영</option>
	            <option value="science" <?= isset($_GET['category']) && $_GET['category'] == 'science' ? 'selected' : '' ?>>과학/기술</option>
	            <option value="art" <?= isset($_GET['category']) && $_GET['category'] == 'art' ? 'selected' : '' ?>>예술/문화</option>
	        </select>
	    </form>

	    <ul id="board_list">
			<li>
				<span class="col1">번호</span>
				<span class="col2">제목</span>
				<span class="col3">글쓴이</span>
				<span class="col4">추천 여부</span>
				<span class="col5">등록일</span>
				<span class="col6">조회</span>
			</li>
<?php
	// 페이지 처리
	$page = isset($_GET["page"]) ? $_GET["page"] : 1;
	$category = isset($_GET["category"]) ? $_GET["category"] : '';

	$con = mysqli_connect("localhost", "root", "", "book_platform");
	if (!$con) {
		die("Connection failed: " . mysqli_connect_error());
	}

	// 카테고리 필터 적용
	$sql = "SELECT posts.*, book_posts.recommend, users.nickname 
            FROM posts 
            LEFT JOIN book_posts ON posts.id = book_posts.post_id
            LEFT JOIN users ON posts.author_id = users.nickname";
	if ($category) {
		$sql .= " WHERE posts.category = '$category'";
	}
	$sql .= " ORDER BY posts.id DESC";

	$result = mysqli_query($con, $sql);
	$total_record = mysqli_num_rows($result);

	$scale = 10; // 한 페이지당 보여줄 글 수

	// 페이지 계산
	$total_page = ceil($total_record / $scale);
	$start = ($page - 1) * $scale;

	// 데이터 가져오기
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
		$recommend = $row["recommend"];

		$file_image = $file_name ? "<img src='./img/file.gif'>" : " ";
		$recommend_text = $recommend === "yes" ? "👍 추천" : ($recommend === "no" ? "👎 비추천" : "정보 없음");
?>
			<li>
				<span class="col1"><?= $number ?></span>
				<span class="col2">
				    <a href="board_view.php?id=<?= $id ?>&page=<?= $page ?>&category=<?= $category ?>">
				        <?= htmlspecialchars($title, ENT_QUOTES) ?>
				    </a>
				</span>
				<span class="col3"><?= htmlspecialchars($nickname, ENT_QUOTES) ?></span>
				<span class="col4"><?= $recommend_text ?></span>
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
	// 페이지 번호 출력
	for ($i = 1; $i <= $total_page; $i++) {
	    if ($page == $i) {
	        echo "<li><b> $i </b></li>";
	    } else {
	        echo "<li><a href='board_list.php?page=$i&category=$category'> $i </a></li>";
	    }
	}

	// 이전/다음 버튼
	if ($page > 1) {
	    $new_page = $page - 1;
	    echo "<li><a href='board_list.php?page=$new_page&category=$category'>◀ 이전</a></li>";
	}
	if ($page < $total_page) {
	    $new_page = $page + 1;
	    echo "<li><a href='board_list.php?page=$new_page&category=$category'>다음 ▶</a></li>";
	}

?>
		</ul> <!-- page -->	    	
		<ul class="buttons">
			<li><button type="button" onclick="location.href='board_list.php?category=<?= htmlspecialchars($category, ENT_QUOTES) ?>'">목록</button></li>
<?php 
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
