// 404 catch-all middleware
const notFound = (req, res, next) => {
  const acceptHeader = req.headers['accept'] || '';

  if (acceptHeader.includes('text/html')) {
    return res.status(404).send(`
      <!DOCTYPE html>
      <html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>404 Not Found</title>
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
          .container {
            text-align: center;
            padding: 2rem;
          }
          h1 {
            font-size: 6rem;
            font-weight: 900;
            color: #6366f1;
            line-height: 1;
          }
          h2 {
            font-size: 1.5rem;
            margin: 1rem 0;
            color: #94a3b8;
          }
          p { color: #64748b; margin-bottom: 2rem; }
          a {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #6366f1;
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
          }
          a:hover { background: #4f46e5; }
        </style>
      </head>
      <body>
        <div class="container">
          <h1>404</h1>
          <h2>Page Not Found</h2>
          <p>The route <strong>${req.originalUrl}</strong> does not exist on this server.</p>
          <a href="/">Go Home</a>
        </div>
      </body>
      </html>
    `);
  }

  return res.status(404).json({ error: '404 Not Found' });
};

module.exports = notFound;
