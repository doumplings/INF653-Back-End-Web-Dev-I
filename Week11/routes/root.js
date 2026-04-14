//Import express module
const express = require("express");
//create an instance of the express application
const router = express();
const path = require("path");

router.get(["/", "/index.html"], (req, res) => {
  res.sendFile(path.join(__dirname, "..", "views", "index.html"));
});
router.get("/about.html", (req, res) => {
  res.sendFile(path.join(__dirname, "..", "views", "about.html"));
});

router.get("/error", (req, res, next) => {
  next(new Error("Intentional test error from /error route"));
});

module.exports = router;
