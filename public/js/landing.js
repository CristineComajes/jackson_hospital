document.addEventListener("DOMContentLoaded", () => {
    console.log("Landing page script loaded successfully.");
});
document.addEventListener('DOMContentLoaded', function () {
    const cards = document.querySelectorAll('.digital-services .card');

    // Hover effect
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'scale(1.05)';
            card.style.transition = 'transform 0.3s ease';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'scale(1)';
        });

        // Click feedback
        card.addEventListener('click', () => {
            const title = card.querySelector('h5')?.textContent || 'Card';
            alert(`You clicked: ${title}`);
        });
    });

    // Fade-in on scroll
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, { threshold: 0.3 });

    cards.forEach(card => observer.observe(card));
});


// Select all nav links including dropdown items
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link, .dropdown-item');

    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove active from all
            navLinks.forEach(l => l.classList.remove('active'));
            // Add active to clicked link
            this.classList.add('active');
        });
    });