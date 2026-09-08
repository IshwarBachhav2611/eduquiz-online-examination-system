<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        .exam-card {
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            transition: 0.2s;
        }

        .exam-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.08);
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
            font-size: 22px;
        }
    </style>

</head>

<body>

<nav class="navbar bg-white border-bottom">

    <div class="container py-2">

        <div>
            <span class="fw-bold">EduQuiz</span>
            <span class="text-muted ms-2">Examinations</span>
        </div>

        <div class="d-flex align-items-center gap-3">

            <span class="text-muted">
                <?= esc(session('student_name')) ?>
            </span>

            <a
                href="<?= base_url('/student/logout') ?>"
                class="btn btn-outline-secondary btn-sm"
            >
                <i class="bi bi-box-arrow-right me-1"></i>
                Logout
            </a>

        </div>

    </div>

</nav>


<main class="container py-5">

    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <i class="bi bi-check-circle me-2"></i>
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert alert-danger">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Assigned Examinations
        </h3>

        <p class="text-muted mb-0">
            Select an examination to begin.
        </p>

    </div>


    <?php if (!empty($exams)): ?>

        <div class="row g-4">

            <?php foreach ($exams as $exam): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card exam-card h-100">

                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between mb-4">

                                <div class="exam-icon">
                                    <i class="bi bi-journal-text"></i>
                                </div>

                                <span class="badge text-bg-success align-self-start">
                                    <?= esc($exam['status']) ?>
                                </span>

                            </div>


                            <h5 class="fw-bold mb-2">
                                <?= esc($exam['title']) ?>
                            </h5>

                            <p class="text-muted mb-3">
                                <?= esc($exam['subject']) ?>
                            </p>


                            <div class="small text-muted mb-4">

                                <div class="mb-2">
                                    <i class="bi bi-clock me-2"></i>
                                    <?= esc($exam['duration']) ?> minutes
                                </div>

                                <div class="mb-2">
                                    <i class="bi bi-calendar3 me-2"></i>
                                    <?= esc($exam['exam_date']) ?>
                                </div>

                                <div>
                                    <i class="bi bi-award me-2"></i>
                                    <?= esc($exam['total_marks']) ?> marks
                                </div>

                            </div>


                            <a
                                href="<?= base_url('/student/exam/start/' . $exam['id']) ?>"
                                class="btn btn-primary w-100"
                            >
                                <i class="bi bi-play-circle me-2"></i>
                                Start Examination
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-journal-x display-5 text-muted"></i>

                <h5 class="fw-bold mt-3">
                    No examinations assigned
                </h5>

                <p class="text-muted mb-0">
                    You currently don't have any examinations assigned to you.
                </p>

            </div>

        </div>

    <?php endif; ?>

</main>

</body>
</html>