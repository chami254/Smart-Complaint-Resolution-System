# Smart Complaint Resolution System (SCRS)

A full-stack web-based Complaint Management System developed using PHP and MySQL that enables customers to submit, monitor and track complaints while providing administrators with tools to manage complaints, assign priorities, resolve issues and generate analytical reports.

---

## Project Overview

The Smart Complaint Resolution System (SCRS) was developed as a final year Computer Science project to modernize complaint handling by replacing manual processes with an efficient digital platform.

The system allows customers to:

- Register and login securely
- Submit complaints
- Track complaint progress
- View complaint history
- Manage their profile
- Receive ticket numbers for every complaint

Administrators can:

- Manage all complaints
- Assign complaints to administrators
- Update complaint status
- Change complaint priority
- Record resolution notes
- Manage users
- View system reports and analytics

---

# Features

## Customer Module

- User Registration
- Secure Login
- Dashboard
- Submit Complaint
- Complaint Tracking
- Search & Filter Complaints
- Profile Management
- Account Termination
- Success & Confirmation Modals

---

## Administrator Module

- Admin Dashboard
- Complaint Management
- Update Complaint
- User Management
- Reports Dashboard
- Charts & Analytics
- Role-Based Authentication

---

## Reports

- Complaint Status Distribution
- Complaints by Category
- Complaints by Priority
- Monthly Complaint Trends

---

# Technologies Used

## Frontend

- HTML5
- CSS3
- JavaScript (ES6)
- Font Awesome
- Chart.js

## Backend

- PHP 8+

## Database

- MySQL

## Development Environment

- XAMPP
- MySQL Workbench
- Visual Studio Code
- Git & GitHub

---

# Folder Structure

```
scrs/

│
├── admin/
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── config/
│   └── db.php
│
├── customer/
├── includes/
├── uploads/
│
├── login.php
├── register.php
├── logout.php
├── index.php
│
└── README.md
```

---

# Installation Guide

## 1. Clone the repository

```bash
git clone https://github.com/yourusername/smart-complaint-resolution-system.git
```

or download the ZIP from GitHub.

---

## 2. Move the project

Copy the project folder into:

```
xampp/htdocs/
```

Example

```
C:\xampp\htdocs\scrs
```

---

## 3. Start XAMPP

Start:

- Apache
- MySQL

---

## 4. Create the database

Open:

```
http://localhost/phpmyadmin
```

Create a database named:

```
smart_complaint_resolution_system
```

---

## 5. Import the SQL file

Import

```
database.sql
```

using phpMyAdmin.

---

## 6. Configure the database

Open

```
config/db.php
```

Update the connection details if necessary.

Example:

```php
$host = "localhost";
$dbname = "smart_complaint_resolution_system";
$username = "root";
$password = "";
```

---

## 7. Run the application

Visit

```
http://localhost/scrs
```

The application should now be running.

---

# Default User Roles

The system supports two user roles.

### Customer

Can:

- Submit complaints
- Track complaints
- Manage profile

### Administrator

Can:

- Manage users
- Update complaints
- Generate reports
- Resolve complaints

---

# Database Tables

The project uses three primary tables.

- users
- complaints
- feedback

---

# Future Improvements

- Email Notifications
- File Attachment Uploads
- SMS Notifications
- Complaint Escalation
- Real-time Notifications
- Live Chat Support
- REST API
- Mobile Application

---

# Author

Athman Ibrahim

Bachelor of Science in Computer Science

Mount Kenya University

Specialization: Network Security

---

# License

This project was developed for academic purposes as a final year Computer Science project.
