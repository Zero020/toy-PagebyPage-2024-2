<?php
// 세션이 시작되지 않았다면 세션 시작
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 세션 확인
if (!isset($_SESSION["username"])) {
    echo "로그인 상태가 아닙니다.";
    exit;
}

// 세션 데이터 확인
$username = $_SESSION["username"];
?>
<?php

//include 'calendar_insert.php';

// 카테고리 파라미터 가져오기
$category = isset($_GET['category']) ? $_GET['category'] : '';

// 카테고리 이름 설정 (초기값 추가)
$category_name = '전체 게시판'; // 기본값 설정
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
}

// 세션에서 사용자 정보 가져오기
//session_start();
$nickname = isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : "익명"; // 기본값: 익명
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>게시판 글쓰기</title>
    <link rel="stylesheet" type="text/css" href="./css/board.css">
    <link rel="stylesheet" type="text/css" href="./css/loginbackground.css">
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    <script>
        // 책 정보를 API로 가져오는 함수
        async function fetchBookInfo() {
            const bookName = document.querySelector('input[name="book_name"]').value.trim();
            if (!bookName) {
                alert("책 이름을 입력하세요!");
                return;
            }

            try {
                const apiKey = "AIzaSyAIUYP0ZU9tsOlcjyimW-WwBYZcdLGskk4";
                const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(bookName)}&key=${apiKey}`);
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

        // 추천 여부 설정
        document.addEventListener('DOMContentLoaded', () => {
            const recommendButtons = document.querySelectorAll('.recommend-btn');
            recommendButtons.forEach(button => {
                button.addEventListener('click', () => {
                    document.getElementById('recommend-value').value = button.dataset.value;

                    // 버튼 스타일 업데이트
                    recommendButtons.forEach(btn => btn.classList.remove('selected'));
                    button.classList.add('selected');
                });
            });
        });

        // 추천/비추천 버튼 선택 로직
        document.addEventListener('DOMContentLoaded', () => {
            const recommendButtons = document.querySelectorAll('.recommend-btn');
            const recommendInput = document.getElementById('recommend-value');

            recommendButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    // 모든 버튼에서 'selected' 클래스 제거
                    recommendButtons.forEach((btn) => btn.classList.remove('selected'));

                    // 클릭한 버튼에 'selected' 클래스 추가
                    button.classList.add('selected');

                    // 숨겨진 입력 필드에 값 설정
                    recommendInput.value = button.dataset.value;
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
        </div>
        <div id="board_box">
            <h3 id="board_title">
                ⊙ 글 쓰기
            </h3>
            <form name="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
                <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES) ?>">
                <ul id="board_form">
                    <li>
                        <span class="col1">이름</span>
                        <span class="col2"><?= htmlspecialchars($nickname, ENT_QUOTES) ?></span>
                    </li>


                    <div>
                        <fieldset data-align_content="row">
                            <legend>카테고리</legend>
                            <div class="dropdown-category">
                                <select name="category" id="category" onchange="this.form.submit()">
                                    <option value="" disabled selected>카테고리 선택</option>

                                    <option value="novel" <?= isset($_GET['category']) && $_GET['category'] == 'novel' ?>>
                                        소설/문학
                                    </option>
                                    <option value="philosophy" <?= isset($_GET['category']) && $_GET['category'] == 'philosophy' ? 'selected' : '' ?>>심리/철학</option>
                                    <option value="society" <?= isset($_GET['category']) && $_GET['category'] == 'society' ? 'selected' : '' ?>>사회/현대 이슈</option>
                                    <option value="economy" <?= isset($_GET['category']) && $_GET['category'] == 'economy' ? 'selected' : '' ?>>경제/경영</option>
                                    <option value="science" <?= isset($_GET['category']) && $_GET['category'] == 'science' ? 'selected' : '' ?>>과학/기술</option>
                                    <option value="art" <?= isset($_GET['category']) && $_GET['category'] == 'art' ? 'selected' : '' ?>>예술/문화</option>
                                </select>
                            </div>
                        </fieldset>

                        <fieldset data-align_content="row">
                            <legend>주제</legend>

                            <div class="checkbox-content">
                                <ul>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="love"><span>사랑</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="creative"><span>창의성</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="success"><span>성공</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="motive"><span>동기부여</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="courage"><span>용기</span></label></li>

                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="hope"><span>희망</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="happy"><span>행복</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="change">
                                            <span>변화</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="passion">
                                            <span>열정</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="travel"><span>모혐</span></label></li>

                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="solitude"><span>고독</span> </label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="conflict">
                                            <span>갈등</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="loss">
                                            <span>상실</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="patience">
                                            <span>인내</span></label></li>
                                    <li><label><input type="checkbox" name="category" value="recovery"><span>회복</span>
                                        </label></li>

                                    <li><label><input type="checkbox" name="interest_field[]" value="greedom">
                                            <span>자유</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="expertise">
                                            <span>전문지식</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="future"><span>미래</span>
                                        </label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="trand">
                                            <span>트렌드</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]" value="innovation">
                                            <span>혁신</span></label></li>

                                    <li><label><input type="checkbox" name="interest_field[]" value="chanllenge">
                                            <span>도전</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="lession"><span>교훈</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="quest"><span>탐구</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="mystery"><span>미스터리</span></label></li>
                                    <li><label><input type="checkbox" name="interest_field[]"
                                                value="not"><span>없음</span></label></li>
                                </ul>
                            </div>
                        </fieldset>
                    </div>

                    <div></div>
                    <li>
                        <span class="col1">제목</span>
                        <span class="col2"><input name="subject" type="text"></span>
                    </li>
                    <li>
                        <span class="col1">책 검색</span>
                        <span class="col2">
                            <input name="book_name" type="text">
                            <button type="button" onclick="fetchBookInfo()">책 정보 가져오기</button>
                        </span>
                    </li>
                    <li id="text_area">
                        <span class="col1">책 정보</span>
                        <span class="col2">
                            <textarea name="book_info" class="book-info" readonly></textarea>
                        </span>
                    </li>
                    <div id="content">
                        <li>
                            <span class="col1">내용</span>
                            <span class="col2">
                                <textarea name="content" class="content"></textarea>
                            </span>
                        </li>
                    </div>
                    <li>
                        <span class="col1">추천 여부</span>
                        <span class="col2">
                            <div class="icon-buttons">
                                <button type="button" class="recommend-btn" data-value="yes">👍 추천</button>
                                <button type="button" class="recommend-btn" data-value="no">👎 비추천</button>
                                <input type="hidden" name="recommend" id="recommend-value">
                            </div>
                        </span>
                    </li>
                    <li>
                        <span class="col1">첨부 파일</span>
                        <span class="col2"><input class="file-dirty" type="file" name="upfile"></span>
                    </li>
                </ul>
                <ul class="buttons">
                    <li><button type="button" onclick="check_input()">완료</button></li>
                    <li><button type="button"
                            onclick="location.href='board_list.php?category=<?= htmlspecialchars($category, ENT_QUOTES) ?>'">목록</button>
                    </li>
                </ul>
            </form>
        </div>
    </section>
    <footer>
        <?php include "footer.php"; ?>
    </footer>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script>
        const editor = new toastui.Editor({
            el: document.querySelector('#content'), // 에디터를 적용할 요소 (컨테이너)
            height: '500px',                        // 에디터 영역의 높이 값 (OOOpx || auto)
            initialEditType: 'wysiwyg',            // 최초로 보여줄 에디터 타입 (markdown || wysiwyg)
            initialValue: '내용을 입력해 주세요.',     // 내용의 초기 값으로, 반드시 마크다운 문자열 형태여야 함
            previewStyle: 'vertical',               // 마크다운 프리뷰 스타일 (tab || vertical)
            hideModeSwitch: true
        });
    </script>
</body>


</html>