<!DOCTYPE html>
<html lang="ko">
<head> 
<meta charset="utf-8">
<title>게시판 글 수정</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
  function check_input() {
      if (!document.board_form.subject.value.trim()) {
          alert("제목을 입력하세요!");
          document.board_form.subject.focus();
          return false;
      }
      if (!document.board_form.content.value.trim()) {
          alert("내용을 입력하세요!");    
          document.board_form.content.focus();
          return false;
      }
      document.board_form.submit();
  }
</script>
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
	    <h3 id="board_title">게시판 > 글 수정</h3>
<?php
	$post_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
	$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
	$category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"], ENT_QUOTES) : '';

	if ($post_id <= 0) {
	    echo "<script>alert('잘못된 요청입니다.'); history.go(-1);</script>";
	    exit;
	}
	
	$con = mysqli_connect("localhost", "root", "", "book_platform");
	if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM posts WHERE id = $post_id";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if (!$row) {
	    echo "<script>alert('게시글을 찾을 수 없습니다.'); history.go(-1);</script>";
	    exit;
	}

	$nickname   = htmlspecialchars($row["author_id"], ENT_QUOTES);
	$subject    = htmlspecialchars($row["title"], ENT_QUOTES);
	$content    = htmlspecialchars($row["content"], ENT_QUOTES);
	$file_name  = $row["file_name"];

	mysqli_close($con);
?>
	    <form name="board_form" method="post" action="board_modify.php" enctype="multipart/form-data">
	    	<input type="hidden" name="category" value="<?= $category ?>">
	    	<input type="hidden" name="id" value="<?= $post_id ?>">
	    	<input type="hidden" name="page" value="<?= $page ?>">
	    	 <ul id="board_form">
				<li>
					<span class="col1">작성자 :</span>
					<span class="col2"><?= $nickname ?></span>
				</li>		
	    		<li>
	    			<span class="col1">제목 :</span>
	    			<span class="col2"><input name="subject" type="text" value="<?= $subject ?>"></span>
	    		</li>	    	
	    		<li id="text_area">	
	    			<span class="col1">내용 :</span>
	    			<span class="col2">
	    				<textarea name="content"><?= $content ?></textarea>
	    			</span>
	    		</li>
	    		<li>
			        <span class="col1">첨부 파일 :</span>
			        <span class="col2"><?= $file_name ?: '없음' ?></span>
			    </li>
	    	</ul>
	    	<ul class="buttons">
				<li>
					<button type="button" 
					        onclick="location.href='board_list.php?page=<?= $page ?>&category=<?= $category ?>'">
					        목록
					</button>
				</li>
				<li>
					<button type="button" onclick="check_input()">수정하기</button>
				</li>
			</ul>
	    </form>
	</div> <!-- board_box -->
</section> 
<footer>
    <?php include "footer.php"; ?>
</footer>
</body>
</html>
