const express = require('express');
const app = express();
const path = require('path')
const PORT = 3000;
const cors = require('cors');
const {logger} = require('./middleware/logger.js')
const errorHandler = require('./middleware/errorHandler.js');
const corsOptions = require('./config/corsOptions.js');



//Custom middlerware functions 
app.use(logger);

//Cross-origin resource sharing 
app.use(cors(corsOptions));
//Built in middlerware functions 
app.use(express.urlencoded({extended: false}));
app.use(express.json())
app.use('/assets',express.static(path.join(__dirname, "/assets")));
app.use('/data', express.static(path.join(__dirname, 'data')));

app.use('/', require('./routes/root'))

app.use('/employees', require('./routes/api/employees.js'))




app.get('/*splat', (req, res) => {
    res.sendFile(path.join(__dirname, "views", "404.html"))
})

app.use(errorHandler)

app.listen(PORT, ()=>{
    console.log(`Server is running on http://localhost:${PORT}`)
})