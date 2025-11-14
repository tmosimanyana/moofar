// Main JavaScript for Moofar website
document.addEventListener('DOMContentLoaded', () => {
  console.log('🌿 Moofar main.js initializing...');

  // ===================================
  // NAVIGATION FUNCTIONALITY
  // ===================================
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');
  const navbar = document.getElementById('navbar');

  // Mobile menu toggle
  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', !isExpanded);
      navLinks.classList.toggle('active');
      menuToggle.classList.toggle('active');
    });

    // Close menu when clicking a link
    const navItems = navLinks.querySelectorAll('a');
    navItems.forEach(item => {
      item.addEventListener('click', () => {
        navLinks.classList.remove('active');
        if (menuToggle) {
          menuToggle.classList.remove('active');
          menuToggle.setAttribute('aria-expanded', 'false');
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!navbar.contains(e.target) && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
        menuToggle.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  // Navbar scroll effect
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    }, { passive: true });
  }

  // ===================================
  // SMOOTH SCROLLING FOR ANCHOR LINKS
  // ===================================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({
          behavior: 'smooth',
          block: 'start'
        });
      }
    });
  });

  // ===================================
  // CONTACT FORM HANDLING
  // ===================================
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    const successMessage = document.getElementById('successMessage');

    // Form validation
    function validateField(field) {
      const errorDiv = document.getElementById(`${field.id}Error`);
      if (!errorDiv) return true;

      let isValid = true;
      let errorMessage = '';

      if (field.hasAttribute('required') && !field.value.trim()) {
        isValid = false;
        errorMessage = 'This field is required';
      } else if (field.type === 'email' && field.value.trim()) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
          isValid = false;
          errorMessage = 'Please enter a valid email address';
        }
      }

      if (isValid) {
        field.classList.remove('error');
        errorDiv.textContent = '';
      } else {
        field.classList.add('error');
        errorDiv.textContent = errorMessage;
      }

      return isValid;
    }

    // Add blur validation to form fields
    const formFields = contactForm.querySelectorAll('input, select, textarea');
    formFields.forEach(field => {
      field.addEventListener('blur', () => validateField(field));
      field.addEventListener('input', () => {
        if (field.classList.contains('error')) {
          validateField(field);
        }
      });
    });

    // Form submission
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      // Validate all fields
      let isFormValid = true;
      formFields.forEach(field => {
        if (!validateField(field)) {
          isFormValid = false;
        }
      });

      if (!isFormValid) {
        return;
      }

      const submitButton = contactForm.querySelector('button[type="submit"]');
      const originalText = submitButton.textContent;
      submitButton.disabled = true;
      submitButton.textContent = 'Sending...';

      const formData = {
        name: contactForm.querySelector('#name').value,
        email: contactForm.querySelector('#email').value,
        phone: contactForm.querySelector('#phone').value || '',
        service: contactForm.querySelector('#service').value,
        message: contactForm.querySelector('#message').value,
      };

      try {
        const response = await fetch('/.netlify/functions/send-email', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(formData),
        });

        if (response.ok) {
          // Show success message
          if (successMessage) {
            successMessage.classList.add('show');
            setTimeout(() => {
              successMessage.classList.remove('show');
            }, 5000);
          }
          
          // Reset form
          contactForm.reset();
          
          // Remove any error states
          formFields.forEach(field => {
            field.classList.remove('error');
            const errorDiv = document.getElementById(`${field.id}Error`);
            if (errorDiv) errorDiv.textContent = '';
          });

          // Scroll to success message
          successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else {
          const errorData = await response.json();
          alert('Sorry, there was an error sending your message. Please try again or contact us directly at Mookfara@gmail.com');
          console.error('Form submission error:', errorData);
        }
      } catch (error) {
        alert('Sorry, there was an error sending your message. Please try again or contact us directly at Mookfara@gmail.com');
        console.error('Form submission error:', error);
      } finally {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
      }
    });
  }

  console.log('✅ Moofar main.js loaded successfully');
});