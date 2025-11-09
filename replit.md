# Moofar Proprietary Limited Website

## Overview
This is a professional website for Moofar Proprietary Limited, a premium landscaping and horticultural services company based in Francistown, Botswana.

## Project Structure
- **Frontend**: Static HTML/CSS/JS website
- **Backend**: Node.js server with SendGrid email integration
- **Deployment**: Configured for both Replit and Netlify

## Key Files
- `server.js` - Local development server (serves static files and handles email endpoint)
- `netlify/functions/send-email.js` - Serverless function for email handling on Netlify
- `js/components.js` - Shared navigation and footer components
- `js/main.js` - Interactive features (menu toggle, form submission)
- `css/style.css` - Main stylesheet

## Environment Variables Required

### SENDGRID_API_KEY
The SendGrid API key is required for the contact form email functionality.
- Get this from SendGrid dashboard at https://app.sendgrid.com/settings/api_keys
- Used to send confirmation emails to users and notification emails to admins

### Email Configuration
- **Sender**: hello@moofar.co.bw
- **Admin Recipients**: Mookfara@gmail.com, farai.admin@moofar.co.bw

## Development Setup
1. Install dependencies: `npm install`
2. Set environment variable: `SENDGRID_API_KEY`
3. Run server: `npm start`
4. Access at: http://localhost:5000

## Deployment

### Replit
- Workflow: `web-server` (npm start)
- Port: 5000
- Deployment target: autoscale

### Netlify
- Publish directory: `.` (root)
- Functions directory: `netlify/functions`
- Build command: None (static site)

## Design Theme
The website features a modern, professional design with:
- **Color Palette**: Rich emerald greens (#16a34a, #059669) with teal accents
- **Gradients**: Smooth linear gradients for hero sections, buttons, and cards
- **Animations**: Subtle hover effects, transitions, and micro-interactions
- **Typography**: Modern font stack with smooth letter-spacing
- **Components**: Elevated cards with shadows, rounded corners, and interactive states
- **Buttons**: Ripple effects and elevation changes on hover
- **Responsive**: Fully mobile-optimized with adaptive layouts

## Recent Changes (Nov 9, 2025)
- **Initial Setup**: Imported from GitHub repository
- **Server Configuration**: Created Node.js server for local development
- **Interactive Features**: Added main.js for menu toggle and form handling
- **Deployment Setup**: Configured Replit workflow and Netlify deployment
- **Documentation**: Created netlify.toml and .gitignore
- **Visual Enhancements**: Modernized CSS theme with:
  - Enhanced color palette and gradient system
  - Smooth animations and hover effects on all interactive elements
  - Improved button styles with ripple effects
  - Enhanced service card designs with icon animations
  - Modern form input styling with focus states
  - Polished navigation with gradient logo
  - Animated hero section with subtle zoom effect

## Contact Information
- **Director**: Mooketsi Mapugwa
- **Manager**: Farai Madorobo
- **Location**: Francistown, Botswana
- **Email**: Mookfara@gmail.com
- **Phone**: +267 77 723 232, +267 77 085 655
