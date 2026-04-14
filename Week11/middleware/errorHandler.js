// Import the logEvents function
const { logEvents } = require("./logger.js");

// Error handling middleware
const errorHandler = async (err, req, res, next) => {
  await logEvents(
    `${err.name}\t${err.message}\t${req.method}\t${req.originalUrl}`,
    "errorLog.txt",
  );
  console.error(`${err.name}: ${err.message}`);
  if (err.stack) {
    console.log(err.stack);
  }

  res.status(err.status || 500).send("Internal Server Error");
};

module.exports = errorHandler;
