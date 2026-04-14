//Npm packages
const { format } = require("date-fns");
const { v4: uuidv4 } = require("uuid");

//core modules
const fs = require("fs");
const path = require("path");

//logEvents function
const logEvents = async (message, logFileName = "eventLogs.txt") => {
  const logId = uuidv4();
  const timestamp = format(new Date(), "yyyy-MM-dd HH:mm:ss");
  const logEntry = `${logId} \t [${timestamp}] \t ${message}\n`;

  try {
    const logsPath = path.join(__dirname, "..", "logs");
    if (!fs.existsSync(logsPath)) {
      fs.mkdirSync(logsPath, { recursive: true });
    }

    await fs.promises.appendFile(path.join(logsPath, logFileName), logEntry);
  } catch (err) {
    console.error("Error writing to log file: ", err);
  }
};

const logger = (req, res, next) => {
  logEvents(`${req.method} request to ${req.url}`);
  console.log(`${req.method} request to ${req.url}`);
  next();
};

module.exports = { logEvents, logger };
