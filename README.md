# Moofar Proprietary Limited - Website

Professional landscaping and horticultural services website for Moofar Pty Ltd, based in Francistown, Botswana.

## 📋 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [Technologies](#technologies)
- [Setup Instructions](#setup-instructions)
- [Page Descriptions](#page-descriptions)
- [Customization Guide](#customization-guide)
- [Browser Support](#browser-support)
- [Contributing](#contributing)
- [License](#license)

## 🌿 Overview

This is a modern, responsive website for Moofar Proprietary Limited, showcasing their landscaping, horticultural nursery, bush clearing, and fencing services. The site features:
- Interactive before/after image sliders
- Filterable image gallery
- Contact form with validation
- Mobile-responsive design
- Accessibility features

**Company Details:**
- **Director:** Mooketsi Mapugwa
- **Manager:** Farai Madorobo
- **UIN:** BW00009410484
- **Location:** Francistown, Botswana

## ✨ Features

- **Responsive Design**: Works on all devices (desktop, tablet, mobile)
- **Before/After Slider**: Interactive image comparison tool
- **Gallery System**: Filterable project gallery with lightbox
- **Contact Form**: Client-side validation with user feedback
- **Accessibility**: WCAG compliant with skip links, ARIA labels, keyboard navigation
- **SEO Optimized**: Proper meta tags and semantic HTML
- **Modern CSS**: CSS Grid, Flexbox, custom properties
- **Smooth Animations**: Transitions and hover effects

## 📁 Project Structure

```
moofar/
├── index.html                 # Homepage with hero and services overview
├── services.html              # Detailed services page
├── about.html                 # Company information and team
├── gallery.html               # Project gallery with filters
├── contact.html               # Contact form and information
├── css/
│   ├── style.css             # Main stylesheet (USE THIS ONE)
│   ├── before-after-css.css  # Before/after slider styles
│   ├── showcase_css.css      # Additional showcase styles
│   └── styles.css            # Legacy (can be removed)
├── js/
│   ├── components.js         # Reusable nav/footer components
│   ├── before-after-slider.js # Interactive slider functionality
│   ├── gallery.js            # Gallery filtering and lightbox
│   ├── contact.js            # Contact form validation
│   └── main.js               # Legacy (can be removed)
├── images/                    # Image assets (add your images here)
├── LICENSE                    # MIT License
└── README.md                  # This file
```

## 🛠️ Technologies

- **HTML5**: Semantic markup
- **CSS3**: Modern layouts (Grid, Flexbox), animations, custom properties
- **JavaScript (ES6+)**: Vanilla JS, no framework dependencies
- **Google Maps Embed**: Location mapping
- **Unsplash**: Placeholder images (replace with your own)

## 🚀 Setup Instructions

### Basic Setup (No Server Required)

1. **Clone or download the repository:**
   ```bash
   git clone https://github.com/tmosimanyana/moofar.git
   cd moofar
   ```

2. **Open in browser:**
   - Simply open `index.html` in your web browser
   - Or use VS Code Live Server extension for development

### File Cleanup (Recommended)

Remove conflicting/legacy files:
```bash
# Remove old CSS file
rm css/styles.css

# Remove old JS file  
rm js/main.js
```

### Adding Your Images

Replace placeholder images with your own:

1. **Create images directory:**
   ```bash
   mkdir -p images
   ```

2. **Add your images:**
   - For before/after slider: `images/before1.jpg`, `images/after1.jpg`
   - For gallery: Update `galleryData` array in `js/gallery.js`

3. **Update image paths in:**
   - `index.html` (before/after slider)
   - `js/gallery.js` (gallery images)

### Optional: Local Development Server

For better development experience:

```bash
# Using Python 3
python -m http.server 8000

# Using Node.js (http-server)
npx http-server -p 8000

# Using PHP
php -S localhost:8000
```

Then visit: `http://localhost:8000`

## 📄 Page Descriptions

### index.html (Homepage)
- Hero section with call-to-action
- Before/after transformation slider
- Services overview cards
- Why choose us features
- Call-to-action section

### services.html
- Detailed service descriptions
- Four main service categories
- Our approach process
- Call-to-action

### about.html
- Company story and mission
- Leadership team introduction
- Why choose Moofar section
- Features and strengths

### gallery.html
- Filterable project gallery
- Categories: All, Landscaping, Residential, Commercial, Fencing
- Lightbox for full-size viewing
- Keyboard and touch navigation

### contact.html
- Contact form with validation
- Company contact information
- Google Maps integration
- Business hours

## 🎨 Customization Guide

### Colors

Edit CSS custom properties in `css/style.css`:

```css
:root {
  --primary-green: #16a34a;        /* Main brand color */
  --primary-green-dark: #15803d;   /* Darker shade */
  --primary-green-light: #22c55e;  /* Lighter shade */
  /* ... more colors ... */
}
```

### Content Updates

1. **Company Information**: Update in `js/components.js` (footer)
2. **Services**: Edit `services.html`
3. **Gallery Images**: Update `galleryData` array in `js/gallery.js`
4. **Contact Details**: Update `contact.html`

### Adding New Pages

1. Create new HTML file
2. Include the header/footer placeholders:
   ```html
   <div id="header-placeholder"></div>
   <!-- Your content -->
   <div id="footer-placeholder"></div>
   <script src="js/components.js"></script>
   ```

## 🌐 Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

**Note**: Internet Explorer is not supported.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature-name`
3. Make your changes
4. Test thoroughly
5. Commit: `git commit -m 'Add feature description'`
6. Push: `git push origin feature-name`
7. Open a Pull Request

## 📝 To-Do / Improvements

- [ ] Add actual project images to replace Unsplash placeholders
- [ ] Implement backend for contact form (PHP, Node.js, or third-party service)
- [ ] Add testimonials section
- [ ] Create blog/news section
- [ ] Add more before/after comparison sets
- [ ] Implement image lazy loading optimization
- [ ] Add analytics tracking
- [ ] Create sitemap.xml and robots.txt
- [ ] Optimize images for web (compress, WebP format)
- [ ] Add social media integration

## 📞 Support

For questions or issues with the website:
- **Email**: Mookfara@gmail.com
- **Phone**: +267 77 723 232 / +267 77 085 655

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

**Built with 💚 for Moofar Proprietary Limited**

*Last Updated: November 2025*
