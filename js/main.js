// ============================================
// MOOFAR (PTY) LTD - ENHANCED JAVASCRIPT
// Mobile menu, form validation, smooth scroll
// ============================================

(function() {
  'use strict';

  // ============================================
  // MOBILE MENU TOGGLE
  // ============================================
  function initMobileMenu() {
    const button = document.querySelector('.mobile-toggle');
    const nav = document.getElementById('mainNav');
    
    if (!button || !nav) return;

    function toggleMenu() {
      nav.classList.toggle('open');
      const expanded = nav.classList.contains('open');
      button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
      
      // Update button text/icon
      button.textContent = expanded ? '✕' : '☰';
      
      // Prevent body scroll when menu is open
      document.body.style.overflow = expanded ? 'hidden' : '';
    }

    // Click handler
    button.addEventListener('click', toggleMenu);

    // Close menu on Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        toggleMenu();
        button.focus();
      }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (nav.classList.contains('open') && 
          !nav.contains(e.target) && 
          !button.contains(e.target)) {
        toggleMenu();
      }
    });

    // Close menu on window resize if larger than mobile
    window.addEventListener('resize', function() {
      if (window.innerWidth > 768 && nav.classList.contains('open')) {
        toggleMenu();
      }
    });

    // Close menu when clicking on nav links
    const navLinks = nav.querySelectorAll('a');
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        if (nav.classList.contains('open')) {
          toggleMenu();
        }
      });
    });
  }

  // ============================================
  // CONTACT FORM VALIDATION
  // ============================================
  function initFormValidation() {
    const form = document.getElementById('contactForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
      let isValid = true;
      const errors = [];

      // Get form fields
      const name = document.getElementById('name');
      const email = document.getElementById('email');
      const phone = document.getElementById('phone');
      const service = document.getElementById('service');
      const message = document.getElementById('message');

      // Clear previous error states
      clearErrors();

      // Validate name
      if (name && name.value.trim().length < 2) {
        isValid = false;
        errors.push('Please enter a valid name (at least 2 characters)');
        markFieldError(name);
      }

      // Validate email
      if (email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email.value.trim())) {
          isValid = false;
          errors.push('Please enter a valid email address');
          markFieldError(email);
        }
      }

      // Validate phone (optional but if provided, should be valid)
      if (phone && phone.value.trim() !== '') {
        const phonePattern = /^[\d\s\+\-\(\)]{8,}$/;
        if (!phonePattern.test(phone.value.trim())) {
          isValid = false;
          errors.push('Please enter a valid phone number');
          markFieldError(phone);
        }
      }

      // Validate service selection
      if (service && service.value === '') {
        isValid = false;
        errors.push('Please select a service');
        markFieldError(service);
      }

      // Validate message
      if (message && message.value.trim().length < 10) {
        isValid = false;
        errors.push('Please enter a message (at least 10 characters)');
        markFieldError(message);
      }

      // If form is invalid, prevent submission and show errors
      if (!isValid) {
        e.preventDefault();
        showErrors(errors);
        return false;
      }

      // Show loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.textContent = 'Sending...';
        submitBtn.disabled = true;
      }
    });

    function markFieldError(field) {
      field.style.borderColor = '#e53e3e';
      field.setAttribute('aria-invalid', 'true');
    }

    function clearErrors() {
      const fields = form.querySelectorAll('input, select, textarea');
      fields.forEach(field => {
        field.style.borderColor = '';
        field.removeAttribute('aria-invalid');
      });

      // Remove existing error message
      const existingError = form.querySelector('.form-error-message');
      if (existingError) {
        existingError.remove();
      }
    }

    function showErrors(errors) {
      const errorDiv = document.createElement('div');
      errorDiv.className = 'form-error-message';
      errorDiv.style.cssText = `
        background-color: #fed7d7;
        color: #742a2a;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        border: 1px solid #fc8181;
      `;
      
      const errorList = document.createElement('ul');
      errorList.style.cssText = 'margin: 0; padding-left: 1.5rem;';
      
      errors.forEach(error => {
        const li = document.createElement('li');
        li.textContent = error;
        errorList.appendChild(li);
      });
      
      errorDiv.appendChild(errorList);
      form.insertBefore(errorDiv, form.firstChild);

      // Scroll to error message
      errorDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
  }

  // ============================================
  // SMOOTH SCROLL FOR ANCHOR LINKS
  // ============================================
  function initSmoothScroll() {
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    
    anchorLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        
        // Skip if it's just "#"
        if (href === '#') {
          e.preventDefault();
          return;
        }

        const target = document.querySelector(href);
        if (target) {
          e.preventDefault();
          
          const headerOffset = 80;
          const elementPosition = target.getBoundingClientRect().top;
          const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

          window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
          });

          // Update focus for accessibility
          target.setAttribute('tabindex', '-1');
          target.focus();
        }
      });
    });
  }

  // ============================================
  // HEADER SCROLL EFFECT
  // ============================================
  function initHeaderScroll() {
    const header = document.querySelector('header');
    if (!header) return;

    let lastScroll = 0;

    window.addEventListener('scroll', function() {
      const currentScroll = window.pageYOffset;

      // Add shadow when scrolled
      if (currentScroll > 50) {
        header.style.boxShadow = '0 4px 16px rgba(0, 0, 0, 0.12)';
      } else {
        header.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.08)';
      }

      lastScroll = currentScroll;
    });
  }

  // ============================================
  // LAZY LOADING IMAGES (if not using native loading="lazy")
  // ============================================
  function initLazyLoading() {
    const images = document.querySelectorAll('img:not([loading="lazy"])');
    
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            if (img.dataset.src) {
              img.src = img.dataset.src;
              img.removeAttribute('data-src');
            }
            imageObserver.unobserve(img);
          }
        });
      });

      images.forEach(img => {
        if (img.dataset.src) {
          imageObserver.observe(img);
        }
      });
    }
  }

  // ============================================
  // ANIMATE ON SCROLL
  // ============================================
  function initScrollAnimations() {
    const elements = document.querySelectorAll('.service-card, .value-card, .team-member, .contact-card');
    
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '0';
            entry.target.style.transform = 'translateY(20px)';
            entry.target.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            
            setTimeout(() => {
              entry.target.style.opacity = '1';
              entry.target.style.transform = 'translateY(0)';
            }, 100);
            
            observer.unobserve(entry.target);
          }
        });
      }, {
        threshold: 0.1
      });

      elements.forEach(el => observer.observe(el));
    }
  }

  // ============================================
  // INITIALIZE ALL FUNCTIONS
  // ============================================
  function init() {
    // Add loaded class to body
    document.body.classList.add('loaded');

    // Initialize all features
    initMobileMenu();
    initFormValidation();
    initSmoothScroll();
    initHeaderScroll();
    initLazyLoading();
    initScrollAnimations();

    // Log initialization (remove in production)
    console.log('Moofar website initialized successfully');
  }

  // ============================================
  // RUN ON DOM READY
  // ============================================
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
