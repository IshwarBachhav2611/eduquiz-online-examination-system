<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= esc($student['name']) ?> | Student Progress | EduQuiz
    </title>

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
            color: #0f172a;
        }

        .page-wrapper {
            padding: 35px 0 60px;
        }

        .back-link {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
        }

        .back-link:hover {
            color: #2563eb;
        }

        .profile-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 28px;
            margin-top: 20px;
        }

        .avatar {
            width: 72px;
            height: 72px;
            border-radius: 18px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
        }

        .student-name {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .student-email {
            color: #64748b;
        }

        .readonly-note {
            font-size: 13px;
            color: #64748b;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 22px;
            height: 100%;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
            font-size: 19px;
        }

        .stat-value {
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 3px;
        }

        .stat-label {
            color: #64748b;
            font-size: 14px;
        }

        .section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
        }

        .section-header {
            padding: 20px 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-header h4 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            border-bottom: 0;
        }

        .info-label {
            color: #64748b;
        }

        .info-value {
            font-weight: 600;
            text-align: right;
        }

        .result-table th {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            background: #f8fafc;
            white-space: nowrap;
        }

        .result-table td {
            vertical-align: middle;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .pass-badge {
            background: #dcfce7;
            color: #166534;
        }

        .fail-badge {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-badge {
            padding: 5px 9px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .progress {
            height: 9px;
            border-radius: 10px;
        }

        @media (max-width: 768px) {

            .page-wrapper {
                padding: 20px 0 40px;
            }

            .profile-card {
                padding: 20px;
            }

            .student-name {
                font-size: 21px;
            }

        }

    </style>

</head>

<body>

<div class="page-wrapper">

    <div class="container">

        <!-- BACK -->

        <div class="mb-3">

            <a
                href="<?= base_url('students') ?>"
                class="back-link"
            >
                <i class="bi bi-arrow-left me-1"></i>
                Back to Students
            </a>

        </div>


        <!-- STUDENT PROFILE -->

        <div class="profile-card">

            <div class="d-flex align-items-center gap-3">

                <div class="avatar">

                    <?= esc(
                        strtoupper(
                            substr(
                                $student['name'],
                                0,
                                1
                            )
                        )
                    ) ?>

                </div>

                <div>

                    <div class="student-name">
                        <?= esc($student['name']) ?>
                    </div>

                    <div class="student-email">
                        <?= esc($student['email']) ?>
                    </div>

                </div>

            </div>


            <hr class="my-4">


            <div class="row g-4">

                <div class="col-md-4">

                    <div class="text-muted small mb-1">
                        Department
                    </div>

                    <strong>
                        <?= !empty($student['department'])
                            ? esc($student['department'])
                            : 'Not provided'
                        ?>
                    </strong>

                </div>


                <div class="col-md-4">

                    <div class="text-muted small mb-1">
                        Phone
                    </div>

                    <strong>
                        <?= !empty($student['phone'])
                            ? esc($student['phone'])
                            : 'Not provided'
                        ?>
                    </strong>

                </div>


                <div class="col-md-4">

                    <div class="text-muted small mb-1">
                        Account Status
                    </div>

                    <span class="badge text-bg-success">
                        <?= esc($student['status']) ?>
                    </span>

                </div>

            </div>


            <div class="readonly-note mt-4">

                <i class="bi bi-info-circle me-1"></i>

                Student profile information is read-only for teachers.
                The student can update their own profile.

            </div>

        </div>


        <!-- PROGRESS -->

        <div class="mt-5 mb-3">

            <h3 class="fw-bold mb-1">
                Overall Progress
            </h3>

            <p class="text-muted mb-0">
                Performance across your examinations for this student.
            </p>

        </div>


        <!-- STAT CARDS -->

        <div class="row g-4">

            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <div class="stat-value">
                        <?= $totalAssigned ?>
                    </div>

                    <div class="stat-label">
                        Exams Assigned
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>

                    <div class="stat-value">
                        <?= $attempted ?>
                    </div>

                    <div class="stat-label">
                        Exams Attempted
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>

                    <div class="stat-value">
                        <?= $completed ?>
                    </div>

                    <div class="stat-label">
                        Completed Exams
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-bar-chart"></i>
                    </div>

                    <div class="stat-value">
                        <?= number_format($averagePercentage, 1) ?>%
                    </div>

                    <div class="stat-label">
                        Average Percentage
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-trophy"></i>
                    </div>

                    <div class="stat-value">
                        <?= number_format($highestPercentage, 1) ?>%
                    </div>

                    <div class="stat-label">
                        Highest Score
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-arrow-down-circle"></i>
                    </div>

                    <div class="stat-value">
                        <?= number_format($lowestPercentage, 1) ?>%
                    </div>

                    <div class="stat-label">
                        Lowest Score
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div class="stat-value">
                        <?= $passed ?>
                    </div>

                    <div class="stat-label">
                        Exams Passed
                    </div>

                </div>

            </div>


            <div class="col-lg-3 col-md-6">

                <div class="stat-card">

                    <div class="stat-icon">
                        <i class="bi bi-x-circle"></i>
                    </div>

                    <div class="stat-value">
                        <?= $failed ?>
                    </div>

                    <div class="stat-label">
                        Exams Failed
                    </div>

                </div>

            </div>

        </div>


        <!-- PASS RATE -->

        <div class="section-card mt-4">

            <div class="section-header">

                <h4>
                    <i class="bi bi-speedometer2 me-2"></i>
                    Pass Rate
                </h4>

            </div>

            <div class="p-4">

                <div class="d-flex justify-content-between mb-2">

                    <span class="text-muted">
                        Overall Pass Percentage
                    </span>

                    <strong>
                        <?= number_format($passPercentage, 1) ?>%
                    </strong>

                </div>

                <div class="progress">

                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: <?= min(100, max(0, $passPercentage)) ?>%;"
                    ></div>

                </div>

            </div>

        </div>


        <!-- RECENT RESULTS -->

        <div class="section-card mt-4">

            <div class="section-header">

                <h4>
                    <i class="bi bi-clock-history me-2"></i>
                    Recent Examination Results
                </h4>

            </div>


            <?php if (!empty($recentResults)): ?>

                <div class="table-responsive">

                    <table class="table result-table mb-0">

                        <thead>

                            <tr>

                                <th class="ps-4">
                                    Examination
                                </th>

                                <th>
                                    Date
                                </th>

                                <th>
                                    Score
                                </th>

                                <th>
                                    Percentage
                                </th>

                                <th>
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        <?php foreach ($recentResults as $result): ?>

                            <tr>

                                <td class="ps-4">

                                    <div class="fw-semibold">
                                        <?= esc($result['title']) ?>
                                    </div>

                                    <?php if (!empty($result['subject'])): ?>

                                        <small class="text-muted">
                                            <?= esc($result['subject']) ?>
                                        </small>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <?= !empty($result['exam_date'])
                                        ? date(
                                            'd M Y',
                                            strtotime($result['exam_date'])
                                        )
                                        : '—'
                                    ?>

                                </td>


                                <td>

                                    <strong>
                                        <?= esc($result['score']) ?>
                                    </strong>

                                    <span class="text-muted">
                                        /
                                        <?= esc($result['total_marks']) ?>
                                    </span>

                                </td>


                                <td>

                                    <strong>
                                        <?= number_format(
                                            $result['percentage'],
                                            1
                                        ) ?>%
                                    </strong>

                                </td>


                                <td>

                                    <?php if ($result['status'] === 'Pass'): ?>

                                        <span class="status-badge pass-badge">
                                            Pass
                                        </span>

                                    <?php elseif ($result['status'] === 'Fail'): ?>

                                        <span class="status-badge fail-badge">
                                            Fail
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge bg-light text-dark">
                                            Completed
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="text-center py-5 px-3">

                    <div class="fs-1 text-muted mb-3">
                        <i class="bi bi-bar-chart"></i>
                    </div>

                    <h5 class="fw-bold">
                        No Completed Exams
                    </h5>

                    <p class="text-muted mb-0">
                        This student has not completed any of your examinations yet.
                    </p>

                </div>

            <?php endif; ?>

        </div>


    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>