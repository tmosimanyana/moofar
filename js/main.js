// Moofar Proprietary Limited - Main JavaScript

// ============================================
// MOBILE MENU TOGGLE
// ============================================
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

if (menuToggle && mainNav) {
  menuToggle.addEventListener('click', () => {
    mainNav.classList.toggle('open');
    // Change icon
    menuToggle.textContent = mainNav.classList.contains('open') ? '✕' : '☰';
    // Prevent body scroll when menu is open
    document.body.style.overflow = mainNav.classList.contains('open') ? 'hidden' : '';
  });
}

// ============================================
// SMOOTH SCROLLING FOR ANCHOR LINKS
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (href !== '#' && href !== '#!') {
      e.preventDefault();
      const target = document.querySelector(href);
      if (target) {
        target.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'start' 
        });
        // Close mobile menu if open
        if (mainNav && mainNav.classList.contains('open')) {
          mainNav.classList.remove('open');
          if (menuToggle) menuToggle.textContent = '☰';
          document.body.style.overflow = '';
        }
      }
    }
  });
});

// ============================================
// SCROLL REVEAL ANIMATION
// ============================================
const observerOptions = {
  threshold: 0.15,
  rootMargin: '0px 0px -50px 0px'
};

const revealObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = '1';
      entry.target.style.transform = 'translateY(0)';
      revealObserver.unobserve(entry.target);
    }
  });
}, observerOptions);

// Apply animation to specific elements
document.querySelectorAll('.service-item, .project-card, .team-member, .testimonial, .why-feature, .service-card').forEach(el => {
  el.style.opacity = '0';
  el.style.transform = 'translateY(20px)';
  el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
  revealObserver.observe(el);
});

// ============================================
// CLOSE MOBILE MENU WHEN CLICKING OUTSIDE
// ============================================
document.addEventListener('click', (e) => {
  if (menuToggle && mainNav && mainNav.classList.contains('open')) {
    // Check if click is outside header
    if (!e.target.closest('header')) {
      mainNav.classList.remove('open');
      menuToggle.textContent = '☰';
      document.body.style.overflow = '';
    }
  }
});

// ============================================
// CLOSE MOBILE MENU ON WINDOW RESIZE
// ============================================
window.addEventListener('resize', () => {
  if (window.innerWidth > 768 && mainNav && mainNav.classList.contains('open')) {
    mainNav.classList.remove('open');
    if (menuToggle) {
      menuToggle.textContent = '☰';
    }
    document.body.style.overflow = '';
  }
});

// ============================================
// STICKY HEADER ENHANCEMENT (Optional)
// ============================================
let lastScroll = 0;
const header = document.querySelector('.lawnella-header');

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  if (currentScroll > 100) {
    header.style.boxShadow = '0 4px 30px rgba(18, 30, 15, 0.15)';
  } else {
    header.style.boxShadow = '0 2px 20px rgba(18, 30, 15, 0.08)';
  }
  
  lastScroll = currentScroll;
});

// ============================================
// FORM VALIDATION HELPER (if forms exist)
// ============================================
const forms = document.querySelectorAll('form');
forms.forEach(form => {
  form.addEventListener('submit', (e) => {
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    let isValid = true;
    
    inputs.forEach(input => {
      if (!input.value.trim()) {
        isValid = false;
        input.style.borderColor = '#dc2626';
      } else {
        input.style.borderColor = '#e5e5e5';
      }
    });
    
    // Email validation
    const emailInputs = form.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (input.value && !emailPattern.test(input.value)) {
        isValid = false;
        input.style.borderColor = '#dc2626';
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      alert('Please fill in all required fields correctly.');
    }
  });
});

// ============================================
// CONSOLE LOG (Development only - remove in production)
// ============================================
console.log('Moofar Landscaping - Website loaded successfully');