// main.js

// Inject header/navigation
document.getElementById('header-placeholder').innerHTML = `
<header>
    <nav class="main-nav">
        <div class="logo"><a href="index.html">Moofar</a></div>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="gallery.html">Gallery</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
    </nav>
</header>
`;

// Inject footer
document.getElementById('footer-placeholder').innerHTML = `
<footer>
    <div class="footer-content">
        <p>&copy; ${new Date().getFullYear()} Moofar Proprietary Limited. All rights reserved.</p>
        <p>
            <a href="privacy.html">Privacy Policy</a> |
            <a href="terms.html">Terms & Conditions</a>
        </p>
    </div>
</footer>
`;

// Optional: Highlight active link
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll('.nav-links a').forEach(link => {
    if(link.getAttribute('href') === currentPage) {
        link.classList.add('active');
    }
});
// Add your JavaScript here
console.log('Moofar loaded');