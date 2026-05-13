const mongoose = require('mongoose');

// Cache the connection across serverless invocations
let cached = mongoose.connection.readyState;

const connectDB = async () => {
  if (mongoose.connection.readyState === 1) return; // already connected

  try {
    await mongoose.connect(process.env.MONGO_URI);
    cached = 1;
    console.log(`MongoDB connected: ${mongoose.connection.host}`);
  } catch (error) {
    console.error(`MongoDB connection error: ${error.message}`);
    // Throw instead of process.exit so serverless functions handle it gracefully
    throw error;
  }
};

module.exports = connectDB;
