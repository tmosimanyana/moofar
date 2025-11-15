// ============================================
// MOBILE MENU FUNCTIONALITY
// Add this code to the bottom of js/components.js
// ============================================

// Mobile Menu Toggle - adds full functionality to hamburger menu
document.addEventListener('DOMContentLoaded', () => {
  // Wait a bit to ensure navigation is injected
  setTimeout(() => {
    const menuToggle = document.getElementById('menuToggle');
    const navLinks = document.getElementById('navLinks');
    const navbar = document.getElementById('navbar');

    if (!menuToggle || !navLinks) {
      console.warn('Menu elements not found');
      return;
    }

    // Toggle menu function
    function toggleMenu() {
      const isOpen = navLinks.classList.contains('active');
      
      if (isOpen) {
        // Close menu
        navLinks.classList.remove('active');
        menuToggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = ''; // Re-enable scrolling
      } else {
        // Open menu
        navLinks.classList.add('active');
        menuToggle.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
      }
    }

    // Click handler for hamburger button
    menuToggle.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleMenu();
    });

    // Close menu when clicking a link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        if (navLinks.classList.contains('active')) {
          toggleMenu();
        }
      });
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
      if (navLinks.classList.contains('active')) {
        if (!navLinks.contains(e.target) && !menuToggle.contains(e.target)) {
          toggleMenu();
        }
      }
    });

    // Close menu on escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && navLinks.classList.contains('active')) {
        toggleMenu();
        menuToggle.focus(); // Return focus to toggle button
      }
    });

    // Handle window resize - close menu if switching to desktop view
    let resizeTimer;
    window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(() => {
        if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
          toggleMenu();
        }
      }, 250);
    });

    // Animate hamburger icon
    menuToggle.addEventListener('click', function() {
      this.classList.toggle('active');
    });

    console.log('📱 Mobile menu initialized');
  }, 100);
});

// ============================================
// ENHANCED CSS FOR MOBILE MENU
// Add this to css/style.css in the mobile section
// ============================================

/*
// Hamburger animation
.menu-toggle.active span:nth-child(1) {
  transform: rotate(45deg) translate(5px, 5px);
}

.menu-toggle.active span:nth-child(2) {
  opacity: 0;
}

.menu-toggle.active span:nth-child(3) {
  transform: rotate(-45deg) translate(7px, -6px);
}

// Mobile menu improvements
@media (max-width: 768px) {
  .nav-links {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    bottom: 0;
    background: white;
    flex-direction: column;
    padding: 2rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: none;
    overflow-y: auto;
    animation: slideDown 0.3s ease-out;
  }

  .nav-links.active {
    display: flex;
  }

  .nav-links li {
    margin: 0;
    padding: 0;
  }

  .nav-links a {
    display: block;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
    font-size: 1.1rem;
  }

  .nav-links a:hover {
    background: var(--bg-light);
    padding-left: 1rem;
    transition: all 0.3s ease;
  }

  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
}
*/