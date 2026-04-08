# Airline Management System

This is a simple PHP-based airline reservation system.

## Project Overview

The application allows users to:
- Register and login
- Search and book flights
- View bookings
- Cancel tickets
- Admins can add, delete, and manage flights

## Files Included

- `index.html` - Homepage
- `login.html`, `register.html` - User authentication pages
- `admin_login.html`, `admin_register.html` - Admin access pages
- `book.php`, `cancel.php`, `search.php`, `my_bookings.php`, `view_ticket.php` - Booking and flight actions
- `admin.php`, `add_flight.php`, `delete_flight.php` - Admin flight management
- `db.php` - Database connection
- `airline_db.sql` - Database schema and initial data
- `style.css` - CSS styles
- `script.js` - Client-side JavaScript
- `images/` - Supporting images

## Setup Instructions

1. Copy the project files to your web server directory (e.g., `htdocs` or `www`).
2. Create a MySQL database and import `airline_db.sql`.
3. Update `db.php` with your database connection details:
   - host
   - username
   - password
   - database name
4. Open the app in your browser and use the login/register pages.

## Notes

- Make sure PHP and MySQL are installed and running.
- Use the admin panel to manage flights.
- Backup your database before making major changes.
