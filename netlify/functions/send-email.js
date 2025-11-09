const sgMail = require('@sendgrid/mail');

exports.handler = async (event) => {
  try {
    const data = JSON.parse(event.body);

    sgMail.setApiKey(process.env.SENDGRID_API_KEY);

    const msg = {
      to: data.email,
      from: 'hello@moofar.co.bw', // Use a verified sender
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

    await sgMail.send(msg);

    return {
      statusCode: 200,
      body: JSON.stringify({ message: 'Email sent successfully' }),
    };
  } catch (error) {
    console.error('SendGrid error:', error);
    return {
      statusCode: 500,
      body: JSON.stringify({ error: 'Failed to send email' }),
    };
  }
};

