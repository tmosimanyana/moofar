// ============================================
// MOOFAR PTY LTD - MAIN JAVASCRIPT
// Premium Landscaping Services in Botswana
// ============================================

// ============================================
// MOBILE MENU TOGGLE
// ============================================
const menuToggle = document.getElementById('menuToggle');
const mainNav = document.getElementById('mainNav');

if (menuToggle && mainNav) {
  menuToggle.addEventListener('click', () => {
    mainNav.classList.toggle('open');
    menuToggle.classList.toggle('active');
    
    // Prevent body scroll when menu is open
    if (mainNav.classList.contains('open')) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = '';
    }
  });
}

// Close mobile menu when clicking outside
document.addEventListener('click', (e) => {
  if (menuToggle && mainNav && mainNav.classList.contains('open')) {
    if (!e.target.closest('.site-header')) {
      mainNav.classList.remove('open');
      menuToggle.classList.remove('active');
      document.body.style.overflow = '';
    }
  }
});

// Close mobile menu when window is resized to desktop
window.addEventListener('resize', () => {
  if (window.innerWidth > 768 && mainNav && mainNav.classList.contains('open')) {
    mainNav.classList.remove('open');
    if (menuToggle) {
      menuToggle.classList.remove('active');
    }
    document.body.style.overflow = '';
  }
});

// ============================================
// SMOOTH SCROLLING FOR ANCHOR LINKS
// ============================================
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    
    // Don't prevent default for # or #! links
    if (href === '#' || href === '#!') return;
    
    e.preventDefault();
    const target = document.querySelector(href);
    
    if (target) {
      // Close mobile menu if open
      if (mainNav && mainNav.classList.contains('open')) {
        mainNav.classList.remove('open');
        if (menuToggle) menuToggle.classList.remove('active');
        document.body.style.overflow = '';
      }
      
      // Scroll to target
      const headerOffset = 80;
      const elementPosition = target.getBoundingClientRect().top;
      const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
      
      window.scrollTo({
        top: offsetPosition,
        behavior: 'smooth'
      });
    }
  });
});

// ============================================
// SCROLL REVEAL ANIMATION
// ============================================
const observerOptions = {
  threshold: 0.1,
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

// Apply animation to specific elements when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  const animateElements = document.querySelectorAll(
    '.service-item, .project-card, .team-member, .testimonial, ' +
    '.why-feature, .service-card, .stat-item, .benefit-card, ' +
    '.faq-list details, .gallery-item'
  );
  
  animateElements.forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
    revealObserver.observe(el);
  });
});

// ============================================
// STICKY HEADER ENHANCEMENT
// ============================================
let lastScroll = 0;
const header = document.querySelector('.site-header');

window.addEventListener('scroll', () => {
  const currentScroll = window.pageYOffset;
  
  if (header) {
    // Add shadow when scrolled
    if (currentScroll > 100) {
      header.style.boxShadow = '0 4px 30px rgba(18, 30, 15, 0.15)';
    } else {
      header.style.boxShadow = '0 2px 20px rgba(18, 30, 15, 0.08)';
    }
  }
  
  lastScroll = currentScroll;
});

// ============================================
// FORM VALIDATION
// ============================================
const forms = document.querySelectorAll('form');

forms.forEach(form => {
  form.addEventListener('submit', (e) => {
    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
    let isValid = true;
    
    // Clear previous errors
    form.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    inputs.forEach(input => {
      if (!input.value.trim()) {
        isValid = false;
        input.style.borderColor = '#dc2626';
        
        // Show error message if error span exists
        const errorEl = form.querySelector(`#${input.id}Error`);
        if (errorEl) {
          errorEl.textContent = 'This field is required';
        }
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
        
        const errorEl = form.querySelector(`#${input.id}Error`);
        if (errorEl) {
          errorEl.textContent = 'Please enter a valid email address';
        }
      }
    });
    
    // Phone validation (optional - if phone input exists)
    const phoneInputs = form.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
      if (input.value) {
        const phonePattern = /^[+]?[\d\s()-]{8,}$/;
        if (!phonePattern.test(input.value)) {
          isValid = false;
          input.style.borderColor = '#dc2626';
          
          const errorEl = form.querySelector(`#${input.id}Error`);
          if (errorEl) {
            errorEl.textContent = 'Please enter a valid phone number';
          }
        }
      }
    });
    
    if (!isValid) {
      e.preventDefault();
      
      // Scroll to first error
      const firstError = form.querySelector('input[style*="border-color: rgb(220, 38, 38)"]');
      if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstError.focus();
      }
    }
  });
  
  // Clear error styling on input
  const formInputs = form.querySelectorAll('input, textarea, select');
  formInputs.forEach(input => {
    input.addEventListener('input', function() {
      this.style.borderColor = '#e5e5e5';
      const errorEl = form.querySelector(`#${this.id}Error`);
      if (errorEl) {
        errorEl.textContent = '';
      }
    });
  });
});

// ============================================
// LIGHTBOX FOR GALLERY (if gallery page exists)
// ============================================
function initGalleryLightbox() {
  const galleryItems = document.querySelectorAll('.gallery-item');
  
  if (galleryItems.length === 0) return;
  
  // Create lightbox HTML
  const lightbox = document.createElement('div');
  lightbox.className = 'lightbox';
  lightbox.id = 'lightbox';
  lightbox.setAttribute('aria-hidden', 'true');
  lightbox.innerHTML = `
    <div class="lightbox-content">
      <button class="lightbox-close" onclick="closeLightbox()" aria-label="Close lightbox">×</button>
      <img id="lightboxImg" src="" alt="">
      <div class="lightbox-info">
        <h3 id="lightboxTitle"></h3>
        <p id="lightboxDesc"></p>
      </div>
    </div>
  `;
  document.body.appendChild(lightbox);
  
  // Add click handlers to gallery items
  galleryItems.forEach((item, index) => {
    item.style.cursor = 'pointer';
    item.addEventListener('click', () => {
      const img = item.querySelector('img');
      const caption = item.querySelector('figcaption');
      
      if (img) {
        document.getElementById('lightboxImg').src = img.src;
        document.getElementById('lightboxImg').alt = img.alt;
        
        if (caption) {
          document.getElementById('lightboxTitle').textContent = caption.textContent;
        }
        
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }
    });
  });
  
  // Close on background click
  lightbox.addEventListener('click', (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });
}

function closeLightbox() {
  const lightbox = document.getElementById('lightbox');
  if (lightbox) {
    lightbox.classList.remove('active');
    lightbox.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }
}

// Close lightbox on Escape key
document.addEventListener('keydown', (e) => {
  if (e.key === 'Escape') {
    closeLightbox();
  }
});

// Initialize lightbox when DOM is ready
document.addEventListener('DOMContentLoaded', initGalleryLightbox);

// ============================================
// FAQ ACCORDION TRACKING (for analytics)
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  const faqItems = document.querySelectorAll('.faq-list details');
  
  faqItems.forEach(item => {
    item.addEventListener('toggle', function() {
      if (this.open) {
        // Close other FAQs (optional - for accordion effect)
        // Uncomment below if you want only one FAQ open at a time
        /*
        faqItems.forEach(otherItem => {
          if (otherItem !== this && otherItem.open) {
            otherItem.open = false;
          }
        });
        */
        
        // You can track which FAQ was opened for analytics
        console.log('FAQ opened:', this.querySelector('summary').textContent);
      }
    });
  });
});

// ============================================
// CONTACT FORM SUBMISSION (if contact page)
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  const contactForm = document.getElementById('contactForm');
  const successMessage = document.getElementById('successMessage');
  
  if (contactForm && successMessage) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Get form data
      const formData = new FormData(contactForm);
      const data = Object.fromEntries(formData);
      
      // In production, you would send this to your server
      // For now, just show success message
      console.log('Form submitted:', data);
      
      // Show success message
      successMessage.style.display = 'block';
      contactForm.reset();
      
      // Scroll to success message
      successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      
      // Hide success message after 8 seconds
      setTimeout(() => {
        successMessage.style.display = 'none';
      }, 8000);
      
      // Here you would typically send the form data to your server:
      /*
      try {
        const response = await fetch('/api/contact', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data)
        });
        
        if (response.ok) {
          successMessage.style.display = 'block';
          contactForm.reset();
        } else {
          alert('There was an error sending your message. Please try again.');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('There was an error sending your message. Please try again.');
      }
      */
    });
  }
});

// ============================================
// PERFORMANCE: LAZY LOADING IMAGES
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  const images = document.querySelectorAll('img[data-src]');
  
  const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        imageObserver.unobserve(img);
      }
    });
  });
  
  images.forEach(img => imageObserver.observe(img));
});

// ============================================
// STATS COUNTER ANIMATION (for homepage stats)
// ============================================
function animateCounter(element, target, duration = 2000) {
  const start = 0;
  const increment = target / (duration / 16);
  let current = start;
  
  const timer = setInterval(() => {
    current += increment;
    if (current >= target) {
      element.textContent = target + (element.dataset.suffix || '');
      clearInterval(timer);
    } else {
      element.textContent = Math.floor(current) + (element.dataset.suffix || '');
    }
  }, 16);
}

// Initialize counter animation when stats come into view
document.addEventListener('DOMContentLoaded', () => {
  const statNumbers = document.querySelectorAll('.stat-number');
  
  if (statNumbers.length > 0) {
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const target = entry.target;
          const value = parseInt(target.textContent);
          
          if (!isNaN(value) && !target.dataset.animated) {
            target.dataset.animated = 'true';
            target.dataset.suffix = target.textContent.replace(/[0-9]/g, '');
            animateCounter(target, value, 2000);
          }
          
          statsObserver.unobserve(target);
        }
      });
    }, { threshold: 0.5 });
    
    statNumbers.forEach(stat => statsObserver.observe(stat));
  }
});

// ============================================
// CONSOLE MESSAGE (Development only - remove in production)
// ============================================
console.log('%cMoofar Pty Ltd', 'font-size: 24px; color: #2d5016; font-weight: bold;');
console.log('%cPremium Landscaping Services in Botswana', 'font-size: 14px; color: #6b8e23;');
console.log('%cWebsite loaded successfully ✓', 'color: #8fbc8f;');
