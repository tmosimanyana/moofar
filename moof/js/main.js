// Mobile menu toggle
const mobileToggle = document.querySelector('.mobile-toggle');
const mainNav = document.getElementById('mainNav');

function toggleMenu() {
  const isOpen = mainNav.classList.toggle('active');
  mobileToggle.setAttribute('aria-expanded', isOpen);
}

// Close mobile menu on link click
mainNav.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    if (mainNav.classList.contains('active')) {
      mainNav.classList.remove('active');
      mobileToggle.setAttribute('aria-expanded', 'false');
    }
  });
});

// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      const headerOffset = 80; // adjust for fixed header
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.scrollY - headerOffset;
      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  });
});

