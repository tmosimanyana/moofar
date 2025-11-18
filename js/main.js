// ===== MOOFAR PTY LTD - MAIN JAVASCRIPT =====

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  
  // ===== MOBILE MENU TOGGLE =====
  const menuToggle = document.getElementById('menuToggle');
  const mainNav = document.getElementById('mainNav');
  
  if (menuToggle && mainNav) {
    menuToggle.addEventListener('click', function() {
      mainNav.classList.toggle('active');
      menuToggle.classList.toggle('open');
      
      // Prevent body scroll when menu is open on mobile
      if (mainNav.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    });

    // Close menu when clicking on a nav link
    const navLinks = mainNav.querySelectorAll('a');
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
          mainNav.classList.remove('active');
          menuToggle.classList.remove('open');
          document.body.style.overflow = '';
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
      const isClickInsideNav = mainNav.contains(event.target);
      const isClickOnToggle = menuToggle.contains(event.target);
      
      if (!isClickInsideNav && !isClickOnToggle && mainNav.classList.contains('active')) {
        mainNav.classList.remove('active');
        menuToggle.classList.remove('open');
        document.body.style.overflow = '';
      }
    });
  }

  // ===== SMOOTH SCROLL FOR ANCHOR LINKS =====
  const anchorLinks = document.querySelectorAll('a[href^="#"]');
  
  anchorLinks.forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const href = this.getAttribute('href');
      
      // Skip if it's just "#" or empty
      if (href === '#' || href === '') return;
      
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
      }
    });
  });

  // ===== HEADER SCROLL EFFECT =====
  const header = document.querySelector('.site-header');
  let lastScroll = 0;
  
  window.addEventListener('scroll', function() {
    const currentScroll = window.pageYOffset;
    
    // Add shadow on scroll
    if (currentScroll > 10) {
      header.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
    } else {
      header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.05)';
    }
    
    lastScroll = currentScroll;
  });

  // ===== HERO CONTENT FADE-IN ANIMATION =====
  const heroContent = document.querySelector('.hero-content, .about-hero, .subpage-hero-content');
  
  if (heroContent) {
    heroContent.style.opacity = '0';
    heroContent.style.transform = 'translateY(30px)';
    
    setTimeout(() => {
      heroContent.style.transition = 'opacity 1s ease-out, transform 1s ease-out';
      heroContent.style.opacity = '1';
      heroContent.style.transform = 'translateY(0)';
    }, 100);
  }

  // ===== INTERSECTION OBSERVER FOR SCROLL ANIMATIONS =====
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
  };

  const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);

  // Observe service items
  const serviceItems = document.querySelectorAll('.service-item');
  serviceItems.forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(30px)';
    item.style.transition = `opacity 0.6s ease-out ${index * 0.1}s, transform 0.6s ease-out ${index * 0.1}s`;
    observer.observe(item);
  });

  // Observe section headers
  const sectionHeaders = document.querySelectorAll('.section-header');
  sectionHeaders.forEach(header => {
    header.style.opacity = '0';
    header.style.transform = 'translateY(30px)';
    header.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
    observer.observe(header);
  });

  // ===== FORM VALIDATION (Contact Form) =====
  const contactForm = document.querySelector('.contact-form form');
  
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      const name = this.querySelector('input[name="name"]');
      const email = this.querySelector('input[name="email"]');
      const phone = this.querySelector('input[name="phone"]');
      const message = this.querySelector('textarea[name="message"]');
      
      let isValid = true;
      
      // Basic validation
      if (name && name.value.trim().length < 2) {
        alert('Please enter a valid name');
        name.focus();
        e.preventDefault();
        return false;
      }
      
      if (email && !isValidEmail(email.value)) {
        alert('Please enter a valid email address');
        email.focus();
        e.preventDefault();
        return false;
      }
      
      if (phone && phone.value.trim().length < 8) {
        alert('Please enter a valid phone number');
        phone.focus();
        e.preventDefault();
        return false;
      }
      
      if (message && message.value.trim().length < 10) {
        alert('Please enter a message (at least 10 characters)');
        message.focus();
        e.preventDefault();
        return false;
      }
      
      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.textContent = 'Sending...';
        submitBtn.disabled = true;
      }
    });
  }

  // Email validation helper
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }

  // ===== WHATSAPP BUTTON TRACKING =====
  const whatsappButtons = document.querySelectorAll('a[href*="wa.me"]');
  
  whatsappButtons.forEach(button => {
    button.addEventListener('click', function() {
      console.log('WhatsApp button clicked:', this.textContent);
      // You can add analytics tracking here
    });
  });

  // ===== PHONE BUTTON TRACKING =====
  const phoneButtons = document.querySelectorAll('a[href^="tel:"]');
  
  phoneButtons.forEach(button => {
    button.addEventListener('click', function() {
      console.log('Phone button clicked:', this.href);
      // You can add analytics tracking here
    });
  });

  // ===== LAZY LOADING IMAGES (if not using native loading="lazy") =====
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

  // ===== BUTTON RIPPLE EFFECT =====
  const buttons = document.querySelectorAll('.btn');
  
  buttons.forEach(button => {
    button.addEventListener('click', function(e) {
      const ripple = document.createElement('span');
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      const x = e.clientX - rect.left - size / 2;
      const y = e.clientY - rect.top - size / 2;
      
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = x + 'px';
      ripple.style.top = y + 'px';
      ripple.classList.add('ripple');
      
      this.appendChild(ripple);
      
      setTimeout(() => ripple.remove(), 600);
    });
  });

  // ===== BACK TO TOP BUTTON (Optional) =====
  // Uncomment if you want to add a back-to-top button
  /*
  const backToTopBtn = document.createElement('button');
  backToTopBtn.innerHTML = '↑';
  backToTopBtn.className = 'back-to-top';
  backToTopBtn.setAttribute('aria-label', 'Back to top');
  document.body.appendChild(backToTopBtn);
  
  window.addEventListener('scroll', () => {
    if (window.pageYOffset > 500) {
      backToTopBtn.classList.add('show');
    } else {
      backToTopBtn.classList.remove('show');
    }
  });
  
  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  */

  // ===== CONSOLE LOG =====
  console.log('🌳 Moofar Pty Ltd Website Loaded Successfully');
  console.log('📞 Contact: +267 77 723 232');
  console.log('📍 Location: Francistown, Botswana');

});

// ===== WINDOW RESIZE HANDLER =====
let resizeTimer;
window.addEventListener('resize', function() {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
    // Reset mobile menu on desktop view
    if (window.innerWidth > 768) {
      const mainNav = document.getElementById('mainNav');
      const menuToggle = document.getElementById('menuToggle');
      
      if (mainNav && menuToggle) {
        mainNav.classList.remove('active');
        menuToggle.classList.remove('open');
        document.body.style.overflow = '';
      }
    }
  }, 250);
});

// ===== PREVENT RIGHT CLICK ON IMAGES (Optional - for image protection) =====
// Uncomment if needed
/*
document.querySelectorAll('img').forEach(img => {
  img.addEventListener('contextmenu', e => {
    e.preventDefault();
    return false;
  });
});
*/
