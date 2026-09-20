<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Examiner Dashboard | EduQuiz</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <!-- Dashboard CSS -->
    <link
        rel="stylesheet"
        href="<?= base_url('assets/css/dashboard.css') ?>">

    <style>

        /* See All Button */

        .see-all-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            padding: 8px 18px;

            border: 1px solid #0d6efd;
            border-radius: 8px;

            background: transparent;

            color: #0d6efd;

            text-decoration: none;

            font-size: 15px;
            font-weight: 500;

            transition: all 0.2s ease;
        }

        .see-all-btn:hover {
            background: #0d6efd;
            color: #fff;
        }

        .see-all-btn i {
            font-size: 14px;
        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVIGATION BAR
====================================================== -->

<nav class="navbar navbar-expand-lg">

    <div class="container">


        <!-- Logo -->

        <a class="navbar-brand"
           href="<?= base_url('dashboard') ?>">

            EduQuiz

        </a>


        <!-- Mobile Toggle -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menu"
            aria-controls="menu"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- Navigation -->

        <div
            class="collapse navbar-collapse"
            id="menu">


            <ul class="navbar-nav mx-auto">


                <!-- Dashboard -->

                <li class="nav-item">

                    <a
                        class="nav-link active"
                        href="<?= base_url('dashboard') ?>">

                        Dashboard

                    </a>

                </li>


                <!-- Examinations -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= base_url('exams') ?>">

                        Examinations

                    </a>

                </li>


                <!-- Students -->

                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="<?= base_url('students') ?>">

                        Students

                    </a>

                </li>


            </ul>


            <!-- Examiner Profile Dropdown -->

            <div class="dropdown">

                <button
                    class="profile-menu"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">


                    <!-- Examiner Information -->

                    <div class="profile-info">

                        <strong>
                            <?= esc(session('name')) ?>
                        </strong>

                        <small>
                            <?= esc(session('organization')) ?>
                        </small>

                    </div>


                    <!-- Avatar -->

                    <div class="profile">

                        <?= strtoupper(
                            substr(session('name'), 0, 1)
                        ) ?>

                    </div>


                    <!-- Dropdown Icon -->

                    <i class="bi bi-chevron-down profile-arrow"></i>


                </button>


                <!-- Dropdown -->

                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">


                    <!-- Update Profile -->

                    <li>

                        <a
                            class="dropdown-item"
                            href="<?= base_url('profile') ?>">

                            <i class="bi bi-person"></i>

                            <span>
                                Update Profile
                            </span>

                        </a>

                    </li>


                    <li>

                        <hr class="dropdown-divider">

                    </li>


                    <!-- Logout -->

                    <li>

                        <a
                            class="dropdown-item logout-item"
                            href="<?= base_url('logout') ?>">

                            <i class="bi bi-box-arrow-right"></i>

                            <span>
                                Logout
                            </span>

                        </a>

                    </li>


                </ul>


            </div>


        </div>

    </div>

</nav>



<!-- =====================================================
     DASHBOARD
====================================================== -->

<div class="dashboard">

    <div class="container">


        <!-- =================================================
             WELCOME CARD
        ================================================== -->

        <div class="welcome-card">

            <div class="row align-items-center">


                <div class="col-lg-8">

                    <span class="badge bg-primary mb-3">

                        Examiner Dashboard

                    </span>


                    <h1>

                        Good Evening,
                        <?= esc(session('name')) ?> 👋

                    </h1>


                    <p>

                        Create examinations, manage questions,
                        invite students, evaluate submissions,
                        and manage your examinations from one place.

                    </p>


                    <!-- Buttons -->

                    <div class="d-flex flex-wrap gap-2">

                        <!-- Create Examination -->

                        <a
                            href="<?= base_url('exams/create') ?>"
                            class="btn-create">

                            <i class="bi bi-plus-circle me-2"></i>

                            Create New Examination

                        </a>


                        <!-- All Examinations -->

                        <a
                            href="<?= base_url('exams') ?>"
                            class="btn-create">

                            <i class="bi bi-grid-3x3-gap me-2"></i>

                            All Examinations

                        </a>

                    </div>


                </div>


                <div class="col-lg-4 text-center">

                    <img
                        src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                        class="img-fluid welcome-image"
                        alt="Examination">

                </div>


            </div>

        </div>



        <!-- =================================================
             STATISTICS
        ================================================== -->

        <div class="row stats g-4">


            <!-- Total Exams -->

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box">

                        <i class="bi bi-file-earmark-text"></i>

                    </div>

                    <h2>

                        <?= esc($totalExams) ?>

                    </h2>

                    <p>

                        Total Examinations

                    </p>

                </div>

            </div>


            <!-- Published -->

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box published-icon">

                        <i class="bi bi-check-circle"></i>

                    </div>

                    <h2>

                        <?= esc($publishedExams) ?>

                    </h2>

                    <p>

                        Published Exams

                    </p>

                </div>

            </div>


            <!-- Draft -->

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box draft-icon">

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <h2>

                        <?= esc($draftExams) ?>

                    </h2>

                    <p>

                        Draft Exams

                    </p>

                </div>

            </div>


            <!-- Questions -->

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="icon-box question-icon">

                        <i class="bi bi-question-circle"></i>

                    </div>

                    <h2>

                        <?= esc($totalQuestions) ?>

                    </h2>

                    <p>

                        Total Questions

                    </p>

                </div>

            </div>


        </div>



        <!-- =================================================
             RECENT EXAMINATIONS
        ================================================== -->

        <div id="examinations">


            <!-- Section Heading -->

            <div
                class="d-flex align-items-center justify-content-between flex-wrap gap-3 section-heading">

                <h2 class="section-title mb-0">

                    Recent Examinations

                </h2>

            </div>



            <!-- =================================================
                 RECENT EXAMINATION LIST
            ================================================== -->

            <div id="examList">


                <?php if (empty($recentExams)): ?>


                    <!-- Empty State -->

                    <div class="empty-state">

                        <div class="empty-icon">

                            <i class="bi bi-journal-x"></i>

                        </div>


                        <h4>

                            No examinations yet

                        </h4>


                        <p>

                            Create your first examination to get started.

                        </p>


                        <a
                            href="<?= base_url('exams/create') ?>"
                            class="btn btn-primary">

                            <i class="bi bi-plus-circle me-2"></i>

                            Create Examination

                        </a>

                    </div>


                <?php else: ?>


                    <?php
                    /*
                     * Show only the latest examination
                     */
                    $latestExam = array_slice($recentExams, 0, 1);
                    ?>


                    <?php foreach ($latestExam as $exam): ?>


                        <div
                            class="exam-card mb-4"
                            data-exam-title="<?= esc(strtolower($exam['title'])) ?>"
                            data-exam-subject="<?= esc(strtolower($exam['subject'])) ?>">


                            <div class="row align-items-center">


                                <!-- Exam Information -->

                                <div class="col-lg-8">


                                    <div
                                        class="d-flex align-items-center mb-3 flex-wrap">


                                        <h4 class="mb-0 fw-bold">

                                            <?= esc($exam['title']) ?>

                                        </h4>


                                        <?php if ($exam['status'] === 'Published'): ?>

                                            <span
                                                class="badge bg-success ms-3">

                                                Published

                                            </span>

                                        <?php else: ?>

                                            <span
                                                class="badge bg-warning text-dark ms-3">

                                                Draft

                                            </span>

                                        <?php endif; ?>


                                    </div>



                                    <p class="text-muted mb-4">

                                        <?= esc($exam['subject']) ?>


                                        <?php if (!empty($exam['description'])): ?>

                                            <span class="mx-1">•</span>

                                            <?= esc(
                                                word_limiter(
                                                    $exam['description'],
                                                    15
                                                )
                                            ) ?>

                                        <?php endif; ?>


                                    </p>



                                    <div class="row">


                                        <!-- Questions -->

                                        <div class="col-md-3 col-6 mb-3">

                                            <small class="text-muted d-block">

                                                Questions

                                            </small>


                                            <strong>

                                                <?php

                                                $examQuestionCount = 0;

                                                foreach (
                                                    $questionsCount ?? []
                                                    as $count
                                                ) {

                                                    if (
                                                        $count['exam_id']
                                                        == $exam['id']
                                                    ) {

                                                        $examQuestionCount =
                                                            $count['total'];

                                                        break;

                                                    }

                                                }

                                                ?>

                                                <?= esc($examQuestionCount) ?>

                                            </strong>

                                        </div>



                                        <!-- Duration -->

                                        <div class="col-md-3 col-6 mb-3">

                                            <small class="text-muted d-block">

                                                Duration

                                            </small>


                                            <strong>

                                                <?= esc($exam['duration']) ?>
                                                Min

                                            </strong>

                                        </div>



                                        <!-- Marks -->

                                        <div class="col-md-3 col-6 mb-3">

                                            <small class="text-muted d-block">

                                                Marks

                                            </small>


                                            <strong>

                                                <?= esc($exam['total_marks']) ?>

                                            </strong>

                                        </div>



                                        <!-- Exam Date -->

                                        <div class="col-md-3 col-6 mb-3">

                                            <small class="text-muted d-block">

                                                Exam Date

                                            </small>


                                            <strong>

                                                <?= !empty($exam['exam_date'])
                                                    ? date(
                                                        'd M Y',
                                                        strtotime(
                                                            $exam['exam_date']
                                                        )
                                                    )
                                                    : '--'
                                                ?>

                                            </strong>

                                        </div>


                                    </div>


                                </div>



                                <!-- Actions -->

                                <div class="col-lg-4">

                                    <div class="exam-actions">


                                        <!-- Review -->

                                        <a
                                            href="<?= base_url('exams/review/' . $exam['id']) ?>"
                                            class="action-btn review-btn">

                                            <i class="bi bi-eye"></i>

                                            Review

                                        </a>



                                        <!-- Edit -->

                                        <a
                                            href="<?= base_url('exams/edit/' . $exam['id']) ?>"
                                            class="action-btn edit-btn">

                                            <i class="bi bi-pencil-square"></i>

                                            Edit

                                        </a>



                                        <!-- Share -->

                                        <a
                                            href="<?= base_url('exams/share/' . $exam['id']) ?>"
                                            class="action-btn share-btn">

                                            <i class="bi bi-send"></i>

                                            Share

                                        </a>



                                        <!-- Results -->

                                        <?php if ($exam['status'] === 'Completed'): ?>

                                            <a
                                                href="<?= base_url('exams/results/' . $exam['id']) ?>"
                                                class="action-btn result-btn">

                                                <i class="bi bi-bar-chart"></i>

                                                Results

                                            </a>

                                        <?php else: ?>

                                            <button
                                                class="action-btn result-btn disabled"
                                                disabled>

                                                <i class="bi bi-lock"></i>

                                                Results

                                            </button>

                                        <?php endif; ?>



                                        <!-- Delete -->

                                        <form
                                            action="<?= base_url('exams/delete/' . $exam['id']) ?>"
                                            method="post"
                                            class="delete-form">

                                            <?= csrf_field() ?>


                                            <button
                                                type="submit"
                                                class="action-btn delete-btn"
                                                onclick="return confirm('Are you sure you want to delete this examination?')">

                                                <i class="bi bi-trash"></i>

                                                Delete

                                            </button>

                                        </form>


                                    </div>

                                </div>


                            </div>

                        </div>


                    <?php endforeach; ?>


                    <!-- =================================================
                         SEE ALL
                    ================================================== -->

                    <div class="text-center mt-3 mb-4">

                        <a
                            href="<?= base_url('exams') ?>"
                            class="see-all-btn">

                            See All

                            <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>


                <?php endif; ?>


            </div>


        </div>


    </div>

</div>


<?= view('layouts/footer') ?>

<!-- =====================================================
     FLOATING CREATE BUTTON
====================================================== -->

<a
    href="<?= base_url('exams/create') ?>"
    class="floating-btn">

    <i class="bi bi-plus-lg"></i>

</a>



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>