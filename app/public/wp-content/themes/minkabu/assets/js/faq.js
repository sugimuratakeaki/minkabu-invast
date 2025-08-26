/**
 * FAQアコーディオン用JavaScript
 */
document.addEventListener("DOMContentLoaded", function() {
    // FAQ アコーディオン機能
    const faqItems = document.querySelectorAll(".faq-item");
    
    faqItems.forEach(function(item) {
        const question = item.querySelector(".faq-question");
        const answer = item.querySelector(".faq-answer");
        
        if (question && answer) {
            question.addEventListener("click", function() {
                // 他のFAQを閉じる（オプション：同時に1つだけ開く場合）
                // faqItems.forEach(function(otherItem) {
                //     if (otherItem !== item && otherItem.classList.contains("active")) {
                //         otherItem.classList.remove("active");
                //     }
                // });
                
                // 現在のFAQをトグル
                item.classList.toggle("active");
                
                // スムーズスクロール（アクティブ時）
                if (item.classList.contains("active")) {
                    setTimeout(function() {
                        const rect = item.getBoundingClientRect();
                        const absoluteTop = window.pageYOffset + rect.top - 100;
                        
                        if (rect.top < 0 || rect.top > window.innerHeight) {
                            window.scrollTo({
                                top: absoluteTop,
                                behavior: "smooth"
                            });
                        }
                    }, 300);
                }
            });
        }
    });
    
    // URLハッシュでFAQを開く
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        const targetFaq = document.querySelector('[data-faq-id="' + hash + '"]');
        
        if (targetFaq) {
            targetFaq.classList.add("active");
            setTimeout(function() {
                targetFaq.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });
            }, 100);
        }
    }
});