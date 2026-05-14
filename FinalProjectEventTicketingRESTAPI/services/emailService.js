const nodemailer = require('nodemailer');

let transporter = null;
let usingEthereal = false;

const getTransporter = async () => {
  if (transporter) return transporter;

  if (process.env.EMAIL_HOST) {
    usingEthereal = false;
    transporter = nodemailer.createTransport({
      host: process.env.EMAIL_HOST,
      port: parseInt(process.env.EMAIL_PORT) || 587,
      secure: process.env.EMAIL_SECURE === 'true',
      auth: {
        user: process.env.EMAIL_USER,
        pass: process.env.EMAIL_PASS,
      },
    });
  } else {
    usingEthereal = true;
    const testAccount = await nodemailer.createTestAccount();
    transporter = nodemailer.createTransport({
      host: 'smtp.ethereal.email',
      port: 587,
      auth: { user: testAccount.user, pass: testAccount.pass },
    });
  }

  return transporter;
};

const sendBookingConfirmation = async ({
  to, userName, eventTitle, eventDate, eventVenue, quantity, bookingId, qrCode,
}) => {
  const t = await getTransporter();

  const dateStr = new Date(eventDate).toLocaleDateString('en-US', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
  });

  const info = await t.sendMail({
    from: '"Event Ticketing" <noreply@eventticket.app>',
    to,
    subject: `Booking Confirmed – ${eventTitle}`,
    html: `
      <div style="font-family:'Segoe UI',sans-serif;max-width:600px;margin:0 auto;background:#0f172a;color:#e2e8f0;padding:40px;border-radius:12px;">
        <h1 style="color:#6366f1;margin:0 0 8px;">🎫 Booking Confirmed!</h1>
        <p style="color:#94a3b8;margin:0 0 32px;">Hi ${userName}, your tickets are ready.</p>
        <div style="background:#1e293b;border-radius:8px;padding:24px;margin-bottom:24px;">
          <h2 style="margin:0 0 16px;font-size:1.2rem;">${eventTitle}</h2>
          <table style="width:100%;border-collapse:collapse;">
            <tr><td style="color:#94a3b8;padding:6px 0;width:120px;">📅 Date</td><td style="padding:6px 0;">${dateStr}</td></tr>
            <tr><td style="color:#94a3b8;padding:6px 0;">📍 Venue</td><td style="padding:6px 0;">${eventVenue || 'TBD'}</td></tr>
            <tr><td style="color:#94a3b8;padding:6px 0;">🎟️ Tickets</td><td style="padding:6px 0;">${quantity}</td></tr>
            <tr><td style="color:#94a3b8;padding:6px 0;">🆔 Booking ID</td><td style="padding:6px 0;font-family:monospace;font-size:12px;color:#6366f1;">${bookingId}</td></tr>
          </table>
        </div>
        ${qrCode ? `
        <div style="text-align:center;margin-bottom:24px;">
          <p style="color:#94a3b8;margin-bottom:12px;">Present this QR code at the venue:</p>
          <img src="${qrCode}" style="background:white;padding:12px;border-radius:8px;width:160px;height:160px;" alt="QR Code" />
        </div>` : ''}
        <p style="color:#475569;font-size:12px;text-align:center;margin:0;">Event Ticketing System · Automated message, do not reply.</p>
      </div>`,
  });

  return {
    messageId: info.messageId,
    previewUrl: usingEthereal ? nodemailer.getTestMessageUrl(info) : null,
  };
};

module.exports = { sendBookingConfirmation };
