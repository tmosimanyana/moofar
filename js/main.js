// --- Main JS for Moofar Website ---

// Toggle mobile menu
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

menuToggle.addEventListener('click', () => {
  mainNav.classList.toggle('active');
  menuToggle.classList.toggle('open');
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e){
    e.preventDefault();
    document.querySelector(this.getAttribute('href')).scrollIntoView({
      behavior: 'smooth'
    });
  });
});

// Optional: Hero text fade-in effect
window.addEventListener('DOMContentLoaded', () => {
  const heroText = document.querySelector('.hero-content, .subpage-hero-content');
  if(heroText){
    heroText.style.opacity = 0;
    setTimeout(() => { heroText.style.transition = 'opacity 1s'; heroText.style.opacity = 1; }, 200);
  }
});

