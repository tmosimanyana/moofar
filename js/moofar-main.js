/**
 * moofar-main.js
 * Handles responsive nav, scroll effect, contact form, and accessibility
 */
(() => {
  'use strict';

  const SELECTORS = {
    menuToggle: '#menuToggle',
    navLinks: '#primaryNav',
    navbar: '#navbar',
    scrollThreshold: 80,
    contactForm: '#contactForm',
    submitBtn: '#submitBtn',
  };

  /* -------------------- MENU TOGGLE -------------------- */
  function initMenu() {
    const toggle = document.querySelector(SELECTORS.menuToggle);
    const nav = document.querySelector(SELECTORS.navLinks);
    if (!toggle || !nav) return;

    function setExpanded(expanded) {
      toggle.setAttribute('aria-expanded', String(expanded));
      nav.classList.toggle('active', expanded);
      if (!expanded) toggle.focus(); // return focus to toggle
    }

    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      setExpanded(!expanded);
    });

    document.addEventListener('click', (e) => {
      if (!nav.classList.contains('active')) return;
      if (nav.contains(e.target) || toggle.contains(e.target)) return;
      setExpanded(false);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') setExpanded(false);
    });
  }

  /* -------------------- NAVBAR SCROLL EFFECT -------------------- */
  function initNavbarScroll() {
    const navbar = document.querySelector(SELECTORS.navbar);
    if (!navbar) return;

    let ticking = false;
    window.addEventListener('scroll', () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          if (window.scrollY > SELECTORS.scrollThreshold) navbar.classList.add('scrolled');
          else navbar.classList.remove('scrolled');
          ticking = false;
        });
        ticking = true;
      }
    }, { passive: true });
  }

  /* -------------------- CONTACT FORM -------------------- */
  function initContactForm() {
    const form = document.querySelector(SELECTORS.contactForm);
    if (!form) return;

    const submitBtn = form.querySelector(SELECTORS.submitBtn);

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!submitBtn) return;

      submitBtn.disabled = true;
      submitBtn.dataset.orig = submitBtn.textContent;
      submitBtn.textContent = 'Sending...';

      const formData = Object.fromEntries(new FormData(form));

      if (!formData.name?.trim() || !formData.email?.trim()) {
        alert('Please provide your name and email.');
        submitBtn.disabled = false;
        submitBtn.textContent = submitBtn.dataset.orig;
        return;
      }

      try {
        const resp = await fetch('/.netlify/functions/send-email', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(formData),
        });

        if (resp.ok) {
          alert('Message sent successfully!');
          form.reset();
        } else {
          throw new Error('Submission failed');
        }
      } catch (err) {
        console.error(err);
        alert('Error sending message. Please try again.');
      } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = submitBtn.dataset.orig;
      }
    });
  }

  /* -------------------- SMOOTH SCROLL FOR SKIP LINK -------------------- */
  function initSkipLink() {
    const skipLink = document.querySelector('.skip-link');
    if (!skipLink) return;
    skipLink.addEventListener('click', (e) => {
      e.preventDefault();
      const target = document.querySelector(skipLink.getAttribute('href'));
      if (target) {
        target.setAttribute('tabindex', '-1');
        target.focus({ preventScroll: false });
        window.scrollTo({ top: target.offsetTop, behavior: 'smooth' });
      }
    });
  }

  /* -------------------- INIT -------------------- */
  document.addEventListener('DOMContentLoaded', () => {
    initMenu();
    initNavbarScroll();
    initContactForm();
    initSkipLink();
  });
})();

