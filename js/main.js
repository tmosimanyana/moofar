// Moofar Website - Complete JavaScript Functionality

// ============================================
// Mobile Menu Toggle Function
// ============================================
function toggleMenu() {
  const nav = document.getElementById('mainNav');
  if (nav) {
    nav.classList.toggle('active');
  }
}

// ============================================
// Close Mobile Menu When Clicking Outside
// ============================================
document.addEventListener('click', function(event) {
  const nav = document.getElementById('mainNav');
  const toggle = document.querySelector('.mobile-toggle');
  
  if (nav && toggle) {
    // Check if click is outside both nav and toggle button
    if (!nav.contains(event.target) && !toggle.contains(event.target)) {
      nav.classList.remove('active');
    }
  }
});

// ============================================
// Close Mobile Menu When Clicking on Links
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('nav a');
  const nav = document.getElementById('mainNav');
  
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (nav) {
        nav.classList.remove('active');
      }
    });
  });
});

// ============================================
// Smooth Scroll for Anchor Links
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function(e) {
    const href = this.getAttribute('href');
    
    if (href !== '#' && href !== '') {
      e.preventDefault();
      const target = document.querySelector(href);
      
      if (target) {
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
        
        // Close mobile menu
        const nav = document.getElementById('mainNav');
        if (nav) {
          nav.classList.remove('active');
        }
      }
    }
  });
});

// ============================================
// Active Navigation Link Highlighting
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  const currentPage = window.location.pathname.split('/').pop() || 'index.html';
  const navLinks = document.querySelectorAll('nav a');
  
  navLinks.forEach(link => {
    const linkPage = link.getAttribute('href');
    
    // Highlight current page
    if (linkPage === currentPage || (currentPage === '' && linkPage === 'index.html')) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });
});

// ============================================
// Add Scroll Effect to Header
// ============================================
let lastScrollTop = 0;
const header = document.querySelector('header');

window.addEventListener('scroll', function() {
  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  
  if (scrollTop > 50) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
  
  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
});

// ============================================
// Form Validation Utility (for contact forms)
// ============================================
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

// ============================================
// Prevent body scroll when mobile menu is open
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  const nav = document.getElementById('mainNav');
  const toggle = document.querySelector('.mobile-toggle');
  
  if (toggle) {
    const originalToggle = toggle.onclick;
    
    toggle.addEventListener('click', function() {
      if (nav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = 'auto';
      }
    });
  }
  
  // Also restore scroll on outside clicks
  document.addEventListener('click', function(event) {
    if (nav && toggle) {
      if (!nav.contains(event.target) && !toggle.contains(event.target)) {
        document.body.style.overflow = 'auto';
      }
    }
  });
});

// ============================================
// Lazy Load Images (Performance Enhancement)
// ============================================
if ('IntersectionObserver' in window) {
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src || img.src;
        img.classList.add('loaded');
        observer.unobserve(img);
      }
    });
  });
  
  document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
  });
}

// ============================================
// Smooth Fade In on Page Load
// ============================================
window.addEventListener('load', function() {
  document.body.style.opacity = '1';
});

// ============================================
// Handle Keyboard Navigation
// ============================================
document.addEventListener('keydown', function(event) {
  // Close mobile menu on Escape key
  if (event.key === 'Escape') {
    const nav = document.getElementById('mainNav');
    if (nav && nav.classList.contains('active')) {
      nav.classList.remove('active');
      document.body.style.overflow = 'auto';
    }
  }
});
