const http = require('http');
const fs = require('fs');
const path = require('path');
const sgMail = require('@sendgrid/mail');

const PORT = 5000;
const HOST = '0.0.0.0';

const mimeTypes = {
  '.html': 'text/html',
  '.css': 'text/css',
  '.js': 'text/javascript',
  '.json': 'application/json',
  '.png': 'image/png',
  '.jpg': 'image/jpeg',
  '.jpeg': 'image/jpeg',
  '.gif': 'image/gif',
  '.svg': 'image/svg+xml',
  '.webp': 'image/webp',
  '.ico': 'image/x-icon'
};

const server = http.createServer((req, res) => {
  res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
  res.setHeader('Pragma', 'no-cache');
  res.setHeader('Expires', '0');

  if (req.method === 'POST' && req.url === '/.netlify/functions/send-email') {
    let body = '';
    req.on('data', chunk => {
      body += chunk.toString();
    });
    
    req.on('end', async () => {
      try {
        const data = JSON.parse(body);
        
        if (!process.env.SENDGRID_API_KEY) {
          res.writeHead(500, { 'Content-Type': 'application/json' });
          res.end(JSON.stringify({ error: 'SendGrid API key not configured' }));
          return;
        }

        sgMail.setApiKey(process.env.SENDGRID_API_KEY);

        const userMsg = {
          to: data.email,
          from: 'hello@moofar.co.bw',
          subject: `Thanks for contacting Moofar, ${data.name}`,
          html: `
            <p>Hi ${data.name},</p>
            <p>Thank you for reaching out about <strong>${data.service}</strong>.</p>
            <p>We've received your message and will respond shortly.</p>
            <p><em>Your message:</em><br>${data.message}</p>
            <br>
            <p>Warm regards,<br>Moofar Proprietary Limited</p>
          `,
        };

        const adminMsg = {
          to: ['Mookfara@gmail.com', 'farai.admin@moofar.co.bw'],
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

        await sgMail.send(userMsg);
        await sgMail.send(adminMsg);

        res.writeHead(200, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ message: 'Emails sent successfully' }));
      } catch (error) {
        console.error('SendGrid error:', error);
        res.writeHead(500, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ error: 'Failed to send emails' }));
      }
    });
    return;
  }

  let filePath = '.' + req.url;
  if (filePath === './') {
    filePath = './index.html';
  }

  const extname = String(path.extname(filePath)).toLowerCase();
  const contentType = mimeTypes[extname] || 'application/octet-stream';

  fs.readFile(filePath, (error, content) => {
    if (error) {
      if (error.code === 'ENOENT') {
        res.writeHead(404, { 'Content-Type': 'text/html' });
        res.end('<h1>404 - Page Not Found</h1>', 'utf-8');
      } else {
        res.writeHead(500);
        res.end('Server Error: ' + error.code);
      }
    } else {
      res.writeHead(200, { 'Content-Type': contentType });
      res.end(content, 'utf-8');
    }
  });
});

server.listen(PORT, HOST, () => {
  console.log(`🌿 Moofar website running at http://${HOST}:${PORT}/`);
  console.log(`📧 Email endpoint: /.netlify/functions/send-email`);
});
