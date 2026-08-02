# 🎓 EduQuiz

A modern **Online Examination System** built with **CodeIgniter 4**, **Bootstrap 5**, and **MySQL**. EduQuiz enables examiners to create and conduct secure online examinations, manage students, automate evaluation, and generate detailed performance reports.

---

## 📌 Project Overview

EduQuiz is designed to simplify the complete examination process by providing an intuitive platform for creating exams, managing students, conducting assessments, and publishing results.

The system supports two types of users:

- **Examiner**
- **Student**

---

## ✨ Features

### 👨‍🏫 Examiner

- Secure Registration & Login
- Dashboard
- Student Management
- Create & Manage Exams
- Question Management
- Assign Students to Exams
- Email Invitations
- Conduct Timed Exams
- Automatic Result Generation
- Performance Analytics
- Topper List
- Download Result Reports
- Email Result Notification

---

### 👨‍🎓 Student

- Secure Login
- View Assigned Exams
- Attempt Online Exams
- Countdown Timer
- Automatic Submission
- View Results
- Receive Result via Email

---

## 🔄 System Workflow

```text
Landing Page
      │
      ▼
Examiner Login / Register
      │
      ▼
Dashboard
      │
      ├────────► Manage Students
      │
      ├────────► Create Exams
      │
      ├────────► Add Questions
      │
      ├────────► Assign Students
      │
      ├────────► Send Email Invitations
      │
      ├────────► View Results
      │
      └────────► Performance Analytics

────────────────────────────────────────

Student Receives Email
      │
      ▼
Student Login
      │
      ▼
Available Exams
      │
      ▼
Start Exam
      │
      ▼
Submit Answers
      │
      ▼
Automatic Evaluation
      │
      ▼
Result Published
```

---

## 🛠 Tech Stack

| Technology | Purpose |
|------------|---------|
| CodeIgniter 4 | Backend Framework |
| PHP 8.2+ | Server-side Language |
| MySQL | Database |
| Bootstrap 5 | Frontend UI |
| HTML5 | Structure |
| CSS3 | Styling |
| JavaScript | Client-side Interaction |
| Composer | Dependency Management |
| XAMPP | Local Development Server |

---

## 🗄 Database Tables

| Table | Description |
|-------|-------------|
| users | Examiner Accounts |
| students | Student Information |
| exams | Exam Details |
| questions | Exam Questions |
| exam_students | Student Exam Assignments |
| attempts | Student Attempts |
| student_answers | Submitted Answers |
| results | Final Results |

---

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/<your-username>/eduquiz.git
```

### 2. Open Project

```bash
cd eduquiz
```

### 3. Install Dependencies

```bash
composer install
```

### 4. Configure Environment

Rename

```
env
```

to

```
.env
```

Update the database configuration.

```ini
database.default.hostname = localhost
database.default.database = eduquiz
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

---

### 5. Create Database

Create a database named

```
eduquiz
```

---

### 6. Run Migrations

```bash
php spark migrate
```

---

### 7. Start Development Server

```bash
php spark serve
```

Visit

```
http://localhost:8080
```

---

## 📂 Project Structure

```
app
│
├── Controllers
├── Models
├── Views
├── Database
│   ├── Migrations
│   └── Seeds
│
├── Filters
├── Helpers
└── Config
```

---

## 🚧 Development Roadmap

- [x] Project Setup
- [x] Database Design
- [x] Landing Page
- [ ] Authentication
- [ ] Dashboard
- [ ] Student Management
- [ ] Exam Management
- [ ] Question Management
- [ ] Student Assignment
- [ ] Online Examination
- [ ] Automatic Evaluation
- [ ] Analytics Dashboard
- [ ] Email Notifications
- [ ] Result Reports

---

## 📸 Screenshots

Screenshots will be added as the project progresses.

---

## 👨‍💻 Author

**Ishwar Bachhav**

Master of Computer Applications (MCA)

---

## 📄 License

This project is developed for educational purposes as an MCA academic project.