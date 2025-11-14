const express = require("express");
const path = require("path");
const fs = require("fs");
const sgMail = require("@sendgrid/mail");
const expressLayouts = require("express-ejs-layouts");

const app = express();
const PORT = process.env.PORT || 3000;
const HOST = "0.0.0.0";

/* ***********************
 * Middleware
 *************************/
// Parse JSON
app.use(express.json());

// Serve static files
app.use(express.static(path.join(__dirname, "public")));

// Index route (renders index.ejs with title "Home")
app.get("/", function(req, res){
    res.render("index", {title: "Home"});
});

/* ***********************
 * View Engine and Templates
 *************************/
app.set("view engine", "ejs");
app.use(expressLayouts);
app.set("layout", "./layouts/layout"); // not at views root

/* ***********************
 * Routes
 *************************/
// If you have a static router, define it here
// Example: const static = require("./routes/static");
// app.use(static);

// Email endpoint
app.post("/.netlify/functions/send-email", async (req, res) => {
  try {
    const data = req.body;

    if (!process.env.SENDGRID_API_KEY) {
      return res.status(500).json({ error: "SendGrid API key not configured" });
    }

    sgMail.setApiKey(process.env.SENDGRID_API_KEY);

    const userMsg = {
      to: data.email,
      from: "hello@moofar.co.bw",
      subject: `Thanks for contacting Moofar, ${data.name}`,
      html: `<p>Hi ${data.name},</p><p>Thank you for reaching out about <strong>${data.service}</strong>.</p><p>We've received your message and will respond shortly.</p><p><em>Your message:</em><br>${data.message}</p><br><p>Warm regards,<br>Moofar Proprietary Limited</p>`,
    };

    const adminMsg = {
      to: ["Mookfara@gmail.com", "farai.admin@moofar.co.bw"],
      from: "hello@moofar.co.bw",
      subject: `New Contact Form Submission from ${data.name}`,
      html: `<p><strong>Name:</strong> ${data.name}</p><p><strong>Email:</strong> ${data.email}</p><p><strong>Phone:</strong> ${data.phone || "Not provided"}</p><p><strong>Service Type:</strong> ${data.service}</p><p><strong>Message:</strong><br>${data.message}</p><hr><p>This message was submitted via the Moofar website contact form.</p>`,
    };

    await sgMail.send(userMsg);
    await sgMail.send(adminMsg);

    res.status(200).json({ message: "Emails sent successfully" });
  } catch (error) {
    console.error("SendGrid error:", error);
    res.status(500).json({ error: "Failed to send emails" });
  }
});

/* ***********************
 * Server Start
 *************************/
app.listen(PORT, HOST, () => {
  console.log(`🌿 Moofar app running at http://${HOST}:${PORT}/`);
  console.log(`📧 Email endpoint: /.netlify/functions/send-email`);
});
