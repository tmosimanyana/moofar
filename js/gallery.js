// Gallery data
const galleryData = [
    { id: 1, category: 'residential', title: 'Residential Garden Design', description: 'Modern garden with native plants', img: 'https://images.unsplash.com/photo-1558904541-efa843a96f01?w=600&h=450&fit=crop' },
    { id: 2, category: 'commercial', title: 'Commercial Landscaping', description: 'Office park beautification', img: 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=600&h=450&fit=crop' },
    { id: 3, category: 'landscaping', title: 'Land Clearing Project', description: 'Large plot preparation', img: 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=600&h=450&fit=crop' },
    { id: 4, category: 'residential', title: 'Garden Renovation', description: 'Complete backyard transformation', img: 'https://images.unsplash.com/photo-1623947237634-bb50e8a57b2c?w=600&h=450&fit=crop' },
    { id: 5, category: 'fencing', title: 'Wooden Fence Installation', description: 'Decorative perimeter fencing', img: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&h=450&fit=crop' },
    { id: 6, category: 'landscaping', title: 'Irrigation System Setup', description: 'Automated watering solution', img: 'https://images.unsplash.com/photo-1603231788467-6de185c8b1dd?w=600&h=450&fit=crop' },
    { id: 7, category: 'commercial', title: 'Hotel Grounds Maintenance', description: 'Ongoing landscape care', img: 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600&h=450&fit=crop' },
    { id: 8, category: 'residential', title: 'Native Plant Garden', description: 'Sustainable indigenous planting', img: 'https://images.unsplash.com/photo-1560525821-d5615ef80c69?w=600&h=450&fit=crop' },
    { id: 9, category: 'fencing', title: 'Security Fencing', description: 'Steel perimeter protection', img: 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=600&h=450&fit=crop' },
];

let currentFilter = 'all';
let currentLightboxIndex = 0;
let filteredGallery = [];

// Render gallery
function renderGallery(filter = 'all') {
    const grid = document.getElementById('galleryGrid');
    if (!grid) return;

    filteredGallery = filter === 'all' 
        ? galleryData 
        : galleryData.filter(item => item.category === filter);
    
    grid.innerHTML = filteredGallery.map((item, index) => `
        <div class="gallery-item" data-index="${index}" data-category="${item.category}">
            <img src="${item.img}" alt="${item.title}">
            <div class="gallery-overlay">
                <h3>${item.title}</h3>
                <p>${item.description}</p>
            </div>
        </div>
    `).join('');

    // Add click listeners
    document.querySelectorAll('.gallery-item').forEach(item => {
        item.addEventListener('click', () => {
            openLightbox(parseInt(item.dataset.index));
        });
    });
}

// Filter functionality
function initializeFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilter = btn.dataset.filter;
            renderGallery(currentFilter);
        });
    });
}

// Lightbox functions
const lightbox = document.getElementById('lightbox');
const lightboxImg = document.getElementById('lightboxImg');
const lightboxCaption = document.getElementById('lightboxCaption');
const lightboxClose = document.getElementById('lightboxClose');
const lightboxPrev = document.getElementById('lightboxPrev');
const lightboxNext = document.getElementById('lightboxNext');

function openLightbox(index) {
    currentLightboxIndex = index;
    updateLightbox();
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

function updateLightbox() {
    const item = filteredGallery[currentLightboxIndex];
    lightboxImg.src = item.img;
    lightboxImg.alt = item.title;
    lightboxCaption.textContent = item.title;
}

function nextImage() {
    currentLightboxIndex = (currentLightboxIndex + 1) % filteredGallery.length;
    updateLightbox();
}

function prevImage() {
    currentLightboxIndex = (currentLightboxIndex - 1 + filteredGallery.length) % filteredGallery.length;
    updateLightbox();
}

// Initialize gallery when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Only run if we're on the gallery page
    if (!document.getElementById('galleryGrid')) return;

    renderGallery();
    initializeFilters();

    // Lightbox event listeners
    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxNext) lightboxNext.addEventListener('click', nextImage);
    if (lightboxPrev) lightboxPrev.addEventListener('click', prevImage);

    if (lightbox) {
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (!lightbox || !lightbox.classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowRight') nextImage();
        if (e.key === 'ArrowLeft') prevImage();
    });

    console.log('🖼️ Gallery initialized');
});