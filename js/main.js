// Moofar Website - Enhanced JavaScript Functionality

// ============================================
// Page Load Handler
// ============================================
window.addEventListener('load', function() {
  document.body.classList.add('loaded');
});

// ============================================
// Mobile Menu Toggle Function with ARIA
// ============================================
function toggleMenu() {
  const nav = document.getElementById('mainNav');
  const toggle = document.querySelector('.mobile-toggle');
  
  if (nav && toggle) {
    const isActive = nav.classList.toggle('active');
    
    // Update ARIA attributes
    toggle.setAttribute('aria-expanded', isActive);
    
    // Prevent body scroll when menu is open
    document.body.style.overflow = isActive ? 'hidden' : 'auto';
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
      if (nav.classList.contains('active')) {
        nav.classList.remove('active');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = 'auto';
      }
    }
  }
});

// ============================================
// Close Mobile Menu When Clicking on Links
// ============================================
document.addEventListener('DOMContentLoaded', function() {
  const navLinks = document.querySelectorAll('nav a');
  const nav = document.getElementById('mainNav');
  const toggle = document.querySelector('.mobile-toggle');
  
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (nav && nav.classList.contains('active')) {
        nav.classList.remove('active');
        if (toggle) {
          toggle.setAttribute('aria-expanded', 'false');
        }
        document.body.style.overflow = 'auto';
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
        // Smooth scroll to target
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
        
        // Set focus for accessibility
        target.setAttribute('tabindex', '-1');
        target.focus();
        
        // Close mobile menu
        const nav = document.getElementById('mainNav');
        const toggle = document.querySelector('.mobile-toggle');
        if (nav && nav.classList.contains('active')) {
          nav.classList.remove('active');
          if (toggle) {
            toggle.setAttribute('aria-expanded', 'false');
          }
          document.body.style.overflow = 'auto';
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
      link.setAttribute('aria-current', 'page');
    } else {
      link.classList.remove('active');
      link.removeAttribute('aria-current');
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
  
  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
}, { passive: true });

// ============================================
// Form Validation Utility
// ============================================
function isValidEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email);
}

function isValidPhone(phone) {
  // Botswana phone format (+267 XXX XXXXX)
  const phoneRegex = /^(\+267|267)?[\s]?[0-9]{3}[\s]?[0-9]{5}$/;
  return phoneRegex.test(phone);
}

// ============================================
// Handle Keyboard Navigation
// ============================================
document.addEventListener('keydown', function(event) {
  const nav = document.getElementById('mainNav');
  const toggle = document.querySelector('.mobile-toggle');
  
  // Close mobile menu on Escape key
  if (event.key === 'Escape') {
    if (nav && nav.classList.contains('active')) {
      nav.classList.remove('active');
      if (toggle) {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus(); // Return focus to toggle button
      }
      document.body.style.overflow = 'auto';
    }
  }
});

// ============================================
// Lazy Load Images (Performance Enhancement)
// ============================================
if ('IntersectionObserver' in window) {
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        if (img.dataset.src) {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
        }
        img.classList.add('loaded');
        observer.unobserve(img);
      }
    });
  }, {
    rootMargin: '50px 0px',
    threshold: 0.01
  });
  
  // Observe all images with data-src attribute
  document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
  });
}

// ============================================
// Animation on Scroll (Optional Enhancement)
// ============================================
if ('IntersectionObserver' in window) {
  const animateOnScroll = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
      }
    });
  }, {
    threshold: 0.1
  });
  
  // Apply to service cards, value cards, etc.
  document.querySelectorAll('.service-card, .value-card, .contact-card').forEach(el => {
    animateOnScroll.observe(el);
  });
}

// ============================================
// Performance Monitoring (Development Only)
// ============================================
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
  window.addEventListener('load', function() {
    if (window.performance) {
      const perfData = window.performance.timing;
      const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
      console.log('Page Load Time:', pageLoadTime + 'ms');
    }
  });
}

// ============================================
// Service Worker Registration (PWA)
// ============================================
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js')
      .then(registration => {
        console.log('ServiceWorker registration successful');
      })
      .catch(err => {
        console.log('ServiceWorker registration failed: ', err);
      });
  });
}
