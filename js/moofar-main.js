/**
 * moofar-main.js
 * Consolidated JS with accessibility and error handling
 */

(() => {
  'use strict';

  const SELECTORS = {
    menuToggle: '#menuToggle',
    navLinks: '#primaryNav',
    navbar: '#navbar',
    scrollThreshold: 100,
    contactForm: '#contactForm',
    submitBtn: '#submitBtn',
  };

  /* -------------------- MENU TOGGLE -------------------- */
  function initMenu() {
    try {
      const toggle = document.querySelector(SELECTORS.menuToggle);
      const nav = document.querySelector(SELECTORS.navLinks);
      if (!toggle || !nav) return;

      function setExpanded(expanded) {
        toggle.setAttribute('aria-expanded', String(expanded));
        if (expanded) nav.classList.add('active'); else nav.classList.remove('active');
      }

      toggle.addEventListener('click', (e) => {
        const expanded = toggle.getAttribute('aria-expanded') === 'true';
        setExpanded(!expanded);
      });

      // Close when clicking outside
      document.addEventListener('click', (e) => {
        if (!nav.classList.contains('active')) return;
        if (nav.contains(e.target) || toggle.contains(e.target)) return;
        setExpanded(false);
      });

      // Close on Escape
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') setExpanded(false);
      });

      // Ensure focus trap/keyboard nav works naturally via DOM order
    } catch (err) {
      console.error('initMenu error', err);
    }
  }

  /* -------------------- NAVBAR SCROLL EFFECT -------------------- */
  function initNavbarScroll() {
    try {
      const navbar = document.querySelector(SELECTORS.navbar);
      if (!navbar) return;
      window.addEventListener('scroll', () => {
        if (window.scrollY > SELECTORS.scrollThreshold) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      }, { passive: true });
    } catch (err) {
      console.error('initNavbarScroll error', err);
    }
  }

  /* -------------------- CONTACT FORM SUBMIT -------------------- */
  async function initContactForm() {
    try {
      const form = document.querySelector(SELECTORS.contactForm);
      if (!form) return;

      const submitBtn = form.querySelector(SELECTORS.submitBtn);

      form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (submitBtn) {
          submitBtn.disabled = true;
          submitBtn.dataset.orig = submitBtn.textContent;
          submitBtn.textContent = 'Sending...';
        }

        // Basic client-side validation (expand as needed)
        const name = form.querySelector('[name="name"]')?.value?.trim();
        const email = form.querySelector('[name="email"]')?.value?.trim();
        if (!name || !email) {
          alert('Please provide your name and email.');
          if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.orig || 'Send Message'; }
          return;
        }

        const payload = Object.fromEntries(new FormData(form));

        try {
          // Adjust endpoint to match your backend (Netlify function example)
          const resp = await fetch('/.netlify/functions/send-email', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
          });

          const result = await resp.json();
          if (resp.ok) {
            form.reset();
            alert('Message sent — thank you!');
          } else {
            throw new Error(result.error || 'Submission failed');
          }
        } catch (err) {
          console.error('Form submission error:', err);
          alert('There was an error sending your message. Please try again or contact us by phone.');
        } finally {
          if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = submitBtn.dataset.orig || 'Send Message'; }
        }
      });
    } catch (err) {
      console.error('initContactForm error', err);
    }
  }

  /* -------------------- INIT -------------------- */
  document.addEventListener('DOMContentLoaded', () => {
    initMenu();
    initNavbarScroll();
    initContactForm();
  });
})();
/**
 * Moofar Main Script — moofar-main.js
 * Handles responsive nav, scroll effect, and contact form
 */
(() => {
  'use strict';

  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('primaryNav');
  const navbar = document.getElementById('navbar');

  /* NAV MENU */
  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!expanded));
      navLinks.classList.toggle('active');
    });

    document.addEventListener('click', (e) => {
      if (!navLinks.classList.contains('active')) return;
      if (navLinks.contains(e.target) || menuToggle.contains(e.target)) return;
      menuToggle.setAttribute('aria-expanded', 'false');
      navLinks.classList.remove('active');
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        navLinks.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
      }
    });
  }

  /* SCROLL EFFECT */
  if (navbar) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 80) navbar.classList.add('scrolled');
      else navbar.classList.remove('scrolled');
    });
  }

  /* CONTACT FORM (if present) */
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    const submitBtn = contactForm.querySelector('#submitBtn');
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';
      }

      const data = Object.fromEntries(new FormData(contactForm));
      try {
        const resp = await fetch('/.netlify/functions/send-email', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(data),
        });
        if (resp.ok) {
          alert('Message sent successfully!');
          contactForm.reset();
        } else {
          throw new Error('Network error');
        }
      } catch (err) {
        alert('Error sending message. Please try again.');
        console.error(err);
      } finally {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Send Message';
        }
      }
    });
  }
})();

