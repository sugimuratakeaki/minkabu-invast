/**
 * YouTube動画カルーセル用JavaScript
 */
document.addEventListener("DOMContentLoaded", function() {
    // Swiperの初期化
    if (typeof Swiper !== 'undefined' && document.querySelector('.video-carousel')) {
        new Swiper(".video-carousel", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
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
                    spaceBetween: 30
                }
            }
        });
    }
});