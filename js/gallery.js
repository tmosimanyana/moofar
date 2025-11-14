// Gallery data - Images with descriptions and categories
const galleryData = [
    {
        src: 'https://images.unsplash.com/photo-1558904541-efa843a96f01?w=800&h=600&fit=crop',
        title: 'Residential Garden Design',
        category: 'residential landscaping',
        description: 'Modern residential garden with native plants'
    },
    {
        src: 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=800&h=600&fit=crop',
        title: 'Commercial Landscape',
        category: 'commercial landscaping',
        description: 'Professional commercial landscaping project'
    },
    {
        src: 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=600&fit=crop',
        title: 'Garden Installation',
        category: 'residential landscaping',
        description: 'Complete garden installation with irrigation'
    },
    {
        src: 'https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=800&h=600&fit=crop',
        title: 'Outdoor Living Space',
        category: 'residential landscaping',
        description: 'Custom outdoor living area with paving'
    },
    {
        src: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800&h=600&fit=crop',
        title: 'Commercial Property',
        category: 'commercial landscaping',
        description: 'Large-scale commercial property landscaping'
    },
    {
        src: 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?w=800&h=600&fit=crop',
        title: 'Fence Installation',
        category: 'fencing residential',
        description: 'Professional fence installation service'
    },
    {
        src: 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800&h=600&fit=crop',
        title: 'Landscape Design',
        category: 'landscaping residential',
        description: 'Creative landscape design implementation'
    },
    {
        src: 'https://images.unsplash.com/photo-1600585154526-990dced4db0d?w=800&h=600&fit=crop',
        title: 'Garden Maintenance',
        category: 'residential landscaping',
        description: 'Regular garden maintenance services'
    },
    {
        src: 'https://images.unsplash.com/photo-1600607687644-c7171b42498b?w=800&h=600&fit=crop',
        title: 'Commercial Fencing',
        category: 'fencing commercial',
        description: 'Security fencing for commercial property'
    },
    {
        src: 'https://images.unsplash.com/photo-1600566752355-35792bedcfea?w=800&h=600&fit=crop',
        title: 'Property Development',
        category: 'commercial landscaping',
        description: 'Complete property development landscaping'
    },
    {
        src: 'https://images.unsplash.com/photo-1600585154363-67eb9e2e2099?w=800&h=600&fit=crop',
        title: 'Residential Fencing',
        category: 'fencing residential',
        description: 'Custom residential fence design'
    },
    {
        src: 'https://images.unsplash.com/photo-1600585152915-d208bec867a1?w=800&h=600&fit=crop',
        title: 'Landscape Project',
        category: 'landscaping commercial',
        description: 'Professional landscape project completion'
    }
];

// Gallery functionality
document.addEventListener('DOMContentLoaded', function() {
    const galleryGrid = document.getElementById('galleryGrid');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');

    let currentImageIndex = 0;
    let currentFilter = 'all';
    let filteredData = galleryData;

    // Render gallery items
    function renderGallery(data) {
        galleryGrid.innerHTML = '';
        
        data.forEach((item, index) => {
            const galleryItem = document.createElement('div');
            galleryItem.className = 'gallery-item';
            galleryItem.setAttribute('data-index', index);
            galleryItem.setAttribute('data-category', item.category);
            
            galleryItem.innerHTML = `
                <img src="${item.src}" alt="${item.title}" loading="lazy">
                <div class="gallery-overlay">
                    <h3>${item.title}</h3>
                    <p>${item.description}</p>
                </div>
            `;
            
            galleryItem.addEventListener('click', () => openLightbox(index));
            galleryGrid.appendChild(galleryItem);
        });
    }

    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Get filter value
            const filter = this.getAttribute('data-filter');
            currentFilter = filter;
            
            // Filter data
            if (filter === 'all') {
                filteredData = galleryData;
            } else {
                filteredData = galleryData.filter(item => 
                    item.category.includes(filter)
                );
            }
            
            // Re-render gallery
            renderGallery(filteredData);
        });
    });

    // Lightbox functionality
    function openLightbox(index) {
        currentImageIndex = index;
        updateLightboxImage();
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }

    function updateLightboxImage() {
        const item = filteredData[currentImageIndex];
        lightboxImg.src = item.src;
        lightboxImg.alt = item.title;
        lightboxCaption.innerHTML = `
            <strong>${item.title}</strong><br>
            ${item.description}
        `;
    }

    function showPrevImage() {
        currentImageIndex = (currentImageIndex - 1 + filteredData.length) % filteredData.length;
        updateLightboxImage();
    }

    function showNextImage() {
        currentImageIndex = (currentImageIndex + 1) % filteredData.length;
        updateLightboxImage();
    }

    // Event listeners
    lightboxClose.addEventListener('click', closeLightbox);
    lightboxPrev.addEventListener('click', showPrevImage);
    lightboxNext.addEventListener('click', showNextImage);

    // Close on background click
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowLeft') {
            showPrevImage();
        } else if (e.key === 'ArrowRight') {
            showNextImage();
        }
    });

    // Touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    lightbox.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    });

    lightbox.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchEndX < touchStartX - swipeThreshold) {
            showNextImage();
        }
        if (touchEndX > touchStartX + swipeThreshold) {
            showPrevImage();
        }
    }

    // Initial render
    renderGallery(galleryData);
    console.log('🖼️ Gallery initialized with', galleryData.length, 'images');
});