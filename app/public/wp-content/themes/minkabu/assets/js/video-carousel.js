/**
 * YouTube動画カルーセル用JavaScript
 */
document.addEventListener("DOMContentLoaded", function() {
    // Swiperの初期化
    if (typeof Swiper !== 'undefined' && document.querySelector('.video-carousel')) {
        const swiper = new Swiper(".video-carousel", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: false,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 25
                },
                1280: {
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
        
        // ビデオリンククリックイベント
        const videoLinks = document.querySelectorAll('.video-link');
        videoLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const videoId = this.dataset.videoId;
                const url = `https://www.youtube.com/watch?v=${videoId}`;
                window.open(url, '_blank');
            });
        });
    }
});