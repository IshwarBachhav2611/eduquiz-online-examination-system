<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>My Examinations | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f8fafc;
            color: #1e293b;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .page-header {
            padding: 32px 0 20px;
        }

        .summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            background: #ffffff;
            transition: 0.2s ease;
        }

        .summary-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
        }

        .summary-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
        }

        .exam-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            transition: 0.2s ease;
        }

        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.08);
        }

        .exam-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .exam-title {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
        }

        .exam-meta {
            color: #64748b;
            font-size: 14px;
        }

        .exam-meta i {
            width: 18px;
        }

        .status-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 7px 10px;
            border-radius: 20px;
        }

        .filter-bar {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
        }

        .filter-btn {
            border: none;
            background: transparent;
            color: #64748b;
            font-weight: 500;
            border-radius: 8px;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: #eff6ff;
            color: #2563eb;
        }

        .empty-state {
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            background: #ffffff;
        }

        .score-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 12px 14px;
        }

        .profile-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #2563eb;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .dropdown-toggle::after {
            margin-left: 6px;
        }

        @media (max-width: 767px) {

            .page-header {
                padding-top: 24px;
            }

            .summary-card {
                margin-bottom: 0;
            }

        }

    </style>

</head>

<body>

<!-- =========================================================
     NAVBAR
========================================================= -->

<nav class="navbar navbar-expand-lg bg-white border-bottom">

    <div class="container py-2">

        <a
            href="<?= base_url('/student/exams') ?>"
            class="navbar-brand text-primary"
        >
            <i class="bi bi-mortarboard-fill me-2"></i>
            EduQuiz
        </a>

        <div class="dropdown">

            <button
                class="btn btn-light d-flex align-items-center gap-2"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >

                <div class="profile-avatar">
                    <?= strtoupper(substr(session('student_name'), 0, 1)) ?>
                </div>

                <span class="d-none d-sm-inline">
                    <?= esc(session('student_name')) ?>
                </span>

                <i class="bi bi-chevron-down small"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                <li>
                    <span class="dropdown-item-text">

                        <strong>
                            <?= esc(session('student_name')) ?>
                        </strong>

                        <br>

                        <small class="text-muted">
                            <?= esc(session('student_email')) ?>
                        </small>

                    </span>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a
                        class="dropdown-item"
                        href="<?= base_url('/student/exams') ?>"
                    >
                        <i class="bi bi-journal-text me-2"></i>
                        My Examinations
                    </a>
                </li>

                <li>
                    <a
                        class="dropdown-item"
                        href="#"
                        onclick="return false;"
                    >
                        <i class="bi bi-person me-2"></i>
                        My Profile
                        <small class="text-muted ms-1">
                            Coming Soon
                        </small>
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                <li>
                    <a
                        class="dropdown-item text-danger"
                        href="<?= base_url('/student/logout') ?>"
                    >
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- =========================================================
     MAIN CONTENT
========================================================= -->

<main class="container pb-5">

    <!-- Page Header -->

    <div class="page-header">

        <h2 class="fw-bold mb-1">
            My Examinations
        </h2>

        <p class="text-muted mb-0">
            View your assigned examinations and examination status.
        </p>

    </div>


    <!-- =====================================================
         FLASH MESSAGES
    ====================================================== -->

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success border-0 shadow-sm">

            <i class="bi bi-check-circle me-2"></i>

            <?= esc(session()->getFlashdata('success')) ?>

        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger border-0 shadow-sm">

            <i class="bi bi-exclamation-circle me-2"></i>

            <?= esc(session()->getFlashdata('error')) ?>

        </div>

    <?php endif; ?>


    <?php

        /*
        |--------------------------------------------------------------------------
        | Calculate examination counts
        |--------------------------------------------------------------------------
        */
        $totalExams = count($exams);

        $waitingCount = 0;
        $availableCount = 0;
        $progressCount = 0;
        $completedCount = 0;
        $notAttemptedCount = 0;

        foreach ($exams as $exam) {

            switch ($exam['student_status']) {

                case 'waiting':
                    $waitingCount++;
                    break;

                case 'available':
                    $availableCount++;
                    break;

                case 'in_progress':
                    $progressCount++;
                    break;

                case 'completed':
                    $completedCount++;
                    break;

                case 'not_attempted':
                    $notAttemptedCount++;
                    break;
            }
        }

    ?>


    <!-- =====================================================
         SUMMARY CARDS
    ====================================================== -->

    <div class="row g-3 mb-4">

        <!-- Total -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-primary-subtle text-primary">
                        <i class="bi bi-journal-text"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            Total
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $totalExams ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Waiting -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-secondary-subtle text-secondary">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            Waiting
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $waitingCount ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Available -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-primary-subtle text-primary">
                        <i class="bi bi-play-circle"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            Start Now
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $availableCount ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- In Progress -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-warning-subtle text-warning">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            In Progress
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $progressCount ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Completed -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            Completed
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $completedCount ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Completed -->

        <div class="col-6 col-lg">

            <div class="summary-card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="summary-icon bg-success-subtle text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div>

                        <div class="small text-muted">
                            Not Attempted
                        </div>

                        <div class="fs-4 fw-bold">
                            <?= $notAttemptedCount ?>
                        </div>

                    </div>

                </div>

            </div>

        </div>


    </div>


    <!-- =====================================================
         FILTER BAR
    ====================================================== -->

    <?php if (!empty($exams)): ?>

        <div class="filter-bar p-2 mb-4">

            <div class="d-flex flex-wrap gap-1">

                <button
                    type="button"
                    class="btn filter-btn active"
                    data-filter="all"
                >
                    All
                    <span class="badge text-bg-light ms-1">
                        <?= $totalExams ?>
                    </span>
                </button>

                <button
                    type="button"
                    class="btn filter-btn"
                    data-filter="waiting"
                >
                    Waiting
                </button>

                <button
                    type="button"
                    class="btn filter-btn"
                    data-filter="available"
                >
                    Start Now
                </button>

                <button
                    type="button"
                    class="btn filter-btn"
                    data-filter="in_progress"
                >
                    In Progress
                </button>

                <button
                    type="button"
                    class="btn filter-btn"
                    data-filter="completed"
                >
                    Completed
                </button>

                <button
                    type="button"
                    class="btn filter-btn"
                    data-filter="not_attempted"
                >
                    Not Attempted
                </button>

            </div>

        </div>

    <?php endif; ?>


    <!-- =====================================================
         EXAMINATIONS
    ====================================================== -->

    <?php if (!empty($exams)): ?>

        <div class="row g-4" id="examList">

            <?php foreach ($exams as $exam): ?>

                <div
                    class="col-12 col-md-6 col-xl-4 exam-item"
                    data-status="<?= esc($exam['student_status']) ?>"
                >

                    <div class="exam-card h-100">

                        <div class="card-body p-4">

                            <!-- Top -->

                            <div class="d-flex justify-content-between align-items-start mb-3">

                                <div class="exam-icon">

                                    <i class="bi bi-journal-text"></i>

                                </div>

                                <span
                                    class="badge text-bg-<?= esc($exam['status_class']) ?> status-badge"
                                >
                                    <?= esc($exam['status_label']) ?>
                                </span>

                            </div>


                            <!-- Title -->

                            <div class="exam-title mb-1">

                                <?= esc($exam['title']) ?>

                            </div>


                            <!-- Subject -->

                            <div class="text-muted mb-4">

                                <?= esc($exam['subject']) ?>

                            </div>


                            <!-- Exam Details -->

                            <div class="exam-meta mb-3">

                                <div class="mb-2">

                                    <i class="bi bi-calendar3 me-2"></i>

                                    <?= date('d M Y', strtotime($exam['exam_date'])) ?>

                                </div>


                                <div class="mb-2">

                                    <i class="bi bi-clock me-2"></i>

                                    <?= date('h:i A', strtotime($exam['start_time'])) ?>

                                    <span class="mx-1">–</span>

                                    <?= date('h:i A', strtotime($exam['end_time'])) ?>

                                </div>


                                <div class="mb-2">

                                    <i class="bi bi-stopwatch me-2"></i>

                                    <?= esc($exam['duration']) ?> minutes

                                </div>


                                <div class="mb-2">

                                    <i class="bi bi-award me-2"></i>

                                    <?= esc($exam['total_marks']) ?> marks

                                </div>


                                <div>

                                    <i class="bi bi-check2-circle me-2"></i>

                                    Passing marks:
                                    <?= esc($exam['passing_marks']) ?>

                                </div>

                            </div>


                            <!-- Completed Score -->

                            <?php if ($exam['student_status'] === 'completed'): ?>

                                <div class="score-box mb-3">

                                    <div class="d-flex justify-content-between">

                                        <span class="text-muted">
                                            Your Score
                                        </span>

                                        <strong>
                                            <?= esc($exam['score']) ?>
                                            /
                                            <?= esc($exam['total_marks']) ?>
                                        </strong>

                                    </div>

                                    <div class="d-flex justify-content-between mt-1">

                                        <span class="text-muted">
                                            Percentage
                                        </span>

                                        <strong>
                                            <?= esc($exam['percentage']) ?>%
                                        </strong>

                                    </div>

                                </div>

                            <?php endif; ?>


                            <!-- Action -->

                            <div class="mt-4">

                                <?php if ($exam['action'] === 'start'): ?>

                                    <a
                                        href="<?= base_url('/student/exam/start/' . $exam['id']) ?>"
                                        class="btn btn-primary w-100"
                                    >
                                        <i class="bi bi-play-circle me-2"></i>
                                        Start Exam
                                    </a>

                                <?php elseif ($exam['action'] === 'continue'): ?>

                                    <a
                                        href="<?= base_url('/student/exam/start/' . $exam['id']) ?>"
                                        class="btn btn-warning w-100"
                                    >
                                        <i class="bi bi-arrow-right-circle me-2"></i>
                                        Continue Exam
                                    </a>

                                <?php elseif ($exam['action'] === 'result'): ?>

                                    <a
                                        href="<?= base_url('/student/exam/result/' . $exam['attempt_id']) ?>"
                                        class="btn btn-success w-100"
                                    >
                                        <i class="bi bi-file-earmark-text me-2"></i>
                                        View Result
                                    </a>

                                <?php elseif ($exam['action'] === 'disabled'): ?>
                                    <button
                                        type="button"
                                        class="btn btn-light border w-100"
                                        disabled
                                    >

                                        <?php if ($exam['student_status'] === 'waiting'): ?>

                                            <i class="bi bi-hourglass-split me-2"></i>
                                            Not Started Yet

                                        <?php elseif ($exam['student_status'] === 'not_attempted'): ?>

                                            <i class="bi bi-clock-history me-2"></i>
                                            Not Attempted

                                        <?php endif; ?>

                                    </button>
                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>


        <!-- No filter results -->

        <div
            id="noFilterResults"
            class="empty-state text-center py-5 mt-4"
            style="display: none;"
        >

            <i class="bi bi-search display-6 text-muted"></i>

            <h5 class="fw-bold mt-3">
                No examinations found
            </h5>

            <p class="text-muted mb-0">
                There are no examinations matching this filter.
            </p>

        </div>

    <?php else: ?>

        <!-- =================================================
             NO EXAMS
        ================================================== -->

        <div class="empty-state text-center py-5">

            <i class="bi bi-journal-x display-4 text-muted"></i>

            <h5 class="fw-bold mt-3">
                No examinations assigned
            </h5>

            <p class="text-muted mb-0">

                You currently don't have any examinations
                assigned to you.

            </p>

        </div>

    <?php endif; ?>

</main>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

    document.addEventListener('DOMContentLoaded', function () {

        const filterButtons =
            document.querySelectorAll('.filter-btn');

        const examItems =
            document.querySelectorAll('.exam-item');

        const noFilterResults =
            document.getElementById('noFilterResults');


        filterButtons.forEach(function (button) {

            button.addEventListener('click', function () {

                const filter =
                    this.getAttribute('data-filter');


                filterButtons.forEach(function (btn) {

                    btn.classList.remove('active');

                });


                this.classList.add('active');


                let visibleCount = 0;


                examItems.forEach(function (item) {

                    const status =
                        item.getAttribute('data-status');


                    if (
                        filter === 'all' ||
                        status === filter
                    ) {

                        item.style.display = '';

                        visibleCount++;

                    } else {

                        item.style.display = 'none';

                    }

                });


                if (noFilterResults) {

                    noFilterResults.style.display =
                        visibleCount === 0
                            ? 'block'
                            : 'none';

                }

            });

        });

    });

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>