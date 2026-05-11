require('dotenv').config();
const express = require('express');
const cors = require('cors');
const connectDB = require('./config/db');

const authRoutes = require('./routes/authRoutes');
const eventRoutes = require('./routes/eventRoutes');
const bookingRoutes = require('./routes/bookingRoutes');
const adminRoutes = require('./routes/adminRoutes');
const errorHandler = require('./middleware/errorHandler');
const notFound = require('./middleware/notFound');

const app = express();

// Connect to MongoDB
connectDB();

// Core middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

// Root welcome page
app.get('/', (req, res) => {
  res.send(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <title>Event Ticketing API</title>
      <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background: #0f172a;
          color: #e2e8f0;
          display: flex;
          align-items: center;
          justify-content: center;
          min-height: 100vh;
        }
        .card {
          background: #1e293b;
          border-radius: 1rem;
          padding: 3rem;
          max-width: 640px;
          width: 90%;
          box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        h1 { font-size: 2rem; color: #6366f1; margin-bottom: 0.5rem; }
        .badge {
          display: inline-block;
          background: #064e3b;
          color: #6ee7b7;
          font-size: 0.75rem;
          font-weight: 700;
          padding: 0.25rem 0.75rem;
          border-radius: 9999px;
          margin-bottom: 1.5rem;
        }
        p { color: #94a3b8; margin-bottom: 1.5rem; line-height: 1.6; }
        h2 { font-size: 1rem; color: #cbd5e1; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        ul { list-style: none; }
        li {
          display: flex;
          align-items: center;
          gap: 0.75rem;
          padding: 0.5rem 0;
          border-bottom: 1px solid #334155;
          font-size: 0.9rem;
          color: #94a3b8;
        }
        li:last-child { border-bottom: none; }
        .method {
          font-size: 0.7rem;
          font-weight: 700;
          padding: 0.2rem 0.5rem;
          border-radius: 0.25rem;
          min-width: 52px;
          text-align: center;
        }
        .GET  { background: #1d4ed8; color: #bfdbfe; }
        .POST { background: #15803d; color: #bbf7d0; }
        .PUT  { background: #b45309; color: #fde68a; }
        .DEL  { background: #b91c1c; color: #fecaca; }
        code { color: #e2e8f0; font-family: monospace; }
      </style>
    </head>
    <body>
      <div class="card">
        <h1>🎟 Event Ticketing API</h1>
        <span class="badge">v1.0.0 · Live</span>
        <p>A RESTful API for browsing events, booking tickets, and managing an event platform. Built with Node.js, Express, MongoDB, and JWT authentication.</p>

        <h2>Auth Routes</h2>
        <ul>
          <li><span class="method POST">POST</span><code>/api/auth/register</code></li>
          <li><span class="method POST">POST</span><code>/api/auth/login</code></li>
          <li><span class="method GET">GET</span><code>/api/auth/me</code></li>
        </ul>

        <br/>
        <h2>Event Routes</h2>
        <ul>
          <li><span class="method GET">GET</span><code>/api/events</code></li>
          <li><span class="method GET">GET</span><code>/api/events/:id</code></li>
          <li><span class="method POST">POST</span><code>/api/events</code>&nbsp;(admin)</li>
          <li><span class="method PUT">PUT</span><code>/api/events/:id</code>&nbsp;(admin)</li>
          <li><span class="method DEL">DEL</span><code>/api/events/:id</code>&nbsp;(admin)</li>
        </ul>

        <br/>
        <h2>Booking Routes</h2>
        <ul>
          <li><span class="method GET">GET</span><code>/api/bookings</code></li>
          <li><span class="method GET">GET</span><code>/api/bookings/:id</code></li>
          <li><span class="method POST">POST</span><code>/api/bookings</code></li>
          <li><span class="method GET">GET</span><code>/api/bookings/validate/:qr</code>&nbsp;(admin)</li>
        </ul>

        <br/>
        <h2>Admin Routes</h2>
        <ul>
          <li><span class="method GET">GET</span><code>/api/admin/dashboard</code>&nbsp;(admin)</li>
        </ul>
      </div>
    </body>
    </html>
  `);
});

// API routes
app.use('/api/auth', authRoutes);
app.use('/api/events', eventRoutes);
app.use('/api/bookings', bookingRoutes);
app.use('/api/admin', adminRoutes);

// 404 catch-all
app.use(notFound);

// Centralized error handler (must be last)
app.use(errorHandler);

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT} in ${process.env.NODE_ENV || 'development'} mode`);
});

module.exports = app;
