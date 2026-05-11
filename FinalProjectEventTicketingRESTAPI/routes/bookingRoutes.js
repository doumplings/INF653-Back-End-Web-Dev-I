const express = require('express');
const router = express.Router();
const {
  getMyBookings,
  getBookingById,
  createBooking,
  validateBooking,
  adminDashboard,
} = require('../controllers/bookingController');
const { protect, adminOnly } = require('../middleware/auth');

// NOTE: /validate/:qr must come before /:id to avoid being shadowed
// GET /api/bookings/validate/:qr  (bonus — ticket validation, admin only)
router.get('/validate/:qr', protect, adminOnly, validateBooking);

// GET /api/bookings        — logged-in user's own bookings
router.get('/', protect, getMyBookings);

// GET /api/bookings/:id    — single booking (must belong to logged-in user)
router.get('/:id', protect, getBookingById);

// POST /api/bookings       — create a booking (authenticated users)
router.post('/', protect, createBooking);

module.exports = router;
