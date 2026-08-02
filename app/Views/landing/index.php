<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduQuiz | Online Examination Platform</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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
            font-family:'Segoe UI',sans-serif;
            background:#F8FAFC;
            color:#0F172A;
            overflow-x:hidden;
        }

        :root{
            --primary:#2563EB;
            --secondary:#1E40AF;
            --dark:#0F172A;
            --text:#64748B;
            --card:#FFFFFF;
            --border:#E2E8F0;
        }

        /* NAVBAR */

        .navbar{
            padding:18px 0;
            background:#fff;
            border-bottom:1px solid var(--border);
        }

        .navbar-brand{
            font-size:30px;
            font-weight:700;
            color:var(--primary)!important;
        }

        .nav-link{
            font-weight:500;
            margin-left:20px;
            color:#334155!important;
        }

        .btn-login,
        .btn-register{
            border-radius:10px;
            padding:10px 22px;
        }

        .btn-register{
            background:var(--primary);
        }

        /* HERO */

        .hero{
            padding:80px 0;
        }

        .hero h1{
            font-size:55px;
            font-weight:700;
            line-height:1.2;
        }

        .hero p{
            margin-top:25px;
            font-size:19px;
            line-height:1.8;
            color:var(--text);
        }

        .hero-buttons{
            margin-top:35px;
        }

        .hero-buttons .btn{
            padding:14px 30px;
            border-radius:12px;
            font-weight:600;
        }

        .hero-buttons .btn-primary{
            background:var(--primary);
        }

        .hero-buttons .btn-outline-primary{
            border:2px solid var(--primary);
        }

        /* FEATURS  */
        .feature-list{
            margin-top:35px;
        }

        .feature-item{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:18px;
            font-size:17px;
            font-weight:500;
            color:#0F172A;
        }

        .feature-item i{
            font-size:20px;
            color:#16A34A;
            flex-shrink:0;
        }

        @media (max-width:992px){

            .feature-list{
                display:inline-block;
                text-align:left;
                margin-top:30px;
            }

        }

        /* DASHBOARD */

        .dashboard{
            background:#fff;
            border-radius:25px;
            padding:30px;
            box-shadow:0 20px 60px rgba(0,0,0,.08);
        }

        .dashboard-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }

        .logo-box{
            width:45px;
            height:45px;
            background:var(--primary);
            border-radius:12px;
        }

        .status{
            background:#DCFCE7;
            color:#15803D;
            padding:8px 15px;
            border-radius:30px;
            font-size:14px;
            font-weight:600;
        }

        .small-card{
            background:#F8FAFC;
            border:1px solid var(--border);
            border-radius:18px;
            padding:18px;
        }

        /* MOBILE */

        @media (max-width:992px){

            .hero{
                text-align:center;
                padding:50px 0;
            }

            .hero h1{
                font-size:40px;
            }

            .dashboard{
                margin-top:50px;
            }

        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a class="navbar-brand" href="#">
            <i class="bi bi-mortarboard-fill"></i>
            EduQuiz
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item ms-lg-3">

                    <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-login">

                        Login

                    </a>

                </li>

                <li class="nav-item ms-lg-2">

                    <a href="<?= base_url('register') ?>" class="btn btn-primary btn-register">

                        Get Started

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6">

                <span class="badge bg-primary px-3 py-2 rounded-pill">

                ONLINE EXAMINATION PLATFORM

                </span>

                <h1 class="mt-4">

                Conduct Online Exams
                Without Complexity.

                </h1>

                <p>

                EduQuiz enables educational institutions, trainers and organizations to create professional online examinations, securely invite students, automate evaluation and access insightful performance reports from a single platform.

                </p>

                <div class="hero-buttons">

                <a href="<?= base_url('register') ?>" class="btn btn-primary me-2">

                Create Account

                </a>

                <a href="<?= base_url('student/login') ?>" class="btn btn-outline-primary">

                Student Login

                </a>

            </div>
            
            <!-- <div class="feature-list">

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Email Based Student Invitation</span>
                </div>

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Automatic Result Generation</span>
                </div>

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Performance Analytics & Reports</span>
                </div>

                <div class="feature-item">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <span>Secure Authentication & Timed Exams</span>
                </div>

            </div> -->
            
            </div>

                <div class="col-lg-6">

                    <div class="dashboard">

                        <div class="dashboard">

                        <div class="dashboard-header">

                            <div class="d-flex align-items-center">

                                <div class="logo-box me-3 d-flex justify-content-center align-items-center">
                                    <i class="bi bi-mortarboard-fill text-white fs-4"></i>
                                </div>

                                <div>

                                    <h5 class="mb-1 fw-bold">
                                        EduQuiz Dashboard
                                    </h5>

                                    <small class="text-muted">
                                        Professional Online Examination Platform
                                    </small>

                                </div>

                            </div>

                            <span class="status">
                                Ready
                            </span>

                        </div>

                        <div class="mt-4">

                            <div class="row g-3">

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-ui-checks-grid fs-2 text-primary me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Exam Management
                                            </h6>

                                            <small class="text-muted">
                                                Create & Schedule
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-people fs-2 text-success me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Student Management
                                            </h6>

                                            <small class="text-muted">
                                                Register Students
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-envelope-paper fs-2 text-warning me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Email Invitations
                                            </h6>

                                            <small class="text-muted">
                                                Send Credentials
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-clock-history fs-2 text-danger me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Timed Exams
                                            </h6>

                                            <small class="text-muted">
                                                Auto Submission
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-bar-chart-line fs-2 text-info me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Results & Reports
                                            </h6>

                                            <small class="text-muted">
                                                Instant Evaluation
                                            </small>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-6">

                                    <div class="small-card d-flex align-items-center">

                                        <i class="bi bi-graph-up-arrow fs-2 text-primary me-3"></i>

                                        <div>

                                            <h6 class="mb-1 fw-bold">
                                                Analytics
                                            </h6>

                                            <small class="text-muted">
                                                Performance Insights
                                            </small>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="mt-4 p-3 rounded-4 bg-light border">

                            <div class="d-flex justify-content-between align-items-center">

                                <div>

                                    <h6 class="fw-bold mb-1">
                                        Secure Examination Environment
                                    </h6>

                                    <small class="text-muted">
                                        Built with CodeIgniter 4 • Bootstrap 5 • MySQL
                                    </small>

                                </div>

                                <i class="bi bi-shield-check fs-1 text-success"></i>

                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<footer class="py-4 border-top bg-white">

    <div class="container">

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold text-primary mb-1">

                    EduQuiz

                </h5>

                <p class="text-muted mb-0">

                    Professional Online Examination Platform

                </p>

            </div>

            <div class="text-muted mt-3 mt-lg-0">

            © 2026 EduQuiz. All Rights Reserved.

            </div>

        </div>

    </div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>