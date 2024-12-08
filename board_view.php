<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>게시판 글 보기</title>
<link rel="stylesheet" type="text/css" href="./css/loginbackground.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
</head>
<body>
<header>
    <?php include "header.php"; ?>
</header>
<section>
    <div id="main_img_bar">
        
    </div>
    <div id="board_box">
        <h3 class="title">게시판 > 내용보기</h3>
<?php
    // 게시글 ID 및 카테고리 가져오기
    $post_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
    $category = isset($_GET["category"]) ? htmlspecialchars($_GET["category"]) : '';
    $page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

    // 기본값 설정
    if (empty($category)) {
        $category = "default";
    }

    // 파라미터 유효성 검사
    if ($post_id <= 0) {
        echo "<script>alert('잘못된 게시글 ID입니다.'); history.go(-1);</script>";
        exit;
    }

    // DB 연결
    $con = mysqli_connect("localhost", "root", "", "book_platform");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // 게시글 데이터 가져오기
    $sql = "SELECT posts.*, users.nickname 
            FROM posts 
            LEFT JOIN users ON posts.author_id = users.nickname 
            WHERE posts.id = $post_id";
    $result = mysqli_query($con, $sql);

    if ($row = mysqli_fetch_array($result)) {
        $title = $row["title"];
        $content = $row["content"];
        $nickname = $row["nickname"];
        $created_at = $row["created_at"];
        $file_copied = $row["file_copied"];
        $view_count = $row["view_count"];

        $file_path = "./data/" . $file_copied;
        $file_size = file_exists($file_path) ? filesize($file_path) : 0;

        // 조회수 증가
        $new_view_count = $view_count + 1;
        $update_sql = "UPDATE posts SET view_count = $new_view_count WHERE id = $post_id";
        mysqli_query($con, $update_sql);
    } else {
        echo "<script>alert('게시글을 찾을 수 없습니다.'); history.go(-1);</script>";
        exit;
    }

    // 책 정보 가져오기
    $book_info_sql = "SELECT * FROM book_posts WHERE post_id = $post_id";
    $book_result = mysqli_query($con, $book_info_sql);
    $book_info_row = mysqli_fetch_array($book_result);

    $book_name = $book_info_row["book_name"] ?? "정보 없음";
    $book_details = $book_info_row["book_info"] ?? "정보 없음";
    $recommend = $book_info_row["recommend"] ?? "정보 없음";
?>
        <ul id="view_content">
            <li>
                <span class="col1"><b>제목 :</b> <?= htmlspecialchars($title, ENT_QUOTES) ?></span>
                <span class="col2">작성자: <?= htmlspecialchars($nickname, ENT_QUOTES) ?> | 작성일: <?= $created_at ?></span>
            </li>
            <li>
                <?php if ($file_copied) { ?>
                <div class="file-info">
                    첨부파일: <a href="board_download.php?file=<?= urlencode($file_copied) ?>">[다운로드]</a> (<?= number_format($file_size) ?> Bytes)
                </div>
                <?php } ?>
                <div class="content">
                    <?= nl2br(htmlspecialchars($content, ENT_QUOTES)) ?>
                </div>
            </li>
            <div class="recolocation">
            <li class="row">
                <span class="col1"><b>책 제목 :</b></span>
                <span class="col2"><?= htmlspecialchars($book_name, ENT_QUOTES) ?></span>
            </li>
            <li class="row">
                <span class="col1"><b>책 정보 :</b></span>
                <span class="col2"><?= nl2br(htmlspecialchars($book_details, ENT_QUOTES)) ?></span>
            </li>
            <li class="row">
                <span class="col1"><b>추천 여부 :</b></span>
                
                <span class="col2">
                    <?= $recommend === "yes" ? "👍 추천" : ($recommend === "no" ? "👎 비추천" : "정보 없음") ?>
                </span>
    
            </li>
            </div>
        </ul>

        <ul class="buttons">
            <li>
                <button class = "brown" onclick="location.href='board_list.php?category=<?= urlencode($category) ?>&page=<?= $page ?>'">목록</button>
            </li>
            <li>
                <button class = "brown" onclick="location.href='board_modify_form.php?id=<?= $post_id ?>&category=<?= urlencode($category) ?>&page=<?= $page ?>'">수정</button>
            </li>
            <li>
                <button class = "brown" onclick="confirmDelete(<?= $post_id ?>, '<?= urlencode($category) ?>', <?= $page ?>)">삭제</button>
            </li>
        </ul>

        <h4>댓글</h4>
        <ul id="comment_list">
        <?php
        $sql = "SELECT * FROM comments WHERE post_id = $post_id ORDER BY created_at DESC";
        $result = mysqli_query($con, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($comment = mysqli_fetch_array($result)) {
                $comment_id = $comment["id"];
                $comment_content = htmlspecialchars($comment["content"], ENT_QUOTES);
                $comment_author = htmlspecialchars($comment["author_nickname"], ENT_QUOTES);
                $comment_created_at = $comment["created_at"];

                echo "<li id='comment-$comment_id'>";
                echo "<b>$comment_author</b> ($comment_created_at): ";
                echo "<span id='comment-content-$comment_id'>$comment_content</span>";

                if ($_SESSION["nickname"] === $comment_author) { // 댓글 작성자만 수정 및 삭제 가능
                    echo "
                        <button class = 'brown2' onclick='editComment($comment_id, \"$comment_content\")'>수정</button>
                        <button class = 'brown2' onclick='deleteComment($comment_id)'>삭제</button>
                    ";
                }
                echo "</li>";
            }
        } else {
            echo "<li>댓글이 없습니다. 첫 번째 댓글을 작성해보세요!</li>";
        }
        ?>
        </ul>

        <form method="post" action="comment_insert.php">
            <input type="hidden" name="post_id" value="<?= $post_id ?>">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES) ?>">
            <textarea class = "comment-box" name="content" placeholder="댓글을 입력하세요" required></textarea>
            <button type="submit" class="comment-submit">댓글 작성</button>
        </form>

        <script>
		function editComment(commentId, currentContent) {
		    const contentSpan = document.getElementById(`comment-content-${commentId}`);
		    const editButtons = document.querySelectorAll(`#comment-${commentId} button`);
		    
		    // 버튼 숨기기
		    editButtons.forEach(button => button.style.display = "none");

		    // 수정 폼 삽입
		    const editForm = `
		        <textarea class = "comment-box" id="edit-text-${commentId}">${currentContent}</textarea>
		        <button class = 'brown2' onclick="saveComment(${commentId})">저장</button>
		        <button class = 'brown2' onclick="cancelEdit(${commentId}, '${currentContent}')">취소</button>
		    `;
		    contentSpan.innerHTML = editForm;
		}


        function saveComment(commentId) {
		    const newContent = document.getElementById(`edit-text-${commentId}`).value;

		    if (newContent.trim() === "") {
		        alert("내용을 입력하세요!");
		        return;
		    }

		    const formData = new FormData();
		    formData.append("comment_id", commentId);
		    formData.append("content", newContent);

		    fetch("comment_update.php", {
		        method: "POST",
		        body: formData,
		    })
		    .then(response => response.text())
		    .then(result => {
		        if (result.trim() === "success") {
		            alert("댓글이 수정되었습니다.");
		            location.reload();
		        } else {
		            alert("댓글 수정 중 오류가 발생했습니다. " + result);
		        }
		    })
		    .catch(error => {
		        console.error("Error:", error);
		        alert("댓글 수정 중 문제가 발생했습니다.");
		    });
		}

		function cancelEdit(commentId, originalContent) {
		    const contentSpan = document.getElementById(`comment-content-${commentId}`);
		    const editButtons = document.querySelectorAll(`#comment-${commentId} button`);
		    
		    // 기존 내용 복원
		    contentSpan.innerText = originalContent;

		    // 버튼 복원
		    editButtons.forEach(button => button.style.display = "inline");
		}


        function deleteComment(commentId) {
            if (confirm("정말로 이 댓글을 삭제하시겠습니까?")) {
                location.href = `comment_delete.php?id=${commentId}&post_id=<?= $post_id ?>&category=<?= urlencode($category) ?>`;
            }
        }

        function confirmDelete(postId, category, page) {
            if (confirm("정말로 삭제하시겠습니까?")) {
                location.href = `board_delete.php?id=${postId}&category=${category}&page=${page}`;
            }
        }
        </script>
    </div> <!-- board_box -->
</section>
<footer>
    <?php include "footer.php"; ?>
</footer>
</body>
</html>
