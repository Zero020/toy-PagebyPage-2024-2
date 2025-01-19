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
<div?php //include 'calendar_insert.php' ; // 카테고리 파라미터 가져오기 $category=isset($_GET['category']) ? $_GET['category'] : ''
    ; // 카테고리 이름 설정 (초기값 추가) $category_name='전체 게시판' ; // 기본값 설정 switch ($category) { case 'novel' :
    $category_name='소설/문학' ; break; case 'philosophy' : $category_name='심리/철학' ; break; case 'society' :
    $category_name='사회/현대 이슈' ; break; case 'economy' : $category_name='경제/경영' ; break; case 'science' :
    $category_name='과학/기술' ; break; case 'art' : $category_name='예술/문화' ; break; } // 세션에서 사용자 정보 가져오기
    //session_start(); $nickname=isset($_SESSION["nickname"]) ? $_SESSION["nickname"] : "익명" ; // 기본값: 익명 ?>
    <!DOCTYPE html>
    <html lang="ko">

    <head>
        <meta charset="utf-8">
        <title>게시판 글쓰기</title>
        <link rel="stylesheet" type="text/css" href="./css/board-form.css">
        <link rel="stylesheet" type="text/css" href="./css/buttons.css">
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

            //카테고리 드롭다운
            document.addEventListener("DOMContentLoaded", function () {
                const dropdownButton = document.querySelector('[data-select]'); // 버튼
                const dropdownList = document.querySelector('[data-select_list]'); // 드롭다운 리스트
                const radioInputs = dropdownList.querySelectorAll('input[type="radio"]'); // 모든 라디오 버튼

                // 초기 상태 설정
                dropdownButton.setAttribute('data-select', 'closed');
                dropdownList.style.display = 'none';

                // 드롭다운 버튼 클릭 이벤트
                dropdownButton.addEventListener('click', function () {
                    const isOpen = dropdownButton.getAttribute('data-select') === 'open';

                    if (isOpen) {
                        dropdownButton.setAttribute('data-select', 'closed');
                        dropdownList.style.display = 'none';
                    } else {
                        dropdownButton.setAttribute('data-select', 'open');
                        dropdownList.style.display = 'block';
                    }
                });

                // 라디오 버튼 클릭 시 값 업데이트
                radioInputs.forEach(function (input) {
                    input.addEventListener('change', function () {
                        const selectedText = this.nextElementSibling.textContent; // 선택된 라벨 텍스트
                        dropdownButton.textContent = selectedText; // 버튼 텍스트 업데이트
                        dropdownButton.setAttribute('data-select', 'closed');
                        dropdownList.style.display = 'none'; // 드롭다운 닫기
                    });
                });

                // 드롭다운 외부 클릭 시 닫기
                document.addEventListener('click', function (event) {
                    if (!dropdownButton.contains(event.target) && !dropdownList.contains(event.target)) {
                        dropdownButton.setAttribute('data-select', 'closed');
                        dropdownList.style.display = 'none';
                    }
                });
            });




        </script>
    </head>

    <body>
        <header>
        </header>
        <section>
            <div id="main_img_bar">
            </div>

            <h2 id="board_title">
                글 쓰기
            </h2>
            <form name="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
                <div class="form-entire">

                    <fieldset>
                        <input type="hidden" name="category" value="<?= htmlspecialchars($category, ENT_QUOTES) ?>">
                        <legend>글쓴이</legend>

                        <div class="one-line">
                            <div></div>
                        </div>
                    </fieldset>



                    <fieldset data-align_content="row" class="one-line">
                        <legend>카테고리<span data-color="red">필수</span></legend>
                        <div class="one-line" data-field_content>

                            <div data-selectbox>
                                <button type="button" data-select="closed" data-validate="true"
                                    class="dropdown-category">
                                    카테고리 선택
                                </button>
                                <ul data-select_list class="dropdown-category">
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value style="display: none;">
                                            <span>카테고리 선택</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="101" style="display: none;">
                                            <span>소설/문학</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="102" style="display: none;">
                                            <span>심리/철학</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="103" style="display: none;">
                                            <span>사회/현대이슈</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="104" style="display: none;">
                                            <span>경제/경영</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="105" style="display: none;">
                                            <span>과학/기술</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label data-label>
                                            <input type="radio" name="category_list" value="106" style="display: none;">
                                            <span>예술/문화</span>
                                        </label>
                                    </li>
                                </ul>
                                <select name="category" data-validate="true" class="dropdown-category">
                                    <option value>카테고리 선택</option>
                                    <option value="101">소설/문학</option>
                                    <option value="102">심리/철학</option>
                                    <option value="103">사회/현대이슈</option>
                                    <option value="104">경제/경영</option>
                                    <option value="105">과학/기술</option>
                                    <option value="106">예술/문화</option>

                                </select>

                            </div>
                        </div>
                    </fieldset>
                    <!-- ====================== 주제-체크박스 ======================= -->

                    <fieldset data-align_content="row">

                        <legend>주제<span data-color="red">필수</span></legend>

                        <div data-field_content class="one-line">
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
                                <li><label><input type="checkbox" name="interest_field[]" value="future"><span>미래</span>
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


                <div class="form-entire">
                    <fieldset data-align_content="row">
                        <legend>글 제목<span data-color="red">필수</span></legend>

                        <div class="one-line" data-field_content>
                            <input name="subject" type="text" placeholder="게시물의 제목을 입력해주세요">

                        </div>
                    </fieldset>

                    <fieldset data-align_content="row">
                        <legend>책 검색<span data-color="red">필수</span></legend>
                        <div class="one-line" data-field_content="">
                            <input name="book_name" type="text" placeholder="소개할 책을 등록해주세요">
                            <button type="button" onclick="fetchBookInfo()">책 정보 가져오기</button>
                        </div>
                    </fieldset>

                    <fieldset data-align_content="row">
                        <legend>책 정보</legend>
                        <div class="one-line" data-field_content>
                            <textarea class="book-info-textarea" name="book_info" class="book-info" readonly></textarea>
                        </div>
                    </fieldset>

                    <fieldset data-align_content="row" class="vertical-line">
                        <legend>글작성
                            <span data-color="red">필수</span>
                        </legend>
                        <div id="content" class="two-line">
                            <div data-field_content>
                                <textarea name="content" class="content"></textarea>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="form-entire">
                    <fieldset data-align_content="row">
                        <div class="one-line">

                            <legend>
                                추천여부
                                <span data-color="red">필수</span>
                            </legend>

                            <div class="icon-buttons" data-field_content>
                                <button type="button" class="recommend-btn" data-value="yes">👍 추천</button>
                                <button type="button" class="recommend-btn" data-value="no">👎 비추천</button>
                                <input type="hidden" name="recommend" id="recommend-value">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset data-align_content="row">
                        <legend>첨부파일</legend>
                        <div class="one-line" data-field_content>
                            <input class="file-dirty" type="file" name="upfile">
                        </div>
                    </fieldset>
                </div>
                </div>

                <div id="user-submit">
                    <ul class="buttons">
                        <li><button type="button" onclick="check_input()">완료</button></li>
                        <li><button type="button"
                                onclick="location.href='board_list.php?category=<?= htmlspecialchars($category, ENT_QUOTES) ?>'">목록</button>
                        </li>
                    </ul>
                </div>
            </form>

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