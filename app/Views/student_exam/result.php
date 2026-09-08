<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Exam Result | EduQuiz</title>

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

        .result-card {
            max-width: 700px;
            margin: 70px auto;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
        }

        .result-icon {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 35px;
        }

        .score {
            font-size: 52px;
            font-weight: 700;
        }

        .stat-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 700;
        }

    </style>

</head>


<body>


<div class="container">

    <div class="result-card shadow-sm">

        <div class="card-body p-5 text-center">


            <!-- Result Icon -->

            <?php if (($result['status'] ?? '') === 'Pass'): ?>

                <div class="result-icon bg-success-subtle text-success">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

                <h2 class="fw-bold mt-4 mb-1">
                    Congratulations!
                </h2>

                <p class="text-muted">
                    You have passed the examination.
                </p>

            <?php else: ?>

                <div class="result-icon bg-danger-subtle text-danger">

                    <i class="bi bi-x-circle-fill"></i>

                </div>

                <h2 class="fw-bold mt-4 mb-1">
                    Examination Completed
                </h2>

                <p class="text-muted">
                    Unfortunately, you did not pass this examination.
                </p>

            <?php endif; ?>


            <!-- Exam Name -->

            <h5 class="fw-semibold mt-4">

                <?= esc($exam['title']) ?>

            </h5>

            <p class="text-muted mb-4">

                <?= esc($exam['subject']) ?>

            </p>


            <!-- Score -->

            <div class="mb-4">

                <div class="score">

                    <?= esc($attempt['score']) ?>

                    <span class="text-muted fs-5">
                        / <?= esc($exam['total_marks']) ?>
                    </span>

                </div>

                <small class="text-muted">
                    Total Score
                </small>

            </div>


            <!-- Statistics -->

            <div class="row g-3 text-start mb-4">


                <!-- Percentage -->

                <div class="col-md-4">

                    <div class="stat-box">

                        <small class="text-muted">
                            Percentage
                        </small>

                        <div class="stat-value mt-1">

                            <?= esc($attempt['percentage']) ?>%

                        </div>

                    </div>

                </div>


                <!-- Passing Marks -->

                <div class="col-md-4">

                    <div class="stat-box">

                        <small class="text-muted">
                            Passing Marks
                        </small>

                        <div class="stat-value mt-1">

                            <?= esc($exam['passing_marks']) ?>

                        </div>

                    </div>

                </div>


                <!-- Status -->

                <div class="col-md-4">

                    <div class="stat-box">

                        <small class="text-muted">
                            Result
                        </small>

                        <div class="stat-value mt-1
                            <?= ($result['status'] ?? '') === 'Pass'
                                ? 'text-success'
                                : 'text-danger' ?>">

                            <?= esc($result['status'] ?? 'Pending') ?>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Submission Time -->

            <?php if (!empty($attempt['submitted_at'])): ?>

                <p class="text-muted small mb-4">

                    <i class="bi bi-clock me-1"></i>

                    Submitted on
                    <?= date(
                        'd M Y, h:i A',
                        strtotime($attempt['submitted_at'])
                    ) ?>

                </p>

            <?php endif; ?>


            <!-- Actions -->

            <div class="d-flex justify-content-center gap-2">

                <a
                    href="<?= base_url('/dashboard') ?>"
                    class="btn btn-primary px-4"
                >

                    <i class="bi bi-grid me-1"></i>

                    Dashboard

                </a>

            </div>


        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>

</html>