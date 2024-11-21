<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>독서 플랫폼</title>
    <link rel="stylesheet" href="./css/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
     <?php include 'header.php'; ?>

    <section class="main-banner observe">
        <video autoplay muted loop class="banner-video">
        <source src="./video/banner2.mp4" type="video/mp4">
        Your browser does not support the video tag.
        </video>
        <div class="banner-text">
            <h3>한 페이지씩, 나를 채우는 시간</h3>
            <p>읽고, 기록하며, 공유하며 나의 이야기를 채워보세요.</p>
        </div>
        <div class="main-down">
            <a href="#"><img class="view-more" src="./img/main_down2.png" onclick="main_down()"></a>
        </div>

</section>

<section class="categories">
    <h2>카테고리별 게시판</h2>
    <div class="category-slider-container">
        <button id="prev" class="slider-btn">◀</button>
        <div class="category-slider">
            <div class="slider-item">
                <a href="board_form.php?category=novel" class="book-link">
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
                <a href="board_form.php?category=philosophy" class="book-link">
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
                <a href="board_form.php?category=society" class="book-link">
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
                <a href="board_form.php?category=economy" class="book-link">
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
                <a href="board_form.php?category=science" class="book-link">
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
                <a href="board_form.php?category=art" class="book-link">
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


<section class="calendar observe">
    <h2>독서 캘린더</h2>
    <div class="calendar-preview">
        <p>캘린더 기능을 통해 읽은 책을 정리하고 관리하세요.</p>
        <a href="calendar_view.php" class="btn">캘린더 보기</a>
    </div>
</section>

<section class="popular-books observe">
    <h2>BEST 도서</h2>
    <div class="book-slider">
        <div class="book">
            <img src="./img/book1.jpg" alt="Book 1">
            <p>Book Title 1</p>
        </div>
        <div class="book">
            <img src="./img/book2.jpg" alt="Book 2">
            <p>Book Title 2</p>
        </div>
        <div class="book">
            <img src="./img/book3.jpg" alt="Book 3">
            <p>Book Title 3</p>
        </div>
    </div>
</section>
<script src="js/slider.js"></script>

</body>
</html>
