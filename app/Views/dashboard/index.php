<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0">

<title>Examiner Dashboard | EduQuiz</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet">

<style>

*{

    margin:0;
    padding:0;
    box-sizing:border-box;

}

html{

    scroll-behavior:smooth;

}

body{

    background:#F8FAFC;
    font-family:'Segoe UI',sans-serif;
    color:#0F172A;

}

:root{

    --primary:#2563EB;
    --primary-dark:#1D4ED8;
    --border:#E2E8F0;
    --text:#64748B;
    --card:#FFFFFF;
    --success:#22C55E;
    --warning:#F59E0B;
    --danger:#EF4444;
    --shadow:0 12px 35px rgba(15,23,42,.06);

}


/*=========================
        NAVBAR
=========================*/

.navbar{

    background:#fff;
    border-bottom:1px solid var(--border);
    padding:18px 0;

}

.navbar-brand{

    font-size:30px;
    font-weight:700;
    color:var(--primary)!important;

}

.nav-link{

    margin-left:22px;
    font-weight:600;
    color:#475569!important;
    transition:.25s;

}

.nav-link:hover{

    color:var(--primary)!important;

}


/*=========================
        PROFILE
=========================*/

.profile{

    width:48px;
    height:48px;
    border-radius:50%;
    background:var(--primary);
    color:#fff;

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:18px;
    font-weight:700;

}


/*=========================
        DASHBOARD
=========================*/

.dashboard{

    padding:50px 0 80px;

}


/*=========================
        WELCOME CARD
=========================*/

.welcome-card{

    background:#fff;
    border-radius:26px;
    padding:50px;
    border:1px solid var(--border);
    box-shadow:var(--shadow);

}

.welcome-card h1{

    font-size:42px;
    font-weight:700;

}

.welcome-card p{

    margin-top:20px;
    color:var(--text);
    line-height:1.9;
    font-size:17px;

}


/*=========================
        BUTTON
=========================*/

.btn-create{

    margin-top:30px;

    background:var(--primary);
    color:#fff;

    padding:14px 30px;

    border:none;

    border-radius:14px;

    font-weight:600;

    transition:.3s;

}

.btn-create:hover{

    background:var(--primary-dark);
    color:#fff;

}


/*=========================
        STATISTICS
=========================*/

.stats{

    margin-top:40px;

}

.stat-card{

    background:#fff;
    border:1px solid var(--border);
    border-radius:20px;
    padding:25px;
    transition:.3s;
    box-shadow:0 5px 20px rgba(0,0,0,.03);

}

.stat-card:hover{

    transform:translateY(-6px);
    box-shadow:var(--shadow);

}

.icon-box{

    width:60px;
    height:60px;

    border-radius:16px;

    background:#EFF6FF;

    color:var(--primary);

    display:flex;
    justify-content:center;
    align-items:center;

    font-size:28px;

    margin-bottom:18px;

}

.stat-card h2{

    font-size:34px;
    font-weight:700;

}

.stat-card p{

    color:var(--text);
    margin:0;

}


/*=========================
        SECTION TITLE
=========================*/

.section-title{

    margin-top:65px;
    margin-bottom:30px;

    font-size:30px;
    font-weight:700;

}


/*=========================
        SEARCH
=========================*/

.input-group{

    border-radius:14px;
    overflow:hidden;

}

.input-group-text{

    background:#fff;
    border-right:none;

}

.form-control{

    border-left:none;

    box-shadow:none!important;

}


/*=========================
        EXAM CARD
=========================*/

.exam-card{

    background:#fff;

    border:1px solid var(--border);

    border-radius:22px;

    padding:28px;

    transition:.30s;

    box-shadow:0 5px 20px rgba(0,0,0,.03);

}

.exam-card:hover{

    transform:translateY(-5px);

    box-shadow:var(--shadow);

}

.exam-card h4{

    font-weight:700;

}

.exam-card hr{

    margin:22px 0;

}

.exam-card strong{

    font-size:18px;

}


/*=========================
        BUTTONS
=========================*/

.btn{

    border-radius:12px;

}


/*=========================
        FLOATING BUTTON
=========================*/

.floating-btn{

    position:fixed;

    right:30px;

    bottom:30px;

    width:65px;

    height:65px;

    background:var(--primary);

    color:#fff;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

    text-decoration:none;

    font-size:28px;

    box-shadow:0 18px 40px rgba(37,99,235,.35);

    transition:.3s;

    z-index:999;

}

.floating-btn:hover{

    background:var(--primary-dark);

    color:#fff;

    transform:scale(1.08);

}


/*=========================
        RESPONSIVE
=========================*/

@media(max-width:992px){

    .welcome-card{

        padding:35px;

    }

    .welcome-card h1{

        font-size:34px;

    }

    .navbar-nav{

        margin-top:20px;

    }

}

@media(max-width:768px){

    .floating-btn{

        width:58px;
        height:58px;

        right:20px;
        bottom:20px;

    }

    .welcome-card{

        text-align:center;

    }

}

</style>

</head>

<body>

<!-- =========================
        NAVIGATION BAR
========================== -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand"
           href="#">

            EduQuiz

        </a>

        <button
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div
            class="collapse navbar-collapse"
            id="menu">

            <ul class="navbar-nav mx-auto">

                <li class="nav-item">

                    <a class="nav-link active"
                       href="#">

                        Dashboard

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="#">

                        Examinations

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="#">

                        Students

                    </a>

                </li>

                <li class="nav-item">

                    <a class="nav-link"
                       href="#">

                        Results

                    </a>

                </li>

            </ul>

            <div class="d-flex align-items-center">

                <div class="text-end me-3">

                    <strong>

                        <?= session('name') ?>

                    </strong>

                    <br>

                    <small class="text-muted">

                        <?= session('organization') ?>

                    </small>

                </div>

                <div class="profile">

                    <?= strtoupper(substr(session('name'),0,1)) ?>

                </div>

            </div>

        </div>

    </div>

</nav>


<!-- =========================
        DASHBOARD
========================== -->

<div class="dashboard">

    <div class="container">


        <!-- =========================
                WELCOME CARD
        ========================== -->

        <div class="welcome-card">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <span class="badge bg-primary mb-3">

                        Examiner Dashboard

                    </span>

                    <h1>

                        Good Evening,
                        <?= session('name') ?> 👋

                    </h1>

                    <p>

                        Create examinations, invite students,
                        automatically evaluate submissions,
                        generate detailed reports,
                        and manage every examination from one dashboard.

                    </p>

                    <a href="<?= base_url('exam/create') ?>"
                       class="btn btn-create">

                        <i class="bi bi-plus-circle me-2"></i>

                        Create New Examination

                    </a>

                </div>

                <div class="col-lg-4 text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        class="img-fluid"
                        style="max-height:230px;">

                </div>

            </div>

        </div>


        <!-- =========================
                STATISTICS
        ========================== -->

        <div class="row stats g-4">

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box">

                        <i class="bi bi-file-earmark-text"></i>

                    </div>

                    <h2>

                        12

                    </h2>

                    <p>

                        Total Examinations

                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box">

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <h2>

                        3

                    </h2>

                    <p>

                        Draft Exams

                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <h2>

                        5

                    </h2>

                    <p>

                        Scheduled

                    </p>

                </div>

            </div>

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box">

                        <i class="bi bi-award"></i>

                    </div>

                    <h2>

                        4

                    </h2>

                    <p>

                        Completed

                    </p>

                </div>

            </div>

        </div>


<!-- =========================
                MY EXAMINATIONS
========================== -->

<h2 class="section-title">

    My Examinations

</h2>

<!-- ==========================================
        SEARCH + FILTER + CREATE BUTTON
=========================================== -->

<div class="row align-items-center mb-4">

    <div class="col-lg-5 mb-3">

        <div class="input-group">

            <span class="input-group-text bg-white">

                <i class="bi bi-search"></i>

            </span>

            <input
                type="text"
                class="form-control"
                placeholder="Search examinations...">

        </div>

    </div>

    <div class="col-lg-7 text-lg-end">

        <button class="btn btn-primary me-2">

            All

        </button>

        <button class="btn btn-outline-secondary me-2">

            Draft

        </button>

        <button class="btn btn-outline-warning me-2">

            Scheduled

        </button>

        <button class="btn btn-outline-success me-3">

            Completed

        </button>

        <a href="<?= base_url('exam/create') ?>"
           class="btn btn-success">

            <i class="bi bi-plus-circle me-2"></i>

            Create Examination

        </a>

    </div>

</div>



<!-- ==========================================
        EXAMINATION LIST
=========================================== -->

<div class="exam-card mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <div class="d-flex align-items-center mb-3">

                <h4 class="mb-0 fw-bold">

                    Java Programming Assessment

                </h4>

                <span class="badge bg-success ms-3">

                    Scheduled

                </span>

            </div>

            <p class="text-muted mb-4">

                Java Fundamentals • OOP • Collections • Exception Handling • Multithreading

            </p>

            <div class="row">

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Questions

                    </small>

                    <strong>

                        30

                    </strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Students

                    </small>

                    <strong>

                        42

                    </strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Duration

                    </small>

                    <strong>

                        60 Min

                    </strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Marks

                    </small>

                    <strong>

                        100

                    </strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Exam Date

                    </small>

                    <strong>

                        15 Aug

                    </strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">

                        Created

                    </small>

                    <strong>

                        Today

                    </strong>

                </div>

            </div>

        </div>



        <div class="col-lg-4">

            <div class="d-grid gap-2">

                <button class="btn btn-primary">

                    <i class="bi bi-question-circle me-2"></i>

                    Manage Questions

                </button>

                <button class="btn btn-outline-primary">

                    <i class="bi bi-people me-2"></i>

                    Student List

                </button>

                <button class="btn btn-outline-warning">

                    <i class="bi bi-envelope-paper me-2"></i>

                    Send Invitations

                </button>

                <button class="btn btn-outline-success">

                    <i class="bi bi-bar-chart me-2"></i>

                    View Results

                </button>

                <div class="d-flex gap-2">

                    <button class="btn btn-outline-secondary w-100">

                        <i class="bi bi-pencil-square me-2"></i>

                        Edit

                    </button>

                    <button class="btn btn-outline-danger w-100">

                        <i class="bi bi-trash me-2"></i>

                        Delete

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- =====================================================
        SECOND EXAMINATION
====================================================== -->

<div class="exam-card mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <div class="d-flex align-items-center mb-3">

                <h4 class="mb-0 fw-bold">

                    Python Programming Assessment

                </h4>

                <span class="badge bg-warning text-dark ms-3">

                    Draft

                </span>

            </div>

            <p class="text-muted mb-4">

                Python Basics • Functions • OOP • File Handling • Exception Handling

            </p>

            <div class="row">

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Questions
                    </small>

                    <strong>25</strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Students
                    </small>

                    <strong>0</strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Duration
                    </small>

                    <strong>45 Min</strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Marks
                    </small>

                    <strong>50</strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Exam Date
                    </small>

                    <strong>--</strong>

                </div>

                <div class="col-md-2">

                    <small class="text-muted d-block">
                        Created
                    </small>

                    <strong>Yesterday</strong>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="d-grid gap-2">

                <button class="btn btn-primary">

                    Manage Questions

                </button>

                <button class="btn btn-outline-primary">

                    Student List

                </button>

                <button class="btn btn-outline-warning">

                    Send Invitations

                </button>

                <button class="btn btn-outline-success">

                    View Results

                </button>

                <div class="d-flex gap-2">

                    <button class="btn btn-outline-secondary w-100">

                        Edit

                    </button>

                    <button class="btn btn-outline-danger w-100">

                        Delete

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =====================================================
        FLOATING CREATE BUTTON
====================================================== -->

<a href="<?= base_url('exam/create') ?>"
   class="floating-btn">

    <i class="bi bi-plus-lg"></i>

</a>


</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>