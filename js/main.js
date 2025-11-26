document.addEventListener('DOMContentLoaded', function() {
  const button = document.querySelector('.mobile-toggle');
  const nav = document.getElementById('mainNav');

  function toggleMenu() {
    nav.classList.toggle('open');
    const expanded = nav.classList.contains('open');
    button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
  }

  if (button) {
    button.addEventListener('click', toggleMenu);
    // allow Escape to close nav
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        toggleMenu();
        button.focus();
      }
    });
  }
});
