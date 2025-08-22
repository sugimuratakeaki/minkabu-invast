document.addEventListener('DOMContentLoaded', function() {
    // Drawer functionality removed
    
    // Magazine Dropdown Menu for PC
    const magazineDropdown = document.querySelector('.l-header__media__li:last-child');
    if (magazineDropdown) {
        const dropdownMenu = magazineDropdown.querySelector('.l-header__media__second');
        let hoverTimeout;
        
        magazineDropdown.addEventListener('mouseenter', function() {
            clearTimeout(hoverTimeout);
            if (dropdownMenu) {
                dropdownMenu.style.display = 'flex';
            }
        });
        
        magazineDropdown.addEventListener('mouseleave', function() {
            hoverTimeout = setTimeout(function() {
                if (dropdownMenu) {
                    dropdownMenu.style.display = 'none';
                }
            }, 100);
        });
    }
    
    // Smooth Scroll
    const smoothScrollLinks = document.querySelectorAll('a[href^="#"]');
    smoothScrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = link.getAttribute('href');
            if (href !== '#' && href !== '#0') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
    
    // Sticky Header
    const header = document.querySelector('.sp_header, .l-header');
    if (header) {
        let lastScroll = 0;
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset;
            if (currentScroll > 100) {
                header.classList.add('is-sticky');
                if (currentScroll > lastScroll) {
                    header.classList.add('is-hidden');
                } else {
                    header.classList.remove('is-hidden');
                }
            } else {
                header.classList.remove('is-sticky', 'is-hidden');
            }
            lastScroll = currentScroll;
        });
    }
    
    // Back to Top Button
    const backToTop = document.createElement('button');
    backToTop.innerHTML = '↑';
    backToTop.className = 'back-to-top';
    backToTop.setAttribute('aria-label', 'ページトップへ戻る');
    document.body.appendChild(backToTop);
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('is-visible');
        } else {
            backToTop.classList.remove('is-visible');
        }
    });
});