const sgMail = require('@sendgrid/mail');

exports.handler = async (event) => {
  try {
    const data = JSON.parse(event.body);

    sgMail.setApiKey(process.env.SENDGRID_API_KEY);

    // 1. Confirmation email to user
    const userMsg = {
      to: data.email,
      from: 'hello@moofar.co.bw',
      subject: `Thanks for contacting Moofar, ${data.name}`,
      html: `
        <p>Hi ${data.name},</p>
        <p>Thank you for reaching out about <strong>${data.service}</strong>.</p>
        <p>We’ve received your message and will respond shortly.</p>
        <p><em>Your message:</em><br>${data.message}</p>
        <br>
        <p>Warm regards,<br>Moofar Proprietary Limited</p>
      `,
    };

    // 2. Notification email to admins
    const adminMsg = {
      to: ['Mookfara@gmail.com', 'farai.admin@moofar.co.bw'], // Add Farai’s actual email
      from: 'hello@moofar.co.bw',
      subject: `New Contact Form Submission from ${data.name}`,
      html: `
        <p><strong>Name:</strong> ${data.name}</p>
        <p><strong>Email:</strong> ${data.email}</p>
        <p><strong>Phone:</strong> ${data.phone || 'Not provided'}</p>
        <p><strong>Service Type:</strong> ${data.service}</p>
        <p><strong>Message:</strong><br>${data.message}</p>
        <hr>
        <p>This message was submitted via the Moofar website contact form.</p>
      `,
    };

    // Send both emails
    await sgMail.send(userMsg);
    await sgMail.send(adminMsg);

    return {
      statusCode: 200,
      body: JSON.stringify({ message: 'Emails sent successfully' }),
    };
  } catch (error) {
    console.error('SendGrid error:', error);
    return {
      statusCode: 500,
      body: JSON.stringify({ error: 'Failed to send emails' }),
    };
  }
};


