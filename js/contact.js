// Contact Form with Web3Forms Backend
// Sign up at https://web3forms.com and replace YOUR_ACCESS_KEY_HERE

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

    // ⚠️ REPLACE WITH YOUR WEB3FORMS ACCESS KEY
    const WEB3FORMS_ACCESS_KEY = 'YOUR_ACCESS_KEY_HERE';

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        if (!phone) return true;
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

    // Real-time validation
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

    // Form submission
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            clearAllErrors();
            
            if (WEB3FORMS_ACCESS_KEY === 'YOUR_ACCESS_KEY_HERE') {
                alert('⚠️ Contact form not configured!\n\nPlease sign up at https://web3forms.com\nand update the access key in js/contact.js');
                return;
            }
            
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const service = document.getElementById('service').value;
            const message = document.getElementById('message').value.trim();

            // Validate
            if (!name || name.length < 2) {
                showError('name', 'Please enter your full name');
                isValid = false;
            }

            if (!email) {
                showError('email', 'Email is required');
                isValid = false;
            } else if (!validateEmail(email)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }

            if (phone && !validatePhone(phone)) {
                showError('phone', 'Please enter a valid phone number');
                isValid = false;
            }

            if (!service) {
                showError('service', 'Please select a service');
                isValid = false;
            }

            if (!message || message.length < 10) {
                showError('message', 'Please enter a message (at least 10 characters)');
                isValid = false;
            }

            if (!isValid) {
                const firstError = document.querySelector('.error');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return;
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : 'Send Message';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Sending...';
                submitBtn.style.opacity = '0.6';
            }

            const formData = new FormData();
            formData.append('access_key', WEB3FORMS_ACCESS_KEY);
            formData.append('name', name);
            formData.append('email', email);
            formData.append('phone', phone || 'Not provided');
            formData.append('service', service);
            formData.append('message', message);
            formData.append('subject', `New Contact Form - ${name} - ${service}`);
            formData.append('from_name', 'Moofar Website');

            try {
                const response = await fetch('https://api.web3forms.com/submit', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    if (successMessage) {
                        successMessage.classList.add('show');
                        successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    form.reset();
                    setTimeout(() => {
                        if (successMessage) successMessage.classList.remove('show');
                    }, 5000);
                } else {
                    throw new Error(data.message || 'Submission failed');
                }
            } catch (error) {
                console.error('Form error:', error);
                alert('Error sending message. Please call +267 77 723 232 or email Mookfara@gmail.com');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    submitBtn.style.opacity = '1';
                }
            }
        });
    }

    // Clear errors on input
    ['name', 'email', 'phone', 'message'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('input', function() {
                if (this.value.trim()) clearError(fieldId);
            });
        }
    });

    const serviceField = document.getElementById('service');
    if (serviceField) {
        serviceField.addEventListener('change', function() {
            if (this.value) clearError('service');
        });
    }

    console.log('📧 Contact form initialized');
});
