document.addEventListener('DOMContentLoaded', () => {
    // --- Mobile Menu Toggle ---
    const burgerMenu = document.querySelector('.burger-menu');
    const nav = document.querySelector('.nav');

    if (burgerMenu && nav) {
        burgerMenu.addEventListener('click', () => {
            nav.classList.toggle('active');
            
            // Optional: Animate burger icon
            burgerMenu.classList.toggle('open');
        });
        
        // Close menu when clicking a link
        nav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                nav.classList.remove('active');
                burgerMenu.classList.remove('open');
            });
        });
    }

    // --- Header Scroll Effect (Optional) ---
    const header = document.querySelector('.header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.5)';
        } else {
            header.style.boxShadow = 'none';
        }
    });
});
