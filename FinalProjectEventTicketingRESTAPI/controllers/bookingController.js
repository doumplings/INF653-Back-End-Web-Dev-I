const QRCode = require('qrcode');
const Booking = require('../models/Booking');
const Event = require('../models/Event');
const { sendBookingConfirmation } = require('../services/emailService');

// GET /api/bookings  — return only bookings for the logged-in user
const getMyBookings = async (req, res, next) => {
  try {
    const bookings = await Booking.find({ user: req.user._id })
      .populate('event', 'title date time venue price category')
      .sort({ bookingDate: -1 });

    res.status(200).json({ count: bookings.length, bookings });
  } catch (error) {
    next(error);
  }
};

// GET /api/bookings/:id  — return one booking only if it belongs to the logged-in user
const getBookingById = async (req, res, next) => {
  try {
    const booking = await Booking.findById(req.params.id).populate(
      'event',
      'title date time venue price category'
    );

    if (!booking) {
      return res.status(404).json({ error: 'Booking not found' });
    }

    // Ownership check
    if (booking.user.toString() !== req.user._id.toString()) {
      return res.status(403).json({ error: 'Access denied: this booking does not belong to you' });
    }

    res.status(200).json({ booking });
  } catch (error) {
    next(error);
  }
};

// POST /api/bookings  — create a booking (authenticated user)
const createBooking = async (req, res, next) => {
  try {
    const { eventId, quantity } = req.body;

    if (!eventId) {
      return res.status(400).json({ error: 'eventId is required' });
    }

    if (!quantity || quantity < 1) {
      return res.status(400).json({ error: 'quantity must be at least 1' });
    }

    const event = await Event.findById(eventId);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }

    const availableSeats = event.seatCapacity - event.bookedSeats;
    if (quantity > availableSeats) {
      return res.status(400).json({
        error: `Not enough seats available. Requested: ${quantity}, Available: ${availableSeats}`,
      });
    }

    // Generate QR code containing booking info as a base64 data URL
    const qrPayload = JSON.stringify({
      user: req.user._id,
      event: eventId,
      quantity,
      timestamp: new Date().toISOString(),
    });

    let qrCode;
    try {
      qrCode = await QRCode.toDataURL(qrPayload);
    } catch {
      // QR code generation failure is non-fatal
      qrCode = null;
    }

    const booking = await Booking.create({
      user: req.user._id,
      event: eventId,
      quantity,
      qrCode,
    });

    // Update bookedSeats on the event
    event.bookedSeats += quantity;
    await event.save();

    const populatedBooking = await Booking.findById(booking._id).populate(
      'event',
      'title date time venue price category'
    );

    let emailResult = null;
    try {
      emailResult = await sendBookingConfirmation({
        to: req.user.email,
        userName: req.user.name,
        eventTitle: populatedBooking.event.title,
        eventDate: populatedBooking.event.date,
        eventVenue: populatedBooking.event.venue,
        quantity,
        bookingId: booking._id.toString(),
        qrCode,
      });
    } catch (emailError) {
      console.error('Email sending failed (non-fatal):', emailError.message);
    }

    res.status(201).json({
      message: 'Booking confirmed',
      booking: populatedBooking,
      email: emailResult
        ? { sent: true, to: req.user.email, previewUrl: emailResult.previewUrl }
        : { sent: false },
    });
  } catch (error) {
    next(error);
  }
};

// GET /api/bookings/validate/:qr  — validate a booking by matching qr code content (bonus)
const validateBooking = async (req, res, next) => {
  try {
    // The :qr param is a booking ID used as the lookup key
    const booking = await Booking.findById(req.params.qr)
      .populate('user', 'name email')
      .populate('event', 'title date time venue');

    if (!booking) {
      return res.status(404).json({ valid: false, error: 'Booking not found' });
    }

    res.status(200).json({
      valid: true,
      booking: {
        id: booking._id,
        user: booking.user,
        event: booking.event,
        quantity: booking.quantity,
        bookingDate: booking.bookingDate,
      },
    });
  } catch (error) {
    next(error);
  }
};

// GET /api/admin/dashboard  — admin: all events with their bookers (bonus)
const adminDashboard = async (req, res, next) => {
  try {
    const events = await Event.find().sort({ date: 1 });

    const dashboard = await Promise.all(
      events.map(async (event) => {
        const bookings = await Booking.find({ event: event._id }).populate(
          'user',
          'name email'
        );
        return {
          event: {
            id: event._id,
            title: event.title,
            date: event.date,
            venue: event.venue,
            seatCapacity: event.seatCapacity,
            bookedSeats: event.bookedSeats,
            availableSeats: event.seatCapacity - event.bookedSeats,
          },
          bookings: bookings.map((b) => ({
            bookingId: b._id,
            user: b.user,
            quantity: b.quantity,
            bookingDate: b.bookingDate,
          })),
          totalBookings: bookings.length,
        };
      })
    );

    res.status(200).json({ totalEvents: events.length, dashboard });
  } catch (error) {
    next(error);
  }
};

module.exports = { getMyBookings, getBookingById, createBooking, validateBooking, adminDashboard };
