# Daawo Hospital — Smart Queue Management System

A web-based queue management system built for **Daawo Hospital** that lets patients register, book a digital queue ticket, and track their position in real time — while giving doctors a live console to manage patients and admins full oversight of doctors, departments, and daily reports.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Frontend | HTML, CSS |
| Backend | PHP |
| Database | MySQL |
| Local Server | XAMPP (Apache + MySQL) |

---

## Key Features

### Patient Portal
- **Register / Login** — patients create an account with full name, email, phone number, and password.
- **Take a Queue Ticket** — select a department and instantly receive a ticket number.
- **View My Queue Status** — see ticket number, live queue position, current status (Waiting / Serving / Completed), and booking date.
- **Notifications** — automatic in-app alerts as a patient's turn approaches (e.g. *"Only 3 patients remain ahead of you"*) and when it's their turn (*"It is now your turn. Please proceed to the doctor room."*).

### Doctor Console
- Live counters for **Waiting**, **Serving**, and **Completed** patients.
- Full waiting list showing patient name, ticket number, queue position, and status.
- One-click **Call** action to summon the next patient.

### Admin Dashboard
- Add, edit, delete, or deactivate doctor accounts.
- View each doctor's assigned department and active status.
- Generate a **Daily Hospital Report** for any selected date, including:
  - Hospital-wide summary (total patients, waiting, serving, completed, doctors, departments)
  - Department-level breakdown
  - Doctor-level breakdown
  - Full patient details table
- **Export report as PDF** — a clean, print-ready, branded PDF for record-keeping or sharing with hospital leadership.

---

## User Roles

| Role | Access |
|---|---|
| Patient | Register, log in, book tickets, track queue status, view notifications |
| Doctor | Log in, view waiting list, call next patient |
| Admin | Log in, manage doctors, view/export daily reports |

---

## Default Admin Login

```
Email:    admin@gmail.com
Password: 12345
```

> ⚠️ For security, change this default password before deploying the system outside of a local/testing environment.

---

## Installation & Setup (XAMPP)

1. **Install XAMPP** (includes Apache and MySQL) if not already installed.
2. **Copy the project folder** into your XAMPP `htdocs` directory, e.g.:
   ```
   C:\xampp\htdocs\daawo-hospital\
   ```
3. **Start Apache and MySQL** from the XAMPP Control Panel.
4. **Create the database:**
   - Open `http://localhost/phpmyadmin`
   - Create a new database (e.g. `daawo_hospital`)
   - Import the provided `.sql` file to set up the required tables (patients, doctors, admins, departments, tickets/queue, notifications).
5. **Configure the database connection:**
   - Open the database config file (e.g. `config.php` / `db_connect.php`) and update the credentials to match your local MySQL setup (default XAMPP MySQL user is usually `root` with no password).
6. **Run the system:**
   - Open your browser and navigate to:
     ```
     http://localhost/daawo-hospital/
     ```
   - You'll land on the home page with options to register as a patient, or log in as a Patient, Doctor, or Admin.

---

## How the System Works

1. A **patient** registers or logs in, selects a department, and takes a queue ticket.
2. The ticket is added to that department's live queue with a position number.
3. The **doctor** for that department sees the patient appear in their waiting list and calls them forward when ready.
4. The patient receives **automatic notifications** as their position gets closer to the front of the line.
5. Once served, the doctor marks the visit as completed, and the record is included in that day's report.
6. The **admin** can review daily activity across all departments and doctors, and export the report as a PDF at any time.

---

## Project Status

This is a functional prototype of a hospital queue management system, developed as an academic/portfolio project demonstrating full-stack web development with PHP and MySQL.

### Planned Future Enhancements
- SMS / WhatsApp notifications
- Native mobile app
- Multi-branch hospital support
- Predictive analytics for peak-hour staffing

---

## Author

Developed by **Shiine Xaaji** for Daawo Hospital.
