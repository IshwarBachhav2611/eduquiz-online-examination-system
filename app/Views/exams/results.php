<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Examination Results - EduQuiz
    </title>


    <!-- Bootstrap 5 -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- Bootstrap Icons -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <style>

        body {
            background-color: #f8f9fa;
        }


        .stat-card {
            border: none;
            border-radius: 12px;
        }


        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
        }


        .table th {
            white-space: nowrap;
        }


        .table td {
            vertical-align: middle;
        }


        .rank-number {
            font-weight: 600;
        }


        .results-card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
        }


        .filter-card {
            border: none;
            border-radius: 12px;
        }


        .student-name {
            font-weight: 600;
        }


        .download-btn {
            width: 36px;
            height: 36px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;
        }


        .no-filter-results {
            display: none;
        }

    </style>

</head>


<body>


<div class="container-fluid px-4 py-4">


    <!-- =========================================================
         PAGE HEADER
         ========================================================= -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Examination Results
            </h3>

            <p class="text-muted mb-0">
                View student performance and merit list
            </p>

        </div>


        <div>

            <a href="<?= base_url('/exams') ?>"
               class="btn btn-outline-secondary">

                <i class="bi bi-arrow-left me-1"></i>

                Back to Examinations

            </a>

        </div>

    </div>



    <!-- =========================================================
         EXAM INFORMATION
         ========================================================= -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <h4 class="fw-bold mb-2">

                        <?= esc($exam['title']) ?>

                    </h4>


                    <div class="text-muted">

                        <span class="me-4">

                            <i class="bi bi-book me-1"></i>

                            <?= esc($exam['subject']) ?>

                        </span>


                        <span class="me-4">

                            <i class="bi bi-calendar-event me-1"></i>

                            <?= date(
                                'd M Y',
                                strtotime($exam['exam_date'])
                            ) ?>

                        </span>


                        <span>

                            <i class="bi bi-clock me-1"></i>

                            <?= date(
                                'h:i A',
                                strtotime($exam['start_time'])
                            ) ?>

                            -

                            <?= date(
                                'h:i A',
                                strtotime($exam['end_time'])
                            ) ?>

                        </span>

                    </div>

                </div>


                <div class="col-md-4 text-md-end mt-3 mt-md-0">

                    <span class="badge bg-success-subtle text-success px-3 py-2">

                        <i class="bi bi-check-circle me-1"></i>

                        Examination Completed

                    </span>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         STATISTICS
         ========================================================= -->

    <div class="row g-4 mb-4">


        <!-- Assigned Students -->

        <div class="col-xl-3 col-md-6">

            <div class="card stat-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Assigned Students
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?= esc($sharedCount) ?>

                            </h3>

                        </div>


                        <div class="stat-icon bg-primary-subtle text-primary">

                            <i class="bi bi-people"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- Submissions -->

        <div class="col-xl-3 col-md-6">

            <div class="card stat-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Submissions
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?= esc($totalSubmissions) ?>

                            </h3>


                            <small class="text-muted">

                                <?= esc($submissionPercentage) ?>%
                                submission rate

                            </small>

                        </div>


                        <div class="stat-icon bg-info-subtle text-info">

                            <i class="bi bi-file-earmark-check"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- Passed -->

        <div class="col-xl-3 col-md-6">

            <div class="card stat-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Passed
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?= esc($passed) ?>

                            </h3>


                            <small class="text-success">

                                <?= esc($passPercentage) ?>% pass rate

                            </small>

                        </div>


                        <div class="stat-icon bg-success-subtle text-success">

                            <i class="bi bi-check-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <!-- Failed -->

        <div class="col-xl-3 col-md-6">

            <div class="card stat-card shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Failed
                            </p>

                            <h3 class="fw-bold mb-0">

                                <?= esc($failed) ?>

                            </h3>


                            <small class="text-danger">

                                Students below passing marks

                            </small>

                        </div>


                        <div class="stat-icon bg-danger-subtle text-danger">

                            <i class="bi bi-x-circle"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         FILTERS
         ========================================================= -->

    <div class="card filter-card shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">


                <!-- Search -->

                <div class="col-lg-5 col-md-6">

                    <label
                        for="studentSearch"
                        class="form-label fw-semibold">

                        Search Student

                    </label>


                    <div class="input-group">

                        <span class="input-group-text bg-white">

                            <i class="bi bi-search"></i>

                        </span>


                        <input
                            type="text"
                            id="studentSearch"
                            class="form-control"
                            placeholder="Search by name or email..."
                        >

                    </div>

                </div>



                <!-- Department -->

                <div class="col-lg-3 col-md-6">

                    <label
                        for="departmentFilter"
                        class="form-label fw-semibold">

                        Department

                    </label>


                    <select
                        id="departmentFilter"
                        class="form-select">

                        <option value="all">
                            All Departments
                        </option>


                        <?php

                        $departments = [];

                        foreach ($submissions as $submission) {

                            $department = trim(
                                $submission['department'] ?? ''
                            );

                            if (
                                $department !== '' &&
                                !in_array(
                                    $department,
                                    $departments
                                )
                            ) {

                                $departments[] = $department;

                            }

                        }

                        sort($departments);

                        ?>


                        <?php foreach ($departments as $department): ?>

                            <option value="<?= esc(
                                strtolower($department)
                            ) ?>">

                                <?= esc($department) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>



                <!-- Result -->

                <div class="col-lg-2 col-md-6">

                    <label
                        for="resultFilter"
                        class="form-label fw-semibold">

                        Result

                    </label>


                    <select
                        id="resultFilter"
                        class="form-select">

                        <option value="all">
                            All Results
                        </option>

                        <option value="pass">
                            Pass
                        </option>

                        <option value="fail">
                            Fail
                        </option>

                    </select>

                </div>



                <!-- Reset -->

                <div class="col-lg-2 col-md-6">

                    <button
                        type="button"
                        id="resetFilters"
                        class="btn btn-outline-secondary w-100">

                        <i class="bi bi-arrow-counterclockwise me-1"></i>

                        Reset Filters

                    </button>

                </div>

            </div>

        </div>

    </div>



    <!-- =========================================================
         MERIT LIST
         ========================================================= -->

    <div class="card results-card shadow-sm">


        <!-- Card Header -->

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">

                        Student Merit List

                    </h5>


                    <small class="text-muted">

                        Students ranked according to their examination score

                    </small>

                </div>


                <!-- Overall Download -->

                <a
                    href="<?= base_url(
                        '/exams/results/merit-list/download/' . $exam['id']
                    ) ?>"
                    class="btn btn-outline-primary">

                    <i class="bi bi-file-earmark-pdf me-1"></i>

                    Download Merit List

                </a>

            </div>

        </div>



        <!-- =====================================================
             TABLE
             ===================================================== -->

        <div class="card-body p-0">


            <?php if (!empty($submissions)): ?>


                <div class="table-responsive">

                    <table
                        class="table table-hover mb-0"
                        id="resultsTable">


                        <thead class="table-light">

                            <tr>

                                <th class="ps-4">
                                    Rank
                                </th>

                                <th>
                                    Student
                                </th>

                                <th>
                                    Department
                                </th>

                                <th>
                                    Score
                                </th>

                                <th>
                                    Percentage
                                </th>

                                <th>
                                    Result
                                </th>

                                <th>
                                    Submitted At
                                </th>

                                <th class="text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>



                        <tbody>


                        <?php foreach ($submissions as $submission): ?>


                            <?php

                            $resultStatus = strtolower(
                                trim(
                                    $submission['result_status'] ?? ''
                                )
                            );

                            $isPassed = $resultStatus === 'pass';

                            $percentage =
                                $submission['percentage'] ?? 0;

                            $department =
                                trim(
                                    $submission['department'] ?? ''
                                );

                            ?>


                            <tr
                                class="result-row"
                                data-name="<?= esc(
                                    strtolower(
                                        $submission['name'] ?? ''
                                    )
                                ) ?>"
                                data-email="<?= esc(
                                    strtolower(
                                        $submission['email'] ?? ''
                                    )
                                ) ?>"
                                data-department="<?= esc(
                                    strtolower(
                                        $department
                                    )
                                ) ?>"
                                data-result="<?= $isPassed
                                    ? 'pass'
                                    : 'fail'
                                ?>">


                                <!-- Rank -->

                                <td class="ps-4">

                                    <span class="rank-number">

                                        #<?= esc(
                                            $submission['merit_rank']
                                        ) ?>

                                    </span>

                                </td>



                                <!-- Student -->

                                <td>

                                    <div class="student-name">

                                        <?= esc(
                                            $submission['name']
                                        ) ?>

                                    </div>


                                    <small class="text-muted">

                                        <?= esc(
                                            $submission['email']
                                        ) ?>

                                    </small>

                                </td>



                                <!-- Department -->

                                <td>

                                    <?php if (
                                        !empty($department)
                                    ): ?>

                                        <?= esc($department) ?>

                                    <?php else: ?>

                                        <span class="text-muted">

                                            Not specified

                                        </span>

                                    <?php endif; ?>

                                </td>



                                <!-- Score -->

                                <td>

                                    <span class="fw-semibold">

                                        <?= esc(
                                            $submission['score'] ?? 0
                                        ) ?>

                                        /

                                        <?= esc(
                                            $exam['total_marks']
                                        ) ?>

                                    </span>

                                </td>



                                <!-- Percentage -->

                                <td>

                                    <?= esc($percentage) ?>%

                                </td>



                                <!-- Result -->

                                <td>

                                    <?php if ($isPassed): ?>

                                        <span class="badge bg-success-subtle text-success px-3 py-2">

                                            <i class="bi bi-check-circle me-1"></i>

                                            Pass

                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">

                                            <i class="bi bi-x-circle me-1"></i>

                                            Fail

                                        </span>

                                    <?php endif; ?>

                                </td>



                                <!-- Submitted At -->

                                <td>

                                    <?php if (
                                        !empty(
                                            $submission['submitted_at']
                                        )
                                    ): ?>

                                        <?= date(
                                            'd M Y, h:i A',
                                            strtotime(
                                                $submission['submitted_at']
                                            )
                                        ) ?>

                                    <?php else: ?>

                                        <span class="text-muted">
                                            —
                                        </span>

                                    <?php endif; ?>

                                </td>



                                <!-- Individual Download -->

                                <td class="text-center">

                                    <a
                                        href="<?= base_url(
                                            '/exams/results/download/' .
                                            $submission['id']
                                        ) ?>"
                                        class="btn btn-outline-primary btn-sm download-btn"
                                        title="Download Student Result">

                                        <i class="bi bi-download"></i>

                                    </a>

                                </td>


                            </tr>


                        <?php endforeach; ?>


                        </tbody>

                    </table>

                </div>



                <!-- =================================================
                     NO FILTER RESULTS
                     ================================================= -->

                <div
                    id="noFilterResults"
                    class="no-filter-results text-center py-5">

                    <div class="fs-1 text-muted mb-3">

                        <i class="bi bi-search"></i>

                    </div>


                    <h5 class="fw-semibold">

                        No students found

                    </h5>


                    <p class="text-muted mb-0">

                        Try changing your search or filter options.

                    </p>

                </div>


            <?php else: ?>


                <!-- =================================================
                     NO SUBMISSIONS
                     ================================================= -->

                <div class="text-center py-5">

                    <div class="fs-1 text-muted mb-3">

                        <i class="bi bi-inbox"></i>

                    </div>


                    <h5 class="fw-semibold">

                        No submissions yet

                    </h5>


                    <p class="text-muted mb-0">

                        No students submitted this examination.

                    </p>

                </div>


            <?php endif; ?>


        </div>

    </div>

</div>
<?= view('layouts/footer') ?>


<!-- =============================================================
     FILTER JAVASCRIPT
     ============================================================= -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('studentSearch');

    const departmentFilter =
        document.getElementById('departmentFilter');

    const resultFilter =
        document.getElementById('resultFilter');

    const resetButton =
        document.getElementById('resetFilters');

    const rows =
        document.querySelectorAll('.result-row');

    const noFilterResults =
        document.getElementById('noFilterResults');


    function applyFilters() {

        const searchValue =
            searchInput.value
                .trim()
                .toLowerCase();

        const departmentValue =
            departmentFilter.value
                .toLowerCase();

        const resultValue =
            resultFilter.value
                .toLowerCase();


        let visibleRows = 0;


        rows.forEach(function (row) {

            const name =
                row.dataset.name || '';

            const email =
                row.dataset.email || '';

            const department =
                row.dataset.department || '';

            const result =
                row.dataset.result || '';


            const matchesSearch =
                name.includes(searchValue) ||
                email.includes(searchValue);


            const matchesDepartment =
                departmentValue === 'all' ||
                department === departmentValue;


            const matchesResult =
                resultValue === 'all' ||
                result === resultValue;


            if (
                matchesSearch &&
                matchesDepartment &&
                matchesResult
            ) {

                row.style.display = '';

                visibleRows++;

            } else {

                row.style.display = 'none';

            }

        });


        if (noFilterResults) {

            if (visibleRows === 0) {

                noFilterResults.style.display = 'block';

            } else {

                noFilterResults.style.display = 'none';

            }

        }

    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            applyFilters
        );

    }


    if (departmentFilter) {

        departmentFilter.addEventListener(
            'change',
            applyFilters
        );

    }


    if (resultFilter) {

        resultFilter.addEventListener(
            'change',
            applyFilters
        );

    }


    if (resetButton) {

        resetButton.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                departmentFilter.value = 'all';

                resultFilter.value = 'all';

                applyFilters();

            }
        );

    }

});

</script>



<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>