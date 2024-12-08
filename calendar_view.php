<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$con = mysqli_connect("localhost", "root", "", "book_platform");
if (!$con) {
    die("DB 연결 실패: " . mysqli_connect_error());
}

$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "익명";


// 사용자 ID 가져오기
$sql_user_id = "SELECT id FROM users WHERE username = ?";
$stmt_user = mysqli_prepare($con, $sql_user_id);
mysqli_stmt_bind_param($stmt_user, "s", $username);
mysqli_stmt_execute($stmt_user);
mysqli_stmt_bind_result($stmt_user, $user_id);
mysqli_stmt_fetch($stmt_user);
mysqli_stmt_close($stmt_user);

// 해당 사용자의 캘린더 이벤트 가져오기
$sql_events = "SELECT book_title, date, book_image,recommend FROM calendar WHERE user_id = ?";
$stmt_events = mysqli_prepare($con, $sql_events);
mysqli_stmt_bind_param($stmt_events, "s", $user_id);
mysqli_stmt_execute($stmt_events);
mysqli_stmt_store_result($stmt_events);
mysqli_stmt_bind_result($stmt_events, $book_title, $date, $book_image, $recommend);

// 이벤트 배열 생성
$events = [];
while (mysqli_stmt_fetch($stmt_events)) {
    $events[] = [
        'title' => $book_title,
        'start' => $date,
        'extendedProps' => [
            'image' => $book_image,
            'recommend'=>$recommend
        ]
    ];
}
mysqli_stmt_close($stmt_events);

// DB 연결 종료
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=2.0">
  <title>독서 캘린더</title>
  
  <!-- FullCalendar 글로벌 네임스페이스 -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js"></script>
  
  <!-- Custom CSS -->
  <link href="./css/calendar.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="./css/header.css">
<link rel="stylesheet" type="text/css" href="./css/loginbackground.css">


</head>
<body>
    <header>
    <?php include "header.php"; ?>
</header>

    <!--<h1>독서 캘린더</h1>-->
    <div id="calendar-container">
        <div id="calendar"></div>
    </div>
    <div id="memo-container">
        <h2>책 정보 입력</h2>
        <div class="memo-field">
            <label>책 제목</label>
            <input type="text" id="book-title" placeholder="책 제목 입력">
            <button id="fetch-book-info">책 정보 가져오기</button>
        </div>
        <div class="memo-field">
            <label>책 이미지</label>
            <div id="book-image" style="margin-top: 10px;"></div>
        </div>
        <div class="memo-field">
            <label>책 내용</label>
            <textarea id="book-info" rows="4" readonly></textarea>
        </div>
        <div class="memo-field">
            <label>리뷰</label>
            <textarea id="book-review" rows="4" placeholder="책 리뷰 입력"></textarea>
        </div>
        <div class="memo-field">
            <label>추천 여부</label>
            <select id="recommend">
                <option value="yes">추천</option>
                <option value="no">비추천</option>
            </select>
        </div>
        <div class="memo-actions">
            <button id="save-memo">저장</button>
            <button id="cancel-memo">취소</button>
            <button id="update-memo" style="display:none;">수정</button>
            <button id="delete-memo" class="delete" style="display:none;">삭제</button>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const memoContainer = document.getElementById('memo-container');
        const bookTitleInput = document.getElementById('book-title');
        const bookInfoInput = document.getElementById('book-info');
        const bookReviewInput = document.getElementById('book-review');
        const recommendSelect = document.getElementById('recommend');
        const saveButton = document.getElementById('save-memo');
        const cancelButton = document.getElementById('cancel-memo');
        const updateButton = document.getElementById('update-memo');
        const deleteButton = document.getElementById('delete-memo');

        // 기본적으로 메모 폼 숨기기
        memoContainer.style.display = 'none';

        let selectedDate = null;
        let selectedEvent = null;

        // PHP에서 전달한 DB 이벤트 데이터를 가져오기
        const eventsFromDB = <?php echo json_encode($events); ?>;

        // 캘린더 초기화
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',  // 기본 뷰: 월
            locale: 'En',
            headerToolbar: {
                left: 'prev,next today',   // 이전, 다음, 오늘
                center: 'title',           // 제목 (예: 2024년 11월)
                right: 'dayGridMonth,timeGridWeek,listWeek',
            },
            dateClick: function (info) {
                    selectedDate = info.dateStr;
                    selectedEvent = null;
                    openMemoForm();
                },
                eventClick: function (info) {
                    selectedEvent = info.event;
                    loadEventData(info.event);
                    openMemoForm(true);
                },
                events: eventsFromDB,  // DB에서 가져온 이벤트 데이터를 캘린더에 추가
                eventContent: function (arg) {
                    const { title, extendedProps } = arg.event;
                    const imageUrl = extendedProps.image;
                    const recommend = extendedProps.recommend;

                    const dotColor = recommend === "yes" ? "green" : "red"; // 초록색(추천), 빨간색(비추천)
                    const dotHtml = `<span style="color: ${dotColor}; font-size: 18px; margin-right: 8px;">●</span>`;
                    // 이미지와 제목을 함께 표시
                    const imgHtml = imageUrl ? `<img src="${imageUrl}" alt="${title}" style="width: 140px; height:190px; display: block; margin: 0 auto;">` : '';
                    const titleHtml = `<div style="text-align: center; font-size: 15px;">${dotHtml}${title}</div>`;
                    return { html: imgHtml + titleHtml };
                },
            });

            calendar.render();

            function openMemoForm(isEdit = false) {
                memoContainer.style.display = 'flex';
                memoContainer.classList.add('fade-in');

                if (isEdit) {
                    saveButton.style.display = 'none';
                    updateButton.style.display = 'inline';
                    deleteButton.style.display = 'inline';
                } else {
                    saveButton.style.display = 'inline';
                    updateButton.style.display = 'none';
                    deleteButton.style.display = 'none';
                }
            }

            function closeMemoForm() {
                memoContainer.style.display = 'none';
                bookTitleInput.value = '';
                bookInfoInput.value = '';
                bookReviewInput.value = '';
                recommendSelect.value = 'yes';
            }
            memoContainer.style.display = 'none';


            function loadEventData(event) {
                bookTitleInput.value = event.title;
                bookInfoInput.value = event.extendedProps.info || '';
                bookReviewInput.value = event.extendedProps.review || '';
                recommendSelect.value = event.extendedProps.recommend || 'yes';
            }

            // 책 정보 가져오기 (Google Books API)
             document.getElementById('fetch-book-info').addEventListener('click', async function () {
                const title = bookTitleInput.value.trim();

                if (!title) {
                    alert('책 제목을 입력하세요.');
                    return;
                }

                try {
                    const apiKey = "AIzaSyAIUYP0ZU9tsOlcjyimW-WwBYZcdLGskk4";
                    const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(title)}&key=${apiKey}`);
                    const data = await response.json();

                    if (data.items && data.items.length > 0) {
                        const book = data.items[0].volumeInfo;
                        const bookImage = book.imageLinks?.thumbnail || '';
                        const bookAuthors = book.authors?.join(', ') || '저자 정보 없음';

                        // 책 정보를 입력 필드에 업데이트
                        bookInfoInput.value = `제목: ${book.title}\n저자: ${bookAuthors}\n설명: ${book.description || '설명 없음'}`;

                        // 책 이미지를 업데이트
                        const bookImageContainer = document.getElementById('book-image');
                        if (bookImage) {
                            bookImageContainer.innerHTML = `<img src="${bookImage}" alt="${book.title}" style="max-width: 100px;"/>`;
                        } else {
                            bookImageContainer.innerHTML = '이미지를 찾을 수 없습니다.';
                        }
                    } else {
                        alert('책 정보를 찾을 수 없습니다.');
                    }
                } catch (error) {
                    console.error('Error fetching book info:', error);
                    alert('책 정보를 가져오는 중 문제가 발생했습니다.');
                }
            });

           // 데이터 저장 (서버에 전송)
            saveButton.addEventListener('click', function () {
                const bookTitle = bookTitleInput.value;
                const bookReview = bookReviewInput.value;
                const recommend = recommendSelect.value;
                const bookImageElement = document.getElementById('book-image').querySelector('img');
                const bookImage = bookImageElement ? bookImageElement.src : '';  

                if (!selectedDate) {
                    alert("날짜를 선택해주세요.");
                    return;
                }

                if (!bookTitle) {
                    alert("책 제목을 입력해주세요.");
                    return;
                }

                fetch('calendar_insert.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        book_title: bookTitle,
                        book_info: bookInfoInput.value,  
                        book_review: bookReview,
                        recommend: recommend,
                        selected_date: selectedDate,
                        book_image: bookImage,  
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error("Error:", error));

                // 캘린더에 이벤트 추가
                calendar.addEvent({
                    title: bookTitle,
                    start: selectedDate,
                    extendedProps: {
                        info: bookInfoInput.value,
                        review: bookReview,
                        recommend: recommend,
                        image: bookImage,  
                    },
                });

                closeMemoForm();  
            });

            // 수정
            updateButton.addEventListener('click', function () {
                if (selectedEvent) {
                    selectedEvent.setProp('title', bookTitleInput.value);
                    selectedEvent.setExtendedProp('info', bookInfoInput.value);
                    selectedEvent.setExtendedProp('review', bookReviewInput.value);
                    selectedEvent.setExtendedProp('recommend', recommendSelect.value);
                }
                closeMemoForm();
            });

            // 삭제
            deleteButton.addEventListener('click', function () {
                if (selectedEvent) {
                    selectedEvent.remove();
                }
                closeMemoForm();
            });

            // 취소
            cancelButton.addEventListener('click', function () {
                closeMemoForm();
            });
        });
    </script>
</body>
</html>
