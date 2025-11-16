// Moofar Proprietary Limited - Main JavaScript

// Mobile menu toggle
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

if (menuToggle && mainNav) {
  menuToggle.addEventListener('click', () => {
    mainNav.classList.toggle('active');
    menuToggle.textContent = mainNav.classList.contains('active') ? '✕' : '☰';
  });
}

// Smooth scrolling for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({ 
        behavior: 'smooth', 
        block: 'start' 
      });
    }
  });
});

// Simple reveal on scroll animation
const obs = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.style.opacity = 1;
      e.target.style.transform = 'translateY(0)';
    }
  });
}, { threshold: 0.15 });

// Apply animation to elements
document.querySelectorAll('.feature-item, .team-card, .about-content, .about-image').forEach(el => {
  el.style.opacity = 0;
  el.style.transform = 'translateY(18px)';
  el.style.transition = 'all .6s ease';
  obs.observe(el);
});

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
  if (menuToggle && mainNav) {
    if (!e.target.closest('header') && mainNav.classList.contains('active')) {
      mainNav.classList.remove('active');
      menuToggle.textContent = '☰';
    }
  }
});

// Close mobile menu when window is resized to desktop size
window.addEventListener('resize', () => {
  if (window.innerWidth > 768 && mainNav && mainNav.classList.contains('active')) {
    mainNav.classList.remove('active');
    if (menuToggle) {
      menuToggle.textContent = '☰';
    }
  }
});
