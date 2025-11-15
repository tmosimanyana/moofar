/**
 * CONTACT FORM BACKEND SOLUTIONS FOR MOOFAR
 * Choose ONE of the following options based on your needs
 */

// ============================================
// OPTION 1: Web3Forms (RECOMMENDED - Easiest)
// ============================================
// No server required, free tier available, spam protection included
// Sign up at: https://web3forms.com

// Replace your contact.js file with this:

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contactForm');
    const successMessage = document.getElementById('successMessage');

    // Get your access key from https://web3forms.com
    const WEB3FORMS_ACCESS_KEY = 'YOUR_ACCESS_KEY_HERE'; // Replace this!

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

    // Form submission with Web3Forms
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearAllErrors();
        
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

        // Disable submit button
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Sending...';

        // Prepare form data
        const formData = new FormData();
        formData.append('access_key', WEB3FORMS_ACCESS_KEY);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone || 'Not provided');
        formData.append('service', service);
        formData.append('message', message);
        formData.append('subject', `New Contact Form Submission from ${name}`);
        formData.append('from_name', 'Moofar Website');

        try {
            const response = await fetch('https://api.web3forms.com/submit', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                successMessage.classList.add('show');
                form.reset();
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });

                setTimeout(() => {
                    successMessage.classList.remove('show');
                }, 5000);
            } else {
                throw new Error(data.message || 'Submission failed');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('There was an error sending your message. Please try calling us directly at +267 77 723 232');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    // Clear errors on input
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

    console.log('📧 Contact form initialized with Web3Forms');
});


// ============================================
// OPTION 2: Formspree (Alternative)
// ============================================
// Sign up at: https://formspree.io
// Free tier: 50 submissions/month

/*
// Replace form submission section with:

const FORMSPREE_ENDPOINT = 'https://formspree.io/f/YOUR_FORM_ID'; // Get from Formspree

try {
    const response = await fetch(FORMSPREE_ENDPOINT, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            phone: phone || 'Not provided',
            service: service,
            message: message
        })
    });

    if (response.ok) {
        successMessage.classList.add('show');
        form.reset();
        // ... rest of success handling
    } else {
        throw new Error('Submission failed');
    }
} catch (error) {
    console.error('Error:', error);
    alert('There was an error sending your message. Please try calling us directly.');
}
*/


// ============================================
// OPTION 3: EmailJS (Alternative)
// ============================================
// Sign up at: https://www.emailjs.com
// Free tier: 200 emails/month

/*
// 1. Add EmailJS SDK to contact.html before closing </body>:
// <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

// 2. Initialize EmailJS
emailjs.init('YOUR_PUBLIC_KEY'); // Get from EmailJS dashboard

// 3. Replace form submission with:
try {
    const templateParams = {
        from_name: name,
        from_email: email,
        phone: phone || 'Not provided',
        service: service,
        message: message
    };

    const response = await emailjs.send(
        'YOUR_SERVICE_ID',
        'YOUR_TEMPLATE_ID',
        templateParams
    );

    if (response.status === 200) {
        successMessage.classList.add('show');
        form.reset();
        // ... rest of success handling
    } else {
        throw new Error('Submission failed');
    }
} catch (error) {
    console.error('Error:', error);
    alert('There was an error sending your message. Please try calling us directly.');
}
*/


// ============================================
// OPTION 4: PHP Backend (If you have PHP hosting)
// ============================================
// Create a file called 'send-email.php' in your root directory

/*
<?php
// send-email.php

// Set headers to prevent CORS issues
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// Sanitize inputs
$name = filter_var($data['name'], FILTER_SANITIZE_STRING);
$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$phone = isset($data['phone']) ? filter_var($data['phone'], FILTER_SANITIZE_STRING) : 'Not provided';
$service = filter_var($data['service'], FILTER_SANITIZE_STRING);
$message = filter_var($data['message'], FILTER_SANITIZE_STRING);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address']);
    exit;
}

// Email configuration
$to = 'Mookfara@gmail.com'; // Your email
$subject = "New Contact Form Submission from $name";

// Email body
$body = "
New contact form submission from Moofar website:

Name: $name
Email: $email
Phone: $phone
Service Interested In: $service

Message:
$message

---
Sent from Moofar contact form
" . date('Y-m-d H:i:s');

// Email headers
$headers = "From: noreply@moofar.com\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email
if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send email']);
}
?>
*/

// Then update JavaScript to use PHP backend:
/*
try {
    const response = await fetch('send-email.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            phone: phone,
            service: service,
            message: message
        })
    });

    const data = await response.json();

    if (data.success) {
        successMessage.classList.add('show');
        form.reset();
        // ... rest of success handling
    } else {
        throw new Error(data.message);
    }
} catch (error) {
    console.error('Error:', error);
    alert('There was an error sending your message. Please try calling us directly.');
}
*/