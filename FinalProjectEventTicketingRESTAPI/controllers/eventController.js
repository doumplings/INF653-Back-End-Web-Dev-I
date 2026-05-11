const Event = require('../models/Event');
const Booking = require('../models/Booking');

// GET /api/events  — supports ?category=... and ?date=YYYY-MM-DD (combinable)
const getEvents = async (req, res, next) => {
  try {
    const filter = {};

    if (req.query.category) {
      filter.category = { $regex: new RegExp(req.query.category, 'i') };
    }

    if (req.query.date) {
      const startOfDay = new Date(req.query.date);
      if (isNaN(startOfDay.getTime())) {
        return res.status(400).json({ error: 'Invalid date format. Use YYYY-MM-DD' });
      }
      const endOfDay = new Date(startOfDay);
      endOfDay.setDate(endOfDay.getDate() + 1);
      filter.date = { $gte: startOfDay, $lt: endOfDay };
    }

    const events = await Event.find(filter).sort({ date: 1 });
    res.status(200).json({ count: events.length, events });
  } catch (error) {
    next(error);
  }
};

// GET /api/events/:id
const getEventById = async (req, res, next) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }
    res.status(200).json({ event });
  } catch (error) {
    next(error);
  }
};

// POST /api/events  (admin only)
const createEvent = async (req, res, next) => {
  try {
    const { title, description, category, venue, date, time, seatCapacity, price } = req.body;

    if (!title || !date || !seatCapacity || price === undefined || price === null) {
      return res.status(400).json({ error: 'title, date, seatCapacity, and price are required' });
    }

    if (seatCapacity <= 0) {
      return res.status(400).json({ error: 'seatCapacity must be greater than 0' });
    }

    if (price < 0) {
      return res.status(400).json({ error: 'price cannot be negative' });
    }

    const event = await Event.create({
      title,
      description,
      category,
      venue,
      date,
      time,
      seatCapacity,
      price,
    });

    res.status(201).json({ message: 'Event created successfully', event });
  } catch (error) {
    next(error);
  }
};

// PUT /api/events/:id  (admin only)
const updateEvent = async (req, res, next) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }

    const { seatCapacity, price, ...rest } = req.body;

    // Prevent reducing seatCapacity below already booked seats
    if (seatCapacity !== undefined) {
      if (seatCapacity <= 0) {
        return res.status(400).json({ error: 'seatCapacity must be greater than 0' });
      }
      if (seatCapacity < event.bookedSeats) {
        return res.status(400).json({
          error: `Cannot reduce seatCapacity below current bookedSeats (${event.bookedSeats})`,
        });
      }
      rest.seatCapacity = seatCapacity;
    }

    if (price !== undefined) {
      if (price < 0) {
        return res.status(400).json({ error: 'price cannot be negative' });
      }
      rest.price = price;
    }

    // Prevent updating _id
    delete rest._id;

    const updatedEvent = await Event.findByIdAndUpdate(req.params.id, rest, {
      new: true,
      runValidators: true,
    });

    res.status(200).json({ message: 'Event updated successfully', event: updatedEvent });
  } catch (error) {
    next(error);
  }
};

// DELETE /api/events/:id  (admin only)
// Approach: delete the event AND its associated bookings
const deleteEvent = async (req, res, next) => {
  try {
    const event = await Event.findById(req.params.id);
    if (!event) {
      return res.status(404).json({ error: 'Event not found' });
    }

    // Remove all bookings associated with this event
    const deletedBookings = await Booking.deleteMany({ event: req.params.id });

    await Event.findByIdAndDelete(req.params.id);

    res.status(200).json({
      message: 'Event and associated bookings deleted successfully',
      deletedBookingsCount: deletedBookings.deletedCount,
    });
  } catch (error) {
    next(error);
  }
};

module.exports = { getEvents, getEventById, createEvent, updateEvent, deleteEvent };
