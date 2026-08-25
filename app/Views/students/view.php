<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Details | EduQuiz</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>


<body class="bg-light">


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">


            <!-- BACK -->

            <div class="mb-4">

                <a
                    href="<?= base_url('students') ?>"
                    class="text-decoration-none"
                >

                    <i class="bi bi-arrow-left"></i>

                    Back to Students

                </a>

            </div>



            <!-- STUDENT CARD -->

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">


                    <!-- HEADER -->

                    <div class="d-flex justify-content-between align-items-start mb-4">

                        <div>

                            <h3 class="mb-1">
                                Student Details
                            </h3>

                            <p class="text-muted mb-0">
                                View student information and examination performance
                            </p>

                        </div>


                        <!-- AVATAR -->

                        <div
                            class="rounded-circle bg-primary-subtle
                                   text-primary d-flex align-items-center
                                   justify-content-center"
                            style="width:55px;height:55px;font-size:20px;"
                        >

                            <?= strtoupper(
                                substr($student['name'], 0, 1)
                            ) ?>

                        </div>

                    </div>



                    <!-- STUDENT INFORMATION -->

                    <div class="row g-4 mb-4">


                        <!-- NAME -->

                        <div class="col-md-6">

                            <small class="text-muted">
                                Student Name
                            </small>

                            <div class="fw-semibold mt-1">
                                <?= esc($student['name']) ?>
                            </div>

                        </div>


                        <!-- EMAIL -->

                        <div class="col-md-6">

                            <small class="text-muted">
                                Email
                            </small>

                            <div class="fw-semibold mt-1">
                                <?= esc($student['email']) ?>
                            </div>

                        </div>


                        <!-- DEPARTMENT -->

                        <div class="col-md-6">

                            <small class="text-muted">
                                Department
                            </small>

                            <div class="fw-semibold mt-1">
                                <?= esc($student['department'] ?? '-') ?>
                            </div>

                        </div>


                        <!-- STATUS -->

                        <div class="col-md-6">

                            <small class="text-muted">
                                Status
                            </small>

                            <div class="mt-1">

                                <span
                                    class="badge
                                    <?= ($student['status'] ?? 'Pending') === 'Active'
                                        ? 'text-bg-success'
                                        : 'text-bg-warning'
                                    ?>"
                                >

                                    <?= esc(
                                        $student['status'] ?? 'Pending'
                                    ) ?>

                                </span>

                            </div>

                        </div>

                    </div>



                    <hr>



                    <!-- =====================================================
                         EXAM STATISTICS
                    ====================================================== -->

                    <div class="row g-3 mb-4 mt-1">


                        <!-- TOTAL EXAMS -->

                        <div class="col-md-4">

                            <div class="card border-0 bg-light h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center gap-2">

                                        <i class="bi bi-journal-check text-primary"></i>

                                        <small class="text-muted">
                                            Exams Given
                                        </small>

                                    </div>

                                    <h3 class="mb-0 mt-2">
                                        <?= esc($totalExams) ?>
                                    </h3>

                                </div>

                            </div>

                        </div>



                        <!-- PASSED -->

                        <div class="col-md-4">

                            <div class="card border-0 bg-success-subtle h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center gap-2">

                                        <i class="bi bi-check-circle text-success"></i>

                                        <small class="text-success">
                                            Passed
                                        </small>

                                    </div>

                                    <h3 class="mb-0 mt-2 text-success">
                                        <?= esc($passed) ?>
                                    </h3>

                                </div>

                            </div>

                        </div>



                        <!-- FAILED -->

                        <div class="col-md-4">

                            <div class="card border-0 bg-danger-subtle h-100">

                                <div class="card-body">

                                    <div class="d-flex align-items-center gap-2">

                                        <i class="bi bi-x-circle text-danger"></i>

                                        <small class="text-danger">
                                            Failed
                                        </small>

                                    </div>

                                    <h3 class="mb-0 mt-2 text-danger">
                                        <?= esc($failed) ?>
                                    </h3>

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- =====================================================
                         RESULT HISTORY
                    ====================================================== -->

                    <div class="mt-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h5 class="mb-0">
                                Examination Results
                            </h5>

                            <?php if (!empty($results)): ?>

                                <span class="badge text-bg-primary">
                                    <?= count($results) ?> Result(s)
                                </span>

                            <?php endif; ?>

                        </div>



                        <?php if (!empty($results)): ?>


                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0">

                                    <thead class="table-light">

                                        <tr>

                                            <th>
                                                Examination
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

                                            <th>
                                                Rank
                                            </th>

                                        </tr>

                                    </thead>


                                    <tbody>


                                        <?php foreach ($results as $result): ?>

                                            <tr>


                                                <!-- EXAM -->

                                                <td>

                                                    <div class="fw-semibold">

                                                        <?= esc(
                                                            $result['exam_title'] ?? '-'
                                                        ) ?>

                                                    </div>

                                                </td>



                                                <!-- SCORE -->

                                                <td>

                                                    <span class="fw-semibold">

                                                        <?= esc(
                                                            $result['score'] ?? 0
                                                        ) ?>

                                                    </span>

                                                </td>



                                                <!-- PERCENTAGE -->

                                                <td>

                                                    <?= esc(
                                                        $result['percentage'] ?? 0
                                                    ) ?>%

                                                </td>



                                                <!-- STATUS -->

                                                <td>

                                                    <?php if (
                                                        strtolower(
                                                            $result['result_status'] ?? ''
                                                        ) === 'pass'
                                                    ): ?>

                                                        <span class="badge text-bg-success">

                                                            <i class="bi bi-check-circle"></i>

                                                            Pass

                                                        </span>

                                                    <?php else: ?>

                                                        <span class="badge text-bg-danger">

                                                            <i class="bi bi-x-circle"></i>

                                                            Fail

                                                        </span>

                                                    <?php endif; ?>

                                                </td>



                                                <!-- RANK -->

                                                <td>

                                                    <?php
                                                    $rank = (int) (
                                                        $result['rank'] ?? 0
                                                    );
                                                    ?>

                                                    <?php if ($rank > 0): ?>

                                                        <span class="fw-semibold">

                                                            #<?= esc($rank) ?>

                                                        </span>

                                                    <?php else: ?>

                                                        <span class="text-muted">
                                                            -
                                                        </span>

                                                    <?php endif; ?>

                                                </td>


                                            </tr>

                                        <?php endforeach; ?>


                                    </tbody>

                                </table>

                            </div>


                        <?php else: ?>


                            <!-- NO RESULTS -->

                            <div
                                class="text-center text-muted py-5
                                       border rounded-3 bg-light"
                            >

                                <i
                                    class="bi bi-clipboard-x fs-1"
                                ></i>

                                <p class="mt-3 mb-0 fw-semibold">

                                    No examination results available yet.

                                </p>

                                <small>

                                    Results will appear here after the student completes an examination.

                                </small>

                            </div>


                        <?php endif; ?>

                    </div>



                    <!-- =====================================================
                         ACTIONS
                    ====================================================== -->

                    <div class="d-flex gap-2 mt-4 pt-3 border-top">


                        <!-- EDIT -->

                        <a
                            href="<?= base_url(
                                'students/edit/' . $student['id']
                            ) ?>"
                            class="btn btn-primary"
                        >

                            <i class="bi bi-pencil"></i>

                            Edit Student

                        </a>



                        <!-- BACK -->

                        <a
                            href="<?= base_url('students') ?>"
                            class="btn btn-outline-secondary"
                        >

                            <i class="bi bi-arrow-left"></i>

                            Back

                        </a>


                    </div>


                </div>

            </div>


        </div>

    </div>

</div>


</body>

</html>