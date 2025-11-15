/**
 * Contact Form with Web3Forms Backend
 * For Moofar Proprietary Limited
 * 
 * SETUP INSTRUCTIONS:
 * 1. Sign up at https://web3forms.com (free)
 * 2. Create a new form
 * 3. Copy your Access Key
 * 4. Replace 'YOUR_ACCESS_KEY_HERE' below with your actual key
 * 5. Upload this file to js/contact.js
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

    // ⚠️ IMPORTANT: Replace with your actual Web3Forms Access Key
    const WEB3FORMS_ACCESS_KEY = 'YOUR_ACCESS_KEY_HERE';

    // Validation functions
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        if (!phone) return true; // Phone is optional
        const re = /^[\d\s\+\-\(\)]+$/;
        return re.test(phone) && phone.replace(/\D/g, '').length >= 8;
    }

    function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + 'Error');
        if (field && errorDiv) {
            field.classList.add('error');
            errorDiv.textContent = message;
        }
    }

    function clearError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + 'Error');
        if (field && errorDiv) {
            field.classList.remove('error');
            errorDiv.textContent = '';
        }
    }

    function clearAllErrors() {
        ['name', 'email', 'phone', 'service', 'message'].forEach(clearError);
    }

    // Real-time validation on blur
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email && !validateEmail(email)) {
                showError('email', 'Please enter a valid email address');
            } else {
                clearError('email');
            }
        });
    }

    const phoneField = document.getElementById('phone');
    if (phoneField) {
        phoneField.addEventListener('blur', function() {
            const phone = this.value.trim();
            if (phone && !validatePhone(phone)) {
                showError('phone', 'Please enter a valid phone number');
            } else {
                clearError('phone');
            }
        });
    }

    // Form submission handler
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearAllErrors();
            
            // Check if access key is configured
            if (WEB3FORMS_ACCESS_KEY === 'YOUR_ACCESS_KEY_HERE') {
                alert('⚠️ Web3Forms access key not configured!\n\nPlease sign up at https://web3forms.com and update the access key in contact.js');
                console.error('Web3Forms access key not configured. Please update WEB3FORMS_ACCESS_KEY in contact.js');
                return;
            }
            
            let isValid = true;

            // Get form values
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const service = document.getElementById('service').value;
            const message = document.getElementById('message').value.trim();

            // Validate name
            if (!name || name.length < 2) {
                showError('name', 'Please enter your full name');
                isValid = false;
            }

            // Validate email
            if (!email) {
                showError('email', 'Email is required');
                isValid = false;
            } else if (!validateEmail(email)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }

            // Validate phone (optional but must be valid if provided)
            if (phone && !validatePhone(phone)) {
                showError('phone', 'Please enter a valid phone number');
                isValid = false;
            }

            // Validate service
            if (!service) {
                showError('service', 'Please select a service');
                isValid = false;
            }

            // Validate message
            if (!message || message.length < 10) {
                showError('message', 'Please enter a message (at least 10 characters)');
                isValid = false;
            }

            if (!isValid) {
                // Scroll to first error
                const firstError = document.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return;
            }

            // Disable submit button and show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : 'Send Message';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                submitBtn.style.opacity = '0.6';
                submitBtn.style.cursor = 'not-allowed';
            }

            // Prepare form data for Web3Forms
            const formData = new FormData();
            formData.append('access_key', WEB3FORMS_ACCESS_KEY);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone || 'Not provided');
            formData.append('service', service);
            formData.append('message', message);
            formData.append('subject', `New Contact Form Submission from ${name} - ${service}`);
            formData.append('from_name', 'Moofar Website');
            formData.append('redirect', 'https://web3forms.com/success');

            try {
                // Submit to Web3Forms
                const response = await fetch('https://api.web3forms.com/submit', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    // Show success message
                    if (successMessage) {
                        successMessage.classList.add('show');
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }

                    // Reset form
                    form.reset();

                    // Log success
                    console.log('✅ Form submitted successfully:', {
                        name,
                        email,
                        service,
                        timestamp: new Date().toISOString()
                    });

                    // Hide success message after 5 seconds
                    setTimeout(() => {
                        if (successMessage) {
                            successMessage.classList.remove('show');
                        }
                    }, 5000);

                } else {
                    throw new Error(data.message || 'Submission failed');
                }

            } catch (error) {
                console.error('❌ Form submission error:', error);
                
                // Show user-friendly error message
                alert(
                    '⚠️ There was an error sending your message.\n\n' +
                    'Please try one of these alternatives:\n' +
                    '• Call us: +267 77 723 232\n' +
                    '• Email: Mookfara@gmail.com\n' +
                    '• WhatsApp: Click the green button\n\n' +
                    'We apologize for the inconvenience!'
                );
            } finally {
                // Re-enable submit button
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                }
            }
        });
    }

    // Clear errors when user starts typing
    ['name', 'email', 'phone', 'message'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                if (this.value.trim()) {
                    clearError(fieldId);
                }
            });
        }
    });

    const serviceField = document.getElementById('service');
    if (serviceField) {
        serviceField.addEventListener('change', function() {
            if (this.value) {
                clearError('service');
            }
        });
    }

    console.log('📧 Contact form initialized with Web3Forms');
    
    // Remind developer to configure access key
    if (WEB3FORMS_ACCESS_KEY === 'YOUR_ACCESS_KEY_HERE') {
        console.warn('⚠️ Web3Forms access key not configured. Please update WEB3FORMS_ACCESS_KEY in contact.js');
    }
});