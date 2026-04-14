const fs = require("fs");
const path = require("path");
const { format } = require("date-fns");
const { v4: uuidv4 } = require("uuid");

const errorHandler = async (err, req, res, next) => {
  const timestamp = format(new Date(), "yyyy-MM-dd HH:mm:ss");
  const errorId = uuidv4();
  const logEntry = `${errorId}\t[${timestamp}]\t${err.name}: ${err.message}\n`;

  try {
    const logsDir = path.join(__dirname, "..", "logs");

    if (!fs.existsSync(logsDir)) {
      fs.mkdirSync(logsDir, { recursive: true });
    }

    await fs.promises.appendFile(path.join(logsDir, "errorLog.txt"), logEntry);
  } catch (logError) {
    console.error("Failed to write error log:", logError);
  }

  if (res.headersSent) {
    return next(err);
  }

  res.status(err.status || 500).json({
    error: "Internal Server Error",
    message: "Something went wrong. Please try again later.",
  });
};

module.exports = errorHandler;
