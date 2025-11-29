// Initialize Lucide Icons
lucide.createIcons();

// Data
const heroSlides = [
    "https://images.unsplash.com/photo-1558904541-efa843a96f01?w=1920&h=1080&fit=crop",
    "https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=1920&h=1080&fit=crop",
    "https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=1920&h=1080&fit=crop"
];

const services = [
    {
        image: "https://images.unsplash.com/photo-1558904541-efa843a96f01?w=800&h=600&fit=crop",
        title: "Landscaping",
        items: [
            "Landscape design, installation, and maintenance",
            "Lawn establishment & irrigation systems",
            "Hardscaping (pathways, paving, rock features)"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?w=800&h=600&fit=crop",
        title: "Horticulture Services",
        items: [
            "Cultivation and maintenance of gardens",
            "Nursery development and plant supply",
            "Tree planting, pruning, and disease control"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=800&h=600&fit=crop",
        title: "Bush Clearing & Environmental Management",
        items: [
            "Mechanical and manual bush clearing",
            "Land rehabilitation and maintenance",
            "Firebreaks and vegetation control"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=800&h=600&fit=crop",
        title: "Construction & Maintenance",
        items: [
            "Building construction and renovations",
            "Plumbing, electrical, roofing, painting",
            "Site preparation, fencing, and civil works"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=800&h=600&fit=crop",
        title: "General Services",
        items: [
            "Cleaning services (commercial & residential)",
            "Waste removal & site cleaning",
            "Labour hire and manpower supply"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=800&h=600&fit=crop",
        title: "Supply & Distribution",
        items: [
            "Procurement and delivery of materials",
            "Wholesale and retail supply services",
            "Tailored sourcing solutions"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800&h=600&fit=crop",
        title: "Consultancy & Business Support",
        items: [
            "Business advisory and administrative support",
            "Project management and strategic planning",
            "Office support services"
        ]
    },
    {
        image: "https://images.unsplash.com/photo-1566576721346-d4a3b4eaeb55?w=800&h=600&fit=crop",
        title: "Logistics & Transport",
        items: [
            "Efficient transportation of goods nationwide",
            "Fleet support and distribution planning",
            "Courier services and delivery management"
        ]
    }
];

const coreValues = [
    { icon: "users", title: "Customer Focus", desc: "Tailoring services to meet and exceed expectations" },
    { icon: "award", title: "Excellence", desc: "Committed to doing our best in every task" },
    { icon: "target", title: "Integrity", desc: "Honesty, fairness, and transparency in all relationships" },
    { icon: "globe", title: "Innovation", desc: "Bringing new ideas and improved solutions" }
];

// State
let activeSlide = 0;
let isMenuOpen = false;

// Initialize Hero Slider
function initHeroSlider() {
    const heroSlidesContainer = document.getElementById('heroSlides');
    const slideIndicators = document.getElementById('slideIndicators');
    
    // Create slides
    heroSlides.forEach((slide, index) => {
        const slideDiv = document.createElement('div');
        slideDiv.className = `absolute inset-0 transition-opacity duration-1000 ${
            index === activeSlide ? 'opacity-100' : 'opacity-0'
        }`;
        slideDiv.id = `slide-${index}`;
        slideDiv.style.backgroundImage = `url(${slide})`;
        slideDiv.style.backgroundSize = 'cover';
        slideDiv.style.backgroundPosition = 'center';
        
        const overlay = document.createElement('div');
        overlay.className = 'absolute inset-0 bg-black bg-opacity-40';
        slideDiv.appendChild(overlay);
        
        heroSlidesContainer.appendChild(slideDiv);
    });
    
    // Add hero text
    const heroContent = document.createElement('div');
    heroContent.className = 'relative h-full flex items-center justify-center text-center text-white px-4';
    heroContent.innerHTML = `
        <div class="max-w-4xl">
            <h2 class="text-4xl md:text-6xl font-bold mb-4">Innovative, Reliable, High-Quality Services</h2>
            <p class="text-xl md:text-2xl mb-8">Multi-disciplinary solutions for businesses and communities across Botswana</p>
        </div>
    `;
    heroSlidesContainer.appendChild(heroContent);
    
    // Create indicators
    heroSlides.forEach((_, index) => {
        const indicator = document.createElement('button');
        indicator.className = `w-3 h-3 rounded-full transition ${
            index === activeSlide ? 'bg-white' : 'bg-white bg-opacity-50'
        }`;
        indicator.onclick = () => goToSlide(index);
        slideIndicators.appendChild(indicator);
    });
    
    // Auto-rotate slides
    setInterval(() => {
        activeSlide = (activeSlide + 1) % heroSlides.length;
        updateSlider();
    }, 5000);
}

// Update slider display
function updateSlider() {
    // Update slides
    heroSlides.forEach((_, index) => {
        const slide = document.getElementById(`slide-${index}`);
        if (index === activeSlide) {
            slide.classList.remove('opacity-0');
            slide.classList.add('opacity-100');
        } else {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
        }
    });
    
    // Update indicators
    const indicators = document.querySelectorAll('#slideIndicators button');
    indicators.forEach((indicator, index) => {
        if (index === activeSlide) {
            indicator.classList.remove('bg-opacity-50');
            indicator.classList.add('bg-white');
        } else {
            indicator.classList.remove('bg-white');
            indicator.classList.add('bg-opacity-50');
        }
    });
}

// Go to specific slide
function goToSlide(index) {
    activeSlide = index;
    updateSlider();
}

// Initialize Services Grid
function initServices() {
    const servicesGrid = document.getElementById('servicesGrid');
    
    services.forEach(service => {
        const card = document.createElement('div');
        card.className = 'bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition border border-gray-200';
        
        card.innerHTML = `
            <div class="h-40 overflow-hidden">
                <img 
                    src="${service.image}" 
                    alt="${service.title}"
                    class="w-full h-full object-cover hover:scale-110 transition duration-500"
                />
            </div>
            <div class="p-5">
                <h4 class="text-lg font-bold mb-3 text-gray-800">${service.title}</h4>
                <ul class="space-y-1.5">
                    ${service.items.map(item => `
                        <li class="flex items-start text-sm text-gray-700">
                            <span class="text-green-600 mr-2 mt-0.5 text-xs">●</span>
                            <span>${item}</span>
                        </li>
                    `).join('')}
                </ul>
            </div>
        `;
        
        servicesGrid.appendChild(card);
    });
}

// Initialize Core Values
function initCoreValues() {
    const coreValuesContainer = document.getElementById('coreValues');
    
    coreValues.forEach(value => {
        const card = document.createElement('div');
        card.className = 'bg-white p-6 rounded-lg shadow-md text-center hover:shadow-xl transition';
        
        card.innerHTML = `
            <div class="text-green-600 mb-4 flex justify-center">
                <i data-lucide="${value.icon}" style="width: 40px; height: 40px;"></i>
            </div>
            <h4 class="font-bold text-lg mb-2 text-gray-800">${value.title}</h4>
            <p class="text-sm text-gray-600">${value.desc}</p>
        `;
        
        coreValuesContainer.appendChild(card);
    });
    
    // Re-render Lucide icons after adding new elements
    lucide.createIcons();
}

// Navigation
function setupNavigation() {
    const menuToggle = document.getElementById('menuToggle');
    const mobileNav = document.getElementById('mobileNav');
    const navLinks = document.querySelectorAll('.navLink');
    
    // Toggle mobile menu
    menuToggle.addEventListener('click', () => {
        isMenuOpen = !isMenuOpen;
        if (isMenuOpen) {
            mobileNav.classList.remove('hidden');
        } else {
            mobileNav.classList.add('hidden');
        }
    });
    
    // Navigate to sections
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const section = e.target.getAttribute('data-section');
            scrollToSection(section);
            isMenuOpen = false;
            mobileNav.classList.add('hidden');
        });
    });
}

// Scroll to section
function scrollToSection(id) {
    const element = document.getElementById(id);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
    }
}

// Contact Form
function setupContactForm() {
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = {
            name: form.querySelector('input[type="text"]').value,
            phone: form.querySelector('input[type="tel"]').value,
            email: form.querySelector('input[type="email"]').value,
            message: form.querySelector('textarea').value
        };
        
        // Log form submission (replace with actual backend call)
        console.log('Form submitted:', data);
        
        // Show success message
        alert('Thank you for contacting us! We will get back to you soon.');
        
        // Reset form
        form.reset();
    });
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    initHeroSlider();
    initServices();
    initCoreValues();
    setupNavigation();
    setupContactForm();
});