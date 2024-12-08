<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>독서 플랫폼</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" type="text/css" href="./css/loginbackground.css">


     <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $isLoggedIn = isset($_SESSION["username"]);
    ?>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const observeElements = document.querySelectorAll(".observe");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                } else {
                    entry.target.classList.remove("visible");
                }
            });
        },
        {
            threshold: 0.1, // 요소가 10% 보일 때 트리거
        }
    );

    observeElements.forEach((element) => observer.observe(element));
});



    document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.book-link'); // 모든 카테고리 링크 가져오기

        links.forEach(link => {
            link.addEventListener('click', (event) => {
                const isLoggedIn = link.getAttribute('data-logged-in') === 'true'; // 로그인 상태 확인

                if (!isLoggedIn) {
                    event.preventDefault(); // 링크 이동 막기
                    alert('로그인 후 이용가능합니다.');
                    history.go(-1); // 이전 페이지로 이동
                }
            });
        });
    });

    </script>

</head>
<body>
    <section class="main-banner observe">
        <video autoplay muted loop class="banner-video">
        <source src="./video/page.mp4" type="video/mp4">
        Your browser does not support the video tag.
        </video>
        <div class="banner-text">
                        <p class = "main-banner-text">한 페이지씩, 나를 채우는 시간</p>

            <p class = "sub-banner-text">읽고 기록하고 공유하며 나의 이야기를 채워보세요</p>
        </div>
        <div class="main-down">
            <a href="#"><img class="view-more" src="./img/main_down2.png" onclick="main_down()"></a>
        </div>

</section>

<section class="categories">
    <p class = "catetitle">카테고리별 게시판</p>
    <div class="category-slider-container">
        <button id="prev" class="slider-btn">◀</button>
        <div class="category-slider">
            <div class="slider-item">
                <a href="board_form.php?category=novel" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category1.jfif" alt="소설/문학">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>소설/문학</p>
            </div>

            <div class="slider-item">
                <a href="board_form.php?category=philosophy" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category2.jfif" alt="심리/철학">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>심리/철학</p>
            </div>
            <div class="slider-item">
                <a href="board_form.php?category=society" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category3.jfif" alt="사회/현대 이슈">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>사회/현대 이슈</p>
            </div>
            <div class="slider-item">
                <a href="board_form.php?category=economy" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category4.jfif" alt="경제/경영">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>경제/경영</p>
            </div>
            <div class="slider-item">
                <a href="board_form.php?category=science" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category5.jfif" alt="과학/기술">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>과학/기술</p>
            </div>
            <div class="slider-item">
                <a href="board_form.php?category=art" class="book-link" data-logged-in="<?= $isLoggedIn ? 'true' : 'false' ?>">
                    <div class="image-wrapper">
                        <img src="./img/category6.jfif" alt="예술/문화">
                        <div class="overlay">
                            <p>게시판에 입장하세요</p>
                        </div>
                    </div>
                </a>
                <p>예술/문화</p>
            </div>
        </div>
        <button id="next" class="slider-btn">▶</button>
    </div>
    <div class="slider-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</section>


<section class="calendar">
    <p class ="calentitle">독서 캘린더</p>
    <div class="calendar-preview observe">
        <p>캘린더 기능을 통해 읽은 책을 정리하고 관리하세요.</p>
        <a href="calendar_view.php" class="btn">캘린더 보기</a>
    </div>
</section>

<section class="popular-books observe">
    <h2>BEST RECOMMEND</h2>
    <div class="book-slider">
        <div class="book">
            <img src="./img/book1.jpg" alt="Book 1">
            <p>1</p>
        </div>
        <div class="book">
            <img src="./img/book2.jpg" alt="Book 2">
            <p>2</p>
        </div>
        <div class="book">
            <img src="./img/book3.jpg" alt="Book 3">
            <p>3</p>
        </div>
    </div>
</section>
<script src="js/slider.js"></script>

</body>
</html>
