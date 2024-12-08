const slider = document.querySelector('.category-slider');
const items = document.querySelectorAll('.slider-item');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
const dots = document.querySelectorAll('.dot');
let currentIndex = 0;

function updateSlider() {
    slider.style.transform = `translateX(-${currentIndex * 20}%)`;

    items.forEach((item, index) => {
        if (index === currentIndex) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    dots.forEach((dot, index) => {
        if (index === currentIndex) {
            dot.classList.add('active');
        } else {
            dot.classList.remove('active');
        }
    });
}

prevBtn.addEventListener('click', () => {
    currentIndex = (currentIndex > 0) ? currentIndex - 1 : items.length - 1;
    updateSlider();
    console.log(`Prev button clicked. Current index: ${currentIndex}`); // 이벤트 로깅
});

nextBtn.addEventListener('click', () => {
    currentIndex = (currentIndex < items.length - 1) ? currentIndex + 1 : 0;
    updateSlider();
    console.log(`Next button clicked. Current index: ${currentIndex}`); // 이벤트 로깅
});

dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        currentIndex = index;
        updateSlider();
        console.log(`Dot ${index + 1} clicked. Current index: ${currentIndex}`); // 이벤트 로깅
    });
});

// 초기 실행
updateSlider();
