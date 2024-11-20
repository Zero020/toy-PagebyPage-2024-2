<?php
// 카테고리 파라미터 가져오기
$category = isset($_GET['category']) ? $_GET['category'] : '';

// 카테고리 이름 설정
$category_name = '';
switch ($category) {
    case 'novel':
        $category_name = '소설/문학';
        break;
    case 'philosophy':
        $category_name = '심리/철학';
        break;
    case 'society':
        $category_name = '사회/현대 이슈';
        break;
    case 'economy':
        $category_name = '경제/경영';
        break;
    case 'science':
        $category_name = '과학/기술';
        break;
    case 'art':
        $category_name = '예술/문화';
        break;
    default:
        $category_name = '전체 게시판';
}

// 세션 시작 및 사용자 정보 가져오기
//session_start();
//$username = isset($_SESSION["username"]) ? $_SESSION["username"] : ""; // 사용자 ID
//$nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : ""; // 사용자 닉네임
//if (isset($_SESSION["nickname"])) $nickname = $_SESSION["nickname"];
    //else $nickrname = "";

/*if (!$username) {
    echo "<script>
            alert('로그인 후 이용해 주세요!');
            history.go(-1);
          </script>";
    exit;
}*/
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>게시판 글쓰기</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/board.css">
<script>
// 책 정보를 API로 가져오는 함수
async function fetchBookInfo() {
    const bookName = document.querySelector('input[name="book_name"]').value.trim();
    if (!bookName) {
        alert("책 이름을 입력하세요!");
        return;
    }

    try {
        const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(bookName)}`);
        const data = await response.json();

        if (data.items && data.items.length > 0) {
            const book = data.items[0].volumeInfo;
            document.querySelector('textarea[name="book_info"]').value = `제목: ${book.title}\n저자: ${book.authors ? book.authors.join(', ') : '정보 없음'}\n출판사: ${book.publisher || '정보 없음'}`;
        } else {
            alert("책 정보를 찾을 수 없습니다.");
        }
    } catch (error) {
        alert("책 정보를 가져오는 중 오류가 발생했습니다.");
        console.error(error);
    }
}

// 입력값 검증
function check_input() {
    if (!document.board_form.subject.value.trim()) {
        alert("제목을 입력하세요!");
        document.board_form.subject.focus();
        return false;
    }
    if (!document.board_form.book_name.value.trim()) {
        alert("책 이름을 입력하세요!");
        document.board_form.book_name.focus();
        return false;
    }
    if (!document.board_form.content.value.trim()) {
        alert("내용을 입력하세요!");
        document.board_form.content.focus();
        return false;
    }
    document.board_form.submit();
}

// 추천 여부 선택 버튼 로직
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.recommend-btn').forEach(button => {
        button.addEventListener('click', () => {
            const value = button.dataset.value; // 'yes' 또는 'no'
            document.getElementById('recommend-value').value = value;

            // 버튼 스타일 업데이트 (선택한 버튼 강조 표시)
            document.querySelectorAll('.recommend-btn').forEach(btn => {
                btn.classList.remove('selected');
            });
            button.classList.add('selected');
        });
    });
});
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
        <h3 id="board_title">
            <?= htmlspecialchars($category_name, ENT_QUOTES) ?> ⊙ 글 쓰기
        </h3>
        <form name="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
            <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES) ?>">
            <ul id="board_form">
                <li>
                    <span class="col1">이름:</span>
										<span class="col2"><?=$nickname?></span>
                </li>
                <li>
                    <span class="col1">제목:</span>
                    <span class="col2"><input name="subject" type="text"></span>
                </li>
                <li>
                    <span class="col1">책 검색:</span>
                    <span class="col2">
                        <input name="book_name" type="text">
                        <button type="button" onclick="fetchBookInfo()">책 정보 가져오기</button>
                    </span>
                </li>
                <li id="text_area">
                    <span class="col1">책 정보:</span>
                    <span class="col2">
                        <textarea name="book_info" readonly></textarea>
                    </span>
                </li>
                <li id="text_area">
                    <span class="col1">내용:</span>
                    <span class="col2">
                        <textarea name="content"></textarea>
                    </span>
                </li>
                <li>
                    <span class="col1">추천 여부:</span>
                    <span class="col2">
                        <div class="icon-buttons">
                            <button type="button" class="recommend-btn" data-value="yes">👍 추천</button>
                            <button type="button" class="recommend-btn" data-value="no">👎 비추천</button>
                            <input type="hidden" name="recommend" id="recommend-value">
                        </div>
                    </span>
                </li>
                <li>
                    <span class="col1">첨부 파일:</span>
                    <span class="col2"><input type="file" name="upfile"></span>
                </li>
            </ul>
            <ul class="buttons">
                <li><button type="button" onclick="check_input()">완료</button></li>
                <li><button type="button" onclick="location.href='board_list.php'">목록</button></li>
            </ul>
        </form>
    </div>
</section>
<footer>
    <?php include "footer.php"; ?>
</footer>
</body>
</html>
