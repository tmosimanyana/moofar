// Contact Form Validation and Submission Handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

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
        field.classList.add('error');
        errorDiv.textContent = message;
    }

    function clearError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorDiv = document.getElementById(fieldId + 'Error');
        field.classList.remove('error');
        errorDiv.textContent = '';
    }

    function clearAllErrors() {
        ['name', 'email', 'phone', 'service', 'message'].forEach(clearError);
    }

    // Real-time validation
    document.getElementById('email').addEventListener('blur', function() {
        const email = this.value.trim();
        if (email && !validateEmail(email)) {
            showError('email', 'Please enter a valid email address');
        } else {
            clearError('email');
        }
    });

    document.getElementById('phone').addEventListener('blur', function() {
        const phone = this.value.trim();
        if (phone && !validatePhone(phone)) {
            showError('phone', 'Please enter a valid phone number');
        } else {
            clearError('phone');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        clearAllErrors();
        
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

        if (isValid) {
            // In a real application, you would send this data to a server
            // For now, we'll just show a success message
            
            console.log('Form submitted:', {
                name,
                email,
                phone,
                service,
                message,
                timestamp: new Date().toISOString()
            });

            // Show success message
            successMessage.classList.add('show');
            form.reset();

            // Scroll to success message
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

            // Hide success message after 5 seconds
            setTimeout(() => {
                successMessage.classList.remove('show');
            }, 5000);

            // In production, you would do something like:
            /*
            fetch('/api/contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ name, email, phone, service, message })
            })
            .then(response => response.json())
            .then(data => {
                successMessage.classList.add('show');
                form.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error sending your message. Please try again or call us directly.');
            });
            */
        } else {
            // Scroll to first error
            const firstError = document.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });

    // Clear errors when user starts typing
    ['name', 'email', 'phone', 'message'].forEach(fieldId => {
        document.getElementById(fieldId).addEventListener('input', function() {
            if (this.value.trim()) {
                clearError(fieldId);
            }
        });
    });

    document.getElementById('service').addEventListener('change', function() {
        if (this.value) {
            clearError('service');
        }
    });

    console.log('📧 Contact form initialized');
});