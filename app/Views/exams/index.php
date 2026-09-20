<?php

use App\Models\ExamStudentModel;

$examStudentModel = new ExamStudentModel();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>All Examinations | EduQuiz</title>


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

        /* =====================================================
           LOCKED ACTION BUTTON
        ====================================================== */

        .action-btn.disabled {

            background-color: #f1f3f5;

            color: #adb5bd;

            border-color: #d9dee3;

            cursor: pointer;

        }


        .action-btn.disabled:hover {

            background-color: #f1f3f5;

            color: #adb5bd;

            border-color: #d9dee3;

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
                        class="nav-link"
                        href="<?= base_url('dashboard') ?>">

                        Dashboard

                    </a>

                </li>



                <!-- Examinations -->

                <li class="nav-item">

                    <a
                        class="nav-link active"
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


                    <div class="profile-info">

                        <strong>
                            <?= esc(session('name')) ?>
                        </strong>

                        <small>
                            <?= esc(session('organization')) ?>
                        </small>

                    </div>



                    <div class="profile">

                        <?= strtoupper(
                            substr(session('name'), 0, 1)
                        ) ?>

                    </div>



                    <i class="bi bi-chevron-down profile-arrow"></i>


                </button>



                <ul class="dropdown-menu dropdown-menu-end profile-dropdown">


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
     EXAMINATIONS
====================================================== -->

<div class="dashboard">

    <div class="container">


        <!-- =================================================
             PAGE HEADER
        ================================================== -->

        <div
            class="d-flex align-items-center justify-content-between flex-wrap gap-3 section-heading">

            <h2 class="section-title mb-0">

                All Examinations

            </h2>



            <a
                href="<?= base_url('exams/create') ?>"
                class="btn btn-primary">

                <i class="bi bi-plus-circle me-2"></i>

                Create Examination

            </a>

        </div>



        <!-- =================================================
             EXAMINATION LIST
        ================================================== -->

        <div id="examList">


            <?php if (empty($exams)): ?>


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


                <?php foreach ($exams as $exam): ?>


                    <?php

                    /*
                    |----------------------------------------------------------
                    | Shared Students
                    |----------------------------------------------------------
                    */

                    $sharedStudentCount = $examStudentModel
                        ->where('exam_id', $exam['id'])
                        ->countAllResults();


                    $isShared = $sharedStudentCount > 0;



                    /*
                    |----------------------------------------------------------
                    | Examination Deadline
                    |----------------------------------------------------------
                    */

                    $deadlineClosed = false;


                    if (
                        !empty($exam['exam_date']) &&
                        !empty($exam['end_time'])
                    ) {

                        $deadline = strtotime(
                            $exam['exam_date'] . ' ' . $exam['end_time']
                        );


                        $deadlineClosed = time() > $deadline;

                    }



                    /*
                    |----------------------------------------------------------
                    | Results are available ONLY after deadline
                    |----------------------------------------------------------
                    */

                    $resultsEnabled = $deadlineClosed;

                    ?>


                    <div
                        class="exam-card mb-4"
                        data-exam-title="<?= esc(strtolower($exam['title'])) ?>"
                        data-exam-subject="<?= esc(strtolower($exam['subject'])) ?>">


                        <div class="row align-items-center">


                            <!-- =================================================
                                 EXAM INFORMATION
                            ================================================== -->

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



                                <!-- Exam Details -->

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



                                <!-- Sharing Status -->

                                <div class="mt-2">


                                    <?php if ($isShared): ?>

                                        <small class="text-success">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Shared with
                                            <?= esc($sharedStudentCount) ?>
                                            student(s)

                                        </small>

                                    <?php else: ?>

                                        <small class="text-muted">

                                            <i class="bi bi-person-x me-1"></i>

                                            Not shared with students

                                        </small>

                                    <?php endif; ?>


                                </div>


                            </div>



                            <!-- =================================================
                                 ACTIONS
                            ================================================== -->

                            <div class="col-lg-4">

                                <div class="exam-actions">


                                    <!-- =================================================
                                         REVIEW
                                    ================================================== -->

                                    <a
                                        href="<?= base_url('exams/review/' . $exam['id']) ?>"
                                        class="action-btn review-btn">

                                        <i class="bi bi-eye"></i>

                                        Review

                                    </a>



                                    <!-- =================================================
                                         EDIT
                                         Locked after sharing
                                    ================================================== -->

                                    <?php if (!$isShared): ?>

                                        <a
                                            href="<?= base_url('exams/edit/' . $exam['id']) ?>"
                                            class="action-btn edit-btn">

                                            <i class="bi bi-pencil-square"></i>

                                            Edit

                                        </a>

                                    <?php else: ?>

                                        <button
                                            type="button"
                                            class="action-btn edit-btn disabled"
                                            onclick="showLockedMessage(
                                                'Editing Locked',
                                                'This examination has already been shared with students. You can no longer edit it.'
                                            )">

                                            <i class="bi bi-lock"></i>

                                            Edit

                                        </button>

                                    <?php endif; ?>



                                    <!-- =================================================
                                         SHARE
                                         Locked after deadline
                                    ================================================== -->

                                    <?php if (!$deadlineClosed): ?>

                                        <a
                                            href="<?= base_url('exams/share/' . $exam['id']) ?>"
                                            class="action-btn share-btn">

                                            <i class="bi bi-send"></i>

                                            Share

                                        </a>

                                    <?php else: ?>

                                        <button
                                            type="button"
                                            class="action-btn share-btn disabled"
                                            onclick="showLockedMessage(
                                                'Sharing Locked',
                                                'This examination has expired. You can no longer share it with students.'
                                            )">

                                            <i class="bi bi-lock"></i>

                                            Share

                                        </button>

                                    <?php endif; ?>



                                    <!-- =================================================
                                         RESULTS
                                         Available after deadline
                                    ================================================== -->

                                    <?php if ($resultsEnabled): ?>

                                        <a
                                            href="<?= base_url('exams/results/' . $exam['id']) ?>"
                                            class="action-btn result-btn">

                                            <i class="bi bi-bar-chart"></i>

                                            Results

                                        </a>

                                    <?php else: ?>

                                        <button
                                            type="button"
                                            class="action-btn result-btn disabled"
                                            onclick="showLockedMessage(
                                                'Results Locked',
                                                'Results will be available after the examination deadline.'
                                            )">

                                            <i class="bi bi-lock"></i>

                                            Results

                                        </button>

                                    <?php endif; ?>



                                    <!-- =================================================
                                         DELETE
                                    ================================================== -->

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


            <?php endif; ?>


        </div>


    </div>

</div>



<!-- =====================================================
     LOCKED ACTION MODAL
====================================================== -->

<div
    class="modal fade"
    id="lockedActionModal"
    tabindex="-1"
    aria-labelledby="lockedActionTitle"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">


            <!-- Header -->

            <div class="modal-header">

                <h5
                    class="modal-title fw-bold"
                    id="lockedActionTitle">

                    Action Locked

                </h5>


                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>



            <!-- Body -->

            <div class="modal-body text-center py-4">

                <div class="mb-3">

                    <i
                        class="bi bi-lock-fill text-secondary"
                        style="font-size: 42px;">
                    </i>

                </div>


                <p
                    class="text-muted mb-0"
                    id="lockedActionMessage">

                    This action is currently unavailable.

                </p>

            </div>



            <!-- Footer -->

            <div class="modal-footer justify-content-center">

                <button
                    type="button"
                    class="btn btn-primary px-4"
                    data-bs-dismiss="modal">

                    OK

                </button>

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



<!-- =====================================================
     BOOTSTRAP JS
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>



<!-- =====================================================
     LOCKED ACTION POPUP
====================================================== -->

<script>

function showLockedMessage(title, message)
{
    document.getElementById(
        'lockedActionTitle'
    ).textContent = title;


    document.getElementById(
        'lockedActionMessage'
    ).textContent = message;


    const modalElement =
        document.getElementById(
            'lockedActionModal'
        );


    const modal =
        bootstrap.Modal.getOrCreateInstance(
            modalElement
        );


    modal.show();
}

</script>


</body>

</html>