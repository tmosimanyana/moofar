// Inject header/footer
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


document.getElementById('footer-placeholder').innerHTML = `
<footer>
<p>&copy; ${new Date().getFullYear()} Moofar Proprietary Limited. All rights reserved.</p>
<p><a href="privacy.html">Privacy Policy</a> | <a href="terms.html">Terms & Conditions</a></p>
</footer>
`;


// Active link highlight
const currentPage = window.location.pathname.split("/").pop();
document.querySelectorAll('.nav-links a').forEach(link => { if(link.getAttribute('href') === currentPage) link.classList.add('active'); });


// Before/After Slider
document.querySelectorAll('[data-before-after]').forEach(slider => {
const beforeImageUrl = slider.getAttribute('data-before-image');
const afterImageUrl = slider.getAttribute('data-after-image');
const beforeLabel = slider.getAttribute('data-before-label') || 'Before';
const afterLabel = slider.getAttribute('data-after-label') || 'After';


const afterDiv = document.createElement('div');
afterDiv.classList.add('after-image');
afterDiv.style.backgroundImage = `url(${afterImageUrl})`;


const beforeDiv = document.createElement('div');
beforeDiv.classList.add('before-image');
beforeDiv.style.backgroundImage = `url(${beforeImageUrl})`;


const beforeText = document.createElement('span'); beforeText.textContent = beforeLabel; beforeText.style.left = '10px';
const afterText = document.createElement('span'); afterText.textContent = afterLabel; afterText.style.right = '10px';
const handle = document.createElement('div'); handle.classList.add('handle');


slider.appendChild(afterDiv);
slider.appendChild(beforeDiv);
slider.appendChild(beforeText);
slider.appendChild(afterText);
slider.appendChild(handle);


let isDragging = false;
});

