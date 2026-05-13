# Event Ticketing REST API

A full-featured REST API for an Event Ticketing System built with **Node.js**, **Express**, **MongoDB**, and **JWT authentication**.

---

## Features

- User registration and login with JWT authentication
- Role-based access control (user / admin)
- Browse, filter, and view event details
- Book tickets with seat availability validation
- Users can only access their own bookings
- Admins can create, update, and delete events
- QR code generation on booking (bonus)
- QR code validation endpoint (bonus)
- Admin dashboard with booking analytics (bonus)
- Centralized error handling and 404 middleware

---

## Tech Stack

| Layer     | Technology         |
| --------- | ------------------ |
| Runtime   | Node.js            |
| Framework | Express 4          |
| Database  | MongoDB + Mongoose |
| Auth      | JWT (jsonwebtoken) |
| Passwords | bcryptjs           |
| QR Codes  | qrcode             |

---

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/event-ticketing-api.git
cd event-ticketing-api

# 2. Install dependencies
npm install

# 3. Set up environment variables
cp .env.example .env
# Then edit .env with your own values
```

---

## Environment Variables

Create a `.env` file in the root directory (see `.env.example`):

| Variable         | Description                       | Example                         |
| ---------------- | --------------------------------- | ------------------------------- |
| `MONGO_URI`      | MongoDB connection string         | `mongodb://localhost:27017/...` |
| `JWT_SECRET`     | Secret key for signing JWT tokens | `a_long_random_string`          |
| `JWT_EXPIRES_IN` | Token expiry duration             | `7d`                            |
| `PORT`           | Server port                       | `5000`                          |
| `NODE_ENV`       | Environment mode                  | `development` / `production`    |

> **Never commit your `.env` file.** It is listed in `.gitignore`.

---

## Running Locally

```bash
# Development (with auto-reload via nodemon)
npm run dev

# Production
npm start
```

The server will start at `http://localhost:3000`.

---

## Deployed API

```
https://your-project-name.onrender.com/
```

All API routes are prefixed with `/api/`.

---

## API Endpoints

### Authentication

| Method | Endpoint             | Access | Description                        |
| ------ | -------------------- | ------ | ---------------------------------- |
| POST   | `/api/auth/register` | Public | Register a new user                |
| POST   | `/api/auth/login`    | Public | Login and receive a JWT token      |
| GET    | `/api/auth/me`       | User   | Get current logged-in user profile |

### Events

| Method | Endpoint          | Access | Description                                               |
| ------ | ----------------- | ------ | --------------------------------------------------------- |
| GET    | `/api/events`     | Public | Get all events (supports `?category=` `?date=YYYY-MM-DD`) |
| GET    | `/api/events/:id` | Public | Get a single event by ID                                  |
| POST   | `/api/events`     | Admin  | Create a new event                                        |
| PUT    | `/api/events/:id` | Admin  | Update an event                                           |
| DELETE | `/api/events/:id` | Admin  | Delete an event (and its bookings)                        |

### Bookings

| Method | Endpoint                     | Access | Description                             |
| ------ | ---------------------------- | ------ | --------------------------------------- |
| GET    | `/api/bookings`              | User   | Get all bookings for the logged-in user |
| GET    | `/api/bookings/:id`          | User   | Get a single booking (must own it)      |
| POST   | `/api/bookings`              | User   | Create a booking                        |
| GET    | `/api/bookings/validate/:qr` | Admin  | Validate a ticket by booking ID         |

### Admin (Bonus)

| Method | Endpoint               | Access | Description                                     |
| ------ | ---------------------- | ------ | ----------------------------------------------- |
| GET    | `/api/admin/dashboard` | Admin  | All events with their booking details and users |

---

## Request & Response Examples

### Register

```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "password": "password123"
}
```

### Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "jane@example.com",
  "password": "password123"
}
```

### Create Event (Admin)

```http
POST /api/events
Authorization: Bearer <admin_token>
Content-Type: application/json

{
  "title": "Summer Music Festival",
  "description": "Annual outdoor music event",
  "category": "Music",
  "venue": "Central Park, NY",
  "date": "2025-07-20",
  "time": "6:00 PM",
  "seatCapacity": 500,
  "price": 49.99
}
```

### Book a Ticket

```http
POST /api/bookings
Authorization: Bearer <user_token>
Content-Type: application/json

{
  "eventId": "<event_id>",
  "quantity": 2
}
```

---

## Validation Rules

- `email` — must be a valid email format
- `password` — minimum 6 characters
- `seatCapacity` — must be greater than 0
- `price` — cannot be negative
- `quantity` — must be at least 1; cannot exceed available seats
- `bookedSeats` — cannot go below 0 or above seatCapacity

---

## Security

- Passwords are hashed with **bcryptjs** (10 salt rounds) before storage
- JWTs are signed with a secret key from the `.env` file
- Admin-only routes are protected by `adminOnly` middleware
- Users can only view/access their own bookings
