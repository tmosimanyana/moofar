// Moofar Contact Form Handler

const form = document.getElementById('contactForm');
const success = document.getElementById('successMessage');

if (form && success) {
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Basic validation
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const service = document.getElementById('service').value;
    const message = document.getElementById('message').value.trim();
    
    let isValid = true;
    
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
    
    // Validate name
    if (name.length < 2) {
      document.getElementById('nameError').textContent = 'Please enter a valid name';
      isValid = false;
    }
    
    // Validate email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
      document.getElementById('emailError').textContent = 'Please enter a valid email address';
      isValid = false;
    }
    
    // Validate service selection
    if (!service) {
      document.getElementById('serviceError').textContent = 'Please select a service';
      isValid = false;
    }
    
    // Validate message
    if (message.length < 10) {
      document.getElementById('messageError').textContent = 'Please enter a message (at least 10 characters)';
      isValid = false;
    }
    
    // If form is valid, show success message
    if (isValid) {
      success.style.display = 'block';
      form.reset();
      
      // Scroll to success message
      success.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      
      // Hide success message after 5 seconds
      setTimeout(() => {
        success.style.display = 'none';
      }, 5000);
    }
  });
  
  // Real-time validation feedback
  const inputs = form.querySelectorAll('input, select, textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      const errorElement = document.getElementById(this.id + 'Error');
      if (errorElement) {
        errorElement.textContent = '';
      }
    });
  });
}
