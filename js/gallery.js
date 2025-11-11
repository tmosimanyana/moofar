// Gallery data - Add descriptions and categories for each image
const galleryData = [
    {
        src: 'images/gallery1.svg',
        title: 'Residential Garden Design',
        category: 'residential landscaping',
        description: 'Modern residential garden with native plants'
    },
    {
        src: 'images/gallery4.webp',
        title: 'Commercial Landscape',
        category: 'commercial landscaping',
        description: 'Professional commercial landscaping project'
    },
    {
        src: 'images/gallery10.webp',
        title: 'Garden Installation',
        category: 'residential landscaping',
        description: 'Complete garden installation with irrigation'
    },
    {
        src: 'images/gallery12.webp',
        title: 'Outdoor Living Space',
        category: 'residential landscaping',
        description: 'Custom outdoor living area with paving'
    },
    {
        src: 'images/gallery13.webp',
        title: 'Commercial Property',
        category: 'commercial landscaping',
        description: 'Large-scale commercial property landscaping'
    },
    {
        src: 'images/gallery14.svg',
        title: 'Fence Installation',
        category: 'fencing residential',
        description: 'Professional fence installation service'
    },
    {
        src: 'images/gallery17.webp',
        title: 'Landscape Design',
        category: 'landscaping residential',
        description: 'Creative landscape design implementation'
    },
    {
        src: 'images/gallery18.webp',
        title: 'Garden Maintenance',
        category: 'residential landscaping',
        description: 'Regular garden maintenance services'
    },
    {
        src: 'images/gallery20.png',
        title: 'Commercial Fencing',
        category: 'fencing commercial',
        description: 'Security fencing for commercial property'
    },
    {
        src: 'images/gallery20.webp',
        title: 'Property Development',
        category: 'commercial landscaping',
        description: 'Complete property development landscaping'
    },
    {
        src: 'images/gallery21.webp',
        title: 'Residential Fencing',
        category: 'fencing residential',
        description: 'Custom residential fence design'
    },
    {
        src: 'images/gallery22.jpg',
        title: 'Landscape Project',
        category: 'landscaping commercial',
        description: 'Professional landscape project completion'
    },
    {
        src: 'images/gallery23.jpg',
        title: 'Garden Design',
        category: 'residential landscaping',
        description: 'Beautiful residential garden design'
    },
    {
        src: 'images/gallery23.webp',
        title: 'Commercial Installation',
        category: 'commercial landscaping',
        description: 'Commercial landscaping installation'
    }
];

// Current filter and lightbox state
let currentFilter = 'all';
let currentImageIndex = 0;
let filteredImages = [];

// Initialize gallery when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeGallery();
    setupFilterButtons();
    setupLightbox();
});

// Initialize and render gallery
function initializeGallery() {
    filteredImages = galleryData;
    renderGallery();
}

// Render gallery items
function renderGallery() {
    const galleryGrid = document.getElementById('galleryGrid');
    
    if (!galleryGrid) return;
    
    galleryGrid.innerHTML = '';
    
    filteredImages.forEach((item, index) => {
        const galleryItem = document.createElement('div');
        galleryItem.className = 'gallery-item';
        galleryItem.setAttribute('data-category', item.category);
        
        galleryItem.innerHTML = `
            <img src="${item.src}" alt="${item.title}" loading="lazy">
            <div class="gallery-item-overlay">
                <h3>${item.title}</h3>
                <p>${item.description}</p>
            </div>
        `;
        
        // Add click event to open lightbox
        galleryItem.addEventListener('click', () => openLightbox(index));
        
        galleryGrid.appendChild(galleryItem);
    });
}

// Setup filter button functionality
function setupFilterButtons() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Get filter value
            const filter = this.getAttribute('data-filter');
            currentFilter = filter;
            
            // Filter images
            filterGallery(filter);
        });
    });
}

// Filter gallery based on category
function filterGallery(filter) {
    if (filter === 'all') {
        filteredImages = galleryData;
    } else {
        filteredImages = galleryData.filter(item => 
            item.category.includes(filter)
        );
    }
    
    renderGallery();
}

// Setup lightbox functionality
function setupLightbox() {
    const lightbox = document.getElementById('lightbox');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    
    // Close lightbox
    lightboxClose.addEventListener('click', closeLightbox);
    
    // Close lightbox when clicking outside image
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
    
    // Previous image
    lightboxPrev.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex - 1 + filteredImages.length) % filteredImages.length;
        updateLightboxImage();
    });
    
    // Next image
    lightboxNext.addEventListener('click', () => {
        currentImageIndex = (currentImageIndex + 1) % filteredImages.length;
        updateLightboxImage();
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            lightboxPrev.click();
        } else if (e.key === 'ArrowRight') {
            lightboxNext.click();
        }
    });
}

// Open lightbox with specific image
function openLightbox(index) {
    currentImageIndex = index;
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
    updateLightboxImage();
}

// Close lightbox
function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = ''; // Restore scrolling
}

// Update lightbox image and caption
function updateLightboxImage() {
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const currentImage = filteredImages[currentImageIndex];
    
    lightboxImg.src = currentImage.src;
    lightboxImg.alt = currentImage.title;
    lightboxCaption.innerHTML = `
        <h3>${currentImage.title}</h3>
        <p>${currentImage.description}</p>
    `;
    
    // Show/hide navigation buttons based on number of images
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    
    if (filteredImages.length <= 1) {
        lightboxPrev.style.display = 'none';
        lightboxNext.style.display = 'none';
    } else {
        lightboxPrev.style.display = 'block';
        lightboxNext.style.display = 'block';
    }
}
