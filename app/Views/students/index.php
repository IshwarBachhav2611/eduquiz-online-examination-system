<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Management | EduQuiz</title>

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
            padding: 35px 0;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-header p {
            color: #64748b;
            margin: 0;
        }

        .management-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }

        .card-toolbar {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            align-items: center;
        }

        .filters {
            display: flex;
            gap: 10px;
            flex: 1;
        }

        .search-box {
            position: relative;
            max-width: 350px;
            width: 100%;
        }

        .search-box i {
            position: absolute;
            left: 13px;
            top: 11px;
            color: #94a3b8;
        }

        .search-box input {
            padding-left: 38px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .student-table {
            margin: 0;
            min-width: 700px;
        }

        .student-table th {
            background: #f8fafc;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            padding: 14px 18px;
            white-space: nowrap;
        }

        .student-table td {
            padding: 15px 18px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }

        .student-name {
            font-weight: 600;
        }

        .student-email {
            color: #64748b;
            font-size: 13px;
        }

        .department-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 10px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }

        .action-buttons .btn {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            margin: auto auto 15px;
            border-radius: 15px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .empty-state h4 {
            font-weight: 700;
        }

        .empty-state p {
            color: #64748b;
        }

        @media (max-width: 768px) {

            .page-wrapper {
                padding: 20px 0;
            }

            .page-header h1 {
                font-size: 23px;
            }

            .card-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .filters {
                flex-direction: column;
            }

            .search-box {
                max-width: none;
            }

            .add-btn {
                width: 100%;
            }

        }

    </style>

</head>
<!-- =========================================================
     UPLOAD STUDENT LIST MODAL
========================================================= -->

<div
    class="modal fade"
    id="uploadStudentsModal"
    tabindex="-1"
    aria-labelledby="uploadStudentsModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>

                    <h5
                        class="modal-title"
                        id="uploadStudentsModalLabel"
                    >

                        <i class="bi bi-upload me-2"></i>

                        Upload Student List

                    </h5>

                    <small class="text-muted">
                        Add multiple students using a CSV file.
                    </small>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <form
                action="<?= base_url('students/import') ?>"
                method="post"
                enctype="multipart/form-data"
            >

                <?= csrf_field() ?>


                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="studentFile"
                            class="form-label"
                        >
                            Student List
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="studentFile"
                            name="student_file"
                            accept=".csv"
                            required
                        >

                        <div class="form-text">

                            Upload a CSV file containing:

                            <strong>
                                name,email,department
                            </strong>

                        </div>

                    </div>


                    <div class="alert alert-light border">

                        <i class="bi bi-info-circle me-1"></i>

                        Example CSV format:

                        <br>

                        <code>
                            name,email,department
                        </code>

                        <br>

                        <code>
                            John Doe,john@gmail.com,MCA
                        </code>

                    </div>

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >

                        Cancel

                    </button>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-upload me-1"></i>

                        Upload Students

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<body>

<div class="page-wrapper">

    <div class="container">

        <!-- STUDENT CREDENTIALS -->
        <?php if (session()->getFlashdata('student_credentials')): ?>

            <?php $credentials = session()->getFlashdata('student_credentials'); ?>

            <div class="alert alert-success border-0 shadow-sm mb-4">

                <div class="d-flex gap-3">

                    <div class="fs-4">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div class="flex-grow-1">

                        <h6 class="fw-bold mb-1">
                            Student Added Successfully
                        </h6>

                        <p class="mb-3">
                            Login credentials have been generated for this student.
                        </p>

                        <div class="bg-white border rounded p-3">

                            <div class="mb-2">
                                <small class="text-muted d-block">
                                    Student Login Email
                                </small>

                                <strong>
                                    <?= esc($credentials['email']) ?>
                                </strong>
                            </div>

                            <div>
                                <small class="text-muted d-block">
                                    Temporary Password
                                </small>

                                <strong>
                                    <?= esc($credentials['password']) ?>
                                </strong>
                            </div>

                        </div>

                        <small class="text-muted d-block mt-2">
                            Save these credentials. Email delivery will be added later.
                        </small>

                    </div>

                </div>

            </div>

        <?php endif; ?>

        <!-- HEADER -->
        <div class="page-header">

            <div class="d-flex justify-content-between align-items-start gap-3">

                <div>

                    <h1>
                        Student Management
                    </h1>

                    <p>
                        Manage the students registered under your account.
                    </p>

                </div>


                <div class="d-flex gap-2 flex-wrap">

                    <!-- Dashboard -->

                    <a
                        href="<?= base_url('dashboard') ?>"
                        class="btn btn-outline-secondary"
                    >

                        <i class="bi bi-arrow-left me-1"></i>

                        Dashboard

                    </a>


                    <!-- Upload Student List -->

                    <button
                        type="button"
                        class="btn btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#uploadStudentsModal"
                    >

                        <i class="bi bi-upload me-1"></i>

                        Upload Student List

                    </button>


                    <!-- Add Student -->

                    <a
                        href="<?= base_url('students/create') ?>"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-person-plus me-1"></i>

                        Add Student

                    </a>

                </div>

            </div>

        </div>
        <!-- CARD -->

        <div class="management-card">


            <!-- TOOLBAR -->

            <div class="card-toolbar">

                <div class="filters">

                    <!-- SEARCH -->

                    <div class="search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="studentSearch"
                            class="form-control"
                            placeholder="Search students..."
                        >

                    </div>


                    <!-- DEPARTMENT -->

                    <select
                        id="departmentFilter"
                        class="form-select"
                        style="max-width: 220px;"
                    >

                        <option value="all">
                            All Departments
                        </option>

                        <?php

                        $departments = [];

                        foreach ($students as $student) {

                            if (!empty($student['department'])) {

                                $departments[] =
                                    trim($student['department']);

                            }

                        }

                        $departments = array_unique($departments);

                        natcasesort($departments);

                        ?>

                        <?php foreach ($departments as $department): ?>

                            <option value="<?= esc($department) ?>">
                                <?= esc($department) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>


            <?php if (!empty($students)): ?>


                <!-- TABLE -->

                <div class="table-wrapper">

                    <table class="table student-table">

                        <thead>

                            <tr>

                                <th>
                                    Student
                                </th>

                                <th>
                                    Email
                                </th>

                                <th>
                                    Department
                                </th>

                                <th class="text-end">
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody id="studentTableBody">

                            <?php foreach ($students as $student): ?>

                                <tr
                                    class="student-row"
                                    data-name="<?= esc(strtolower($student['name'])) ?>"
                                    data-email="<?= esc(strtolower($student['email'])) ?>"
                                    data-department="<?= esc(strtolower($student['department'] ?? '')) ?>"
                                >

                                    <td>

                                        <div class="student-name">

                                            <?= esc($student['name']) ?>

                                        </div>

                                    </td>


                                    <td>

                                        <span class="student-email">

                                            <?= esc($student['email']) ?>

                                        </span>

                                    </td>


                                    <td>

                                        <?php if (!empty($student['department'])): ?>

                                            <span class="department-badge">

                                                <i class="bi bi-building"></i>

                                                <?= esc($student['department']) ?>

                                            </span>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                No Department
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <td>

                                        <div class="action-buttons justify-content-end">

                                            <!-- VIEW -->
                                            <a
                                                href="<?= base_url('students/view/' . $student['id']) ?>"
                                                class="btn btn-outline-secondary btn-sm"
                                                title="View Student"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>


                                            <!-- REMOVE FROM MY STUDENTS -->
                                            <form
                                                action="<?= base_url('students/delete/' . $student['id']) ?>"
                                                method="post"
                                                onsubmit="return confirm(
                                                    'Remove this student from your student list? The student account and all exam history will remain in EduQuiz.'
                                                );"
                                            >
                                                <?= csrf_field() ?>

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm"
                                                    title="Remove from My Students"
                                                >
                                                    <i class="bi bi-person-dash"></i>
                                                </button>
                                            </form>                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>


                <!-- NO SEARCH RESULT -->

                <div
                    id="noResult"
                    class="empty-state"
                    style="display:none;"
                >

                    <div class="empty-icon">

                        <i class="bi bi-search"></i>

                    </div>

                    <h4>
                        No Students Found
                    </h4>

                    <p>
                        Try changing your search or department filter.
                    </p>

                </div>


            <?php else: ?>


                <!-- EMPTY -->

                <div class="empty-state">

                    <div class="empty-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <h4>
                        No Students Yet
                    </h4>

                    <p>
                        Add your first student to start managing students.
                    </p>

                    <a
                        href="<?= base_url('students/create') ?>"
                        class="btn btn-primary"
                    >

                        <i class="bi bi-person-plus me-1"></i>

                        Add Student

                    </a>

                </div>


            <?php endif; ?>


        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const search =
        document.getElementById('studentSearch');

    const filter =
        document.getElementById('departmentFilter');

    const rows =
        document.querySelectorAll('.student-row');

    const noResult =
        document.getElementById('noResult');


    function filterStudents() {

        const searchText =
            search.value.toLowerCase().trim();

        const department =
            filter.value.toLowerCase().trim();

        let visible = 0;


        rows.forEach(function (row) {

            const name =
                row.dataset.name || '';

            const email =
                row.dataset.email || '';

            const rowDepartment =
                row.dataset.department || '';


            const matchesSearch =
                name.includes(searchText) ||
                email.includes(searchText);

            const matchesDepartment =
                department === 'all' ||
                rowDepartment === department;


            if (matchesSearch && matchesDepartment) {

                row.style.display = '';

                visible++;

            } else {

                row.style.display = 'none';

            }

        });


        if (noResult) {

            noResult.style.display =
                visible === 0 ? 'block' : 'none';

        }

    }


    search.addEventListener(
        'input',
        filterStudents
    );


    filter.addEventListener(
        'change',
        filterStudents
    );

});

</script>

</body>

</html>