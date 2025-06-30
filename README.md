# Attendance System
***
A web-based student attendance management system built with PHP (MySQLi procedural), HTML, and Bootstrap 5, featuring:

- Admin management of students, teachers, and courses
- Teacher-controlled course activation
- Student fingerprint (WebAuthn to be implemented) and password-based attendance marking
- Attendance reporting with CSV export

## Task
Problem:
Manual attendance recording is time-consuming, error-prone, and insecure for institutions. There is a need for a reliable system to:

- Allow **admins** to manage students, teachers, and courses efficiently

- Enable **teachers** to activate courses only during lectures

- Ensure **students** can mark attendance only once during an active course session

- Provide **reports** for attendance percentage per student per course

**Challenge:**
Integrating role-based access, WebAuthn fingerprint registration (To be implemented), secure password storage, and attendance logic within a clean, modular PHP application.

## Description
This project solves the above problems by:

- Designing a **modular PHP + MySQLi** backend with clean folder structures (auth/, students/, teachers/, courses/, includes/)

- Using **Bootstrap 5** for responsive UI

- Implementing **session-based authentication** with role restrictions

- Adding WebAuthn-based fingerprint registration (To be implemented) and fallback password-based attendance marking

- Allowing **admins** to manage **students**, **teachers**, and **courses**, assign courses to teachers

- Allowing teachers to **activate courses** within a time window

- Restricting students to **mark attendance only once per active course**

- Generating **attendance reports with percentage per student per course**, exportable as CSV

## Installation
1. Clone the repository in (C:\xampp\htdocs)
    ```bash
    git clone https://github.com/Saminu3110c/attendance-system.git
    ```
    ```bash
    cd attendance-system
    ```
2. Import the database
    - Import attendance_system.sql into your MySQL server via phpMyAdmin or CLI:
    ```bash
    mysql -u root -p attendance_system < attendance_system.sql
    ```
3. Start XAMPP/LAMP server and navigate to:
    ```bash
    http://localhost/attendance-system
    ```

## Usage
🔑 Admin
1. **Login as admin**
2. **Manage students, teachers, course**
   - Add, edit, delete records
   - Assign courses to teachers
3. **View attendance reports**
   - Filter by student or course
   - Export report as CSV

👨‍🏫 Teacher
1. **Login as teacher**
2. **Activate assigned courses**
   - Define start and end time
   - Only active within the specified window

👨‍🎓 Student
1. Register fingerprint(to be implemented) or password
    - If registered via CSV bulk upload, create password via create_password.php
2. **Login as student**
3. **Mark attendance**
    - Can only mark attendance once per active course session

📂 Project Structure
```pgsql
attendance-system/
│
├── auth/
│   ├── login.php
│   ├── login_process.php
│   ├── logout.php
│   ├── create_password.php
│   └── forgot_password.php
│
├── students/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── delete.php
│
├── teachers/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   └── delete.php
│
├── courses/
│   ├── index.php
│   ├── add.php
│   ├── edit.php
│   ├── delete.php
│   └── assign.php
│
├── dashboard/
│   └── index.php
|
├── teacher_dashboard/
│   ├── activate.php
│   └── index.php
|   
│
├── student_dashboard/
│   ├── index.php
│   └── mark_attendance.php
│
├── includes/
│   └── db.php
│
├── DATABASE/
│   └── attendance_system.sql
|
├── index.php
├── DB_DESIGN.txt
├── registerAdmin.php
└── README.md

```


### The Core Team
- Engr. Dr. Monday Abutu Idakwo 
- Saminu Isah - isah_s


<span><i>Made at Federal University Lokoja (FUL)</i></span>
<span><img alt='Schools Logo' src='' width='20px' /></span>
